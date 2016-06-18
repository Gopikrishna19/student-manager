<?php

class Mark {
    private $sem;
    private $dept;
    private $batch;

    private $subject;
    private $dbc;
    private $dispSub = FALSE;

    public function __construct($dept, $batch, $sem, $connector) {
        $this->dept = $dept;
        $this->batch = $batch;
        $this->sem = $sem;
        $this->dbc = $connector;
        
    }
    private function constructArray($range) {
        $numbers = array();
        $a1 = explode(",",$range);
        for($i=0; $i<count($a1); ++$i){
            if(preg_match('/[0-9]{1,3}-[0-9]{1,3}/',$a1[$i]))
            {
                $a2 = explode("-",$a1[$i]);
                for($j=$a2[0];$j<=$a2[1];++$j) $numbers[] = $j;
            }
            else $numbers[] = $a1[$i];
        }
        return array_unique($numbers);
    }
    private function generateTableRows($num, $row, $expan, $index, $main = TRUE) {
         echo "<div class='row'>".($expan?"<div d class='expan' data-row='$index' style='width: 40px'>&nbsp;</div>":"").
              "<div d style='width: ".($main?"125px":"75px")."'>".($this->dispSub?$this->subject:($this->batch % 100)." ".$this->dept." ".
              ( intval($num) < 10 ? "00" : (intval ($num) < 100 ? "0" : "" )).$num)."</div>";
         $cols = "";
         if(!$expan) 
         	for($i=5;$i<14;++$i) {
         	$m = $row[$i];
         	switch($m)
         	{
         		case "-1": $m="AB"; break;
         		case "-2": $m="S"; break;
         		case "-3": $m="A"; break;
         		case "-4": $m="B"; break;
         		case "-5": $m="C"; break;
         		case "-6": $m="D"; break;
         		case "-7": $m="E"; break;
         		case "-8": $m="U"; break;
         	}
         	$c="bb"; 
         	$p="%";        	
         	if($row[$i] < 0)
         	{
         		$p = "";
         		if($row[$i] == -1 || $row[$i] == -8) $c = "rr";
         		else $c = "bb";
         	}
         	else if($row[$i] < 50) $c = "rr"; 
         	$cols.="<div d style='width: 75px'><span ".$c.">".$m.$p."</span></div>";
         }
         echo $cols;
         echo "</div>";
         echo "<hr style='border: 1px solid #eee'>";
    }
    private function generateTable($query, $range, $expan = FALSE) { //perStudent        
        $number = $this->constructArray($range);
        $qSub = "SELECT subject FROM st_marks WHERE dept= '".$this->dept."' AND batch= '".$this->batch."'".
                " AND sem = '".$this->sem."' GROUP BY subject";
        $rSub = mysqli_query($this->dbc, $qSub) or die(mysqli_error($this->dbc));
        for($i = 0; $i < count($number); ++$i) {
            if(!$expan){
                $query2 = $query." AND roll='".$number[$i]."'";
                $result = mysqli_query($this->dbc, $query2) or die(mysqli_error($this->dbc));
                if($row = mysqli_fetch_row($result)) {
                    do {
                        $this->generateTableRows($number[$i],$row,FALSE,$i);
                    } while($row = mysqli_fetch_row($result));
                }    
            }
            else {
                $this->generateTableRows($number[$i],"",TRUE,$i);
                echo "<div style='padding: 2px 0px 20px 50px; display: none; float: left' class='toExpand' data-row='".$i."'>";
                if($rs = mysqli_fetch_row($rSub)) {
                    echo "<div class='table'><div class='row'>";
                    echo "<div hl style='width: 75px'>Subject</div>";
                    echo "<div hl style='width: 75px'>Test 1</div>".
                         "<div hl style='width: 75px'>Test 2</div>".
                         "<div hl style='width: 75px'>Test 3</div>".
                         "<div hl style='width: 75px'>Test 4</div>".
                         "<div hl style='width: 75px'>Test 5</div>".
                         "<div hl style='width: 75px'>Model 1</div>".
                         "<div hl style='width: 75px'>Model 2</div>".
                         "<div hl style='width: 75px'>Model 3</div>".
                         "<div hl style='width: 75px'>University</div>";
                    echo "</div>";
                    do {
                        $query2 = $query." AND roll = '".$number[$i]."' AND subject = '".$rs[0]."'";
                        $this->subject = $rs[0];
                        $result = mysqli_query($this->dbc, $query2) or die(mysqli_error($this->dbc));
                        if($row = mysqli_fetch_row($result)){
                            $this->dispSub=TRUE;
                            $this->generateTableRows($number[$i],$row,FALSE,$i,FALSE);   
                        }
                    } while($rs = mysqli_fetch_row($rSub));
                    mysqli_data_seek($rSub,0);
                    echo "</div>";
                }
                echo "</div>";
                $this->dispSub = FALSE;
            }
        }
    }
    private function displayTableHeader($expan = FALSE) {
        echo "<div class='table'><div class='row'>";
        echo $expan?"<div h style='width: 40px'>&nbsp;</div>":"";
        echo "<div h style='width: ".($expan?"840px'":"125px")."'>Roll Number</div>";
        echo $expan?"":"<div h style='width: 75px'>Test 1</div>".
                       "<div h style='width: 75px'>Test 2</div>".
                       "<div h style='width: 75px'>Test 3</div>".
                       "<div h style='width: 75px'>Test 4</div>".
                       "<div h style='width: 75px'>Test 5</div>".
                       "<div h style='width: 75px'>Model 1</div>".
                       "<div h style='width: 75px'>Model 2</div>".
                       "<div h style='width: 75px'>Model 3</div>".
                       "<div h style='width: 75px'>University</div>";
        echo "</div>";
    }
    public function perStudent($range) {    
        $query = "SELECT * FROM st_marks WHERE dept= '".$this->dept."' AND batch= '".$this->batch."' "
                ."AND sem = '".$this->sem."'";
        $this->displayTableHeader(TRUE);
        $this->generateTable($query, $range, TRUE);
        echo "</div>";
    }
    public function perSubject($range, $subject) {                
        $query = "SELECT * FROM st_marks WHERE dept= '".$this->dept."' AND batch= '".$this->batch."' "
                ."AND subject = '".$subject."' AND sem = '".$this->sem."'";
        $this->displayTableHeader();
        $this->generateTable($query, $range);
        echo "</div>";
    }
    public function genCSText($range,$subject) {        
        $query = "SELECT * FROM st_marks WHERE dept= '".$this->dept."' AND batch= '".$this->batch."' ".
                 "AND sem = '".$this->sem."' AND subject = '".$subject."' ";        
        $number = $this->constructArray($range);
        $out = '"Roll Number","Test 1","Test 2","Test 3","Test 4","Test 5","Model 1","Model 2","Model 3","University"'."\n";
        for($i = 0; $i < count($number); ++$i) {
            $num = $number[$i];
            $query2 = $query." AND roll = '".$num."'";
            $result = mysqli_query($this->dbc, $query2) or die(mysqli_error($this->dbc));
            if($row = mysqli_fetch_row($result)) {
                $out .= '"'.($this->batch % 100).' '
                           .$this->dept.' '.( intval($num) < 10 ? "00" : (intval ($num) < 100 ? "0" : "" ))
                           .$num.'","'.$row[5].'%","'.$row[6].'%","'.$row[7].'%","'.$row[8].'%","'.$row[9].'%","'
                           .$row[10].'%","'.$row[11].'%","'.$row[12].'%","'.$row[13].'%"'."\n";
                
            }
        }
        $fi = fopen("MarkReport.csv","w+");
        fwrite($fi,$out);
        return "MarkReport.csv";
    }
}
?>