<?php

class Attendance {
    private $dept;
    private $batch;
    private $dbc;
    private $fromDate;
    private $toDate;
    private $subject;
    private $dispSub = FALSE;

    public function __construct($dept, $batch, $fromDate, $toDate, $connector) {
        $this->dept = $dept;
        $this->batch = $batch;
        $this->dbc = $connector;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
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
    private function countToTotal($condition = "") {
        $query = "SELECT count(*) FROM st_attendance WHERE dept= '".$this->dept."' AND batch= '".$this->batch."' ".$condition;
        $result = mysqli_query($this->dbc, $query) or die(mysqli_error($this->dbc));
        if($row = mysqli_fetch_row($result)) return $row[0];
        return 1;
    }
    private function generateTableRows($num, $total, $count, $expan, $index) {
         
         echo "<div class='row'>".($expan?"<div d class='expan' data-row='$index' style='width: 40px'>&nbsp;</div>":"").
              "<div d>".($this->dispSub?$this->subject:($this->batch % 100)." ".$this->dept." ".
              ( intval($num) < 10 ? "00" : (intval ($num) < 100 ? "0" : "" )).$num)."</div>".
              "<div d style='width: 175px'>".$total."</div><div d style='width: 175px'>".($total - $count)."</div> ";
         $percent = round((($total - $count)/$total*100),2);
         echo "<div d style='width: 175px'>".($percent >= 75 ? "<span bb>": "<span rr>").$percent."%</span></div></div>";
         echo "<hr style='border: 1px solid #eee'>";
    }
    private function generateTable($query, $range, $clause, $expan = FALSE) {  
        $number = $this->constructArray($range);
        $qSub = "SELECT subject FROM st_attendance WHERE dept= '".$this->dept."' AND batch= '".$this->batch."'".
                " AND date between '".$this->fromDate."' AND '".$this->toDate."' GROUP BY subject";
        $rSub = mysqli_query($this->dbc, $qSub) or die(mysqli_error($this->dbc));
        $result = mysqli_query($this->dbc, $query) or die(mysqli_error($this->dbc));
        if($row = mysqli_fetch_row($result)) {
            $total = $this->countToTotal($clause);
            for($i = 0; $i < count($number); ++$i) {
                $count = 0;
                do {
                    $wholerange = array_unique($this->constructArray($row[0]));
                    if(in_array($number[$i], $wholerange)) $count += 1;
                } while($row = mysqli_fetch_row($result));
                mysqli_data_seek($result, 0);
                $this->generateTableRows($number[$i], $total, $count, $expan, $i);

                if($expan) {
                    echo "<div style='padding: 2px 0px 20px 50px; display: none; float: left' class='toExpand' data-row='".$i."'>";
                    if($roSub = mysqli_fetch_row($rSub)) {
                        echo "<div hl>Subject</div><div hl style='width: 175px'>Total Periods</div>".
                             "<div hl style='width: 175px'>Periods Attended</div>".
                             "<div hl style='width: 175px'>Attendance Percentage</div>";
                        $this->dispSub = TRUE;
                        do {
                            $this->subject = $roSub[0];
                            $this->generateTable($query." AND subject = '".$roSub[0]."'", 
                                                $number[$i] ,$clause." AND subject = '".$roSub[0]."'");
                        } while($roSub = mysqli_fetch_row($rSub));
                        mysqli_data_seek($rSub, 0);
                        $this->dispSub = FALSE;
                    }
                    echo "</div>";
                }
            }
        }
        else echo "<span r>No Records Found!</span>";
    }
    private function displayTableHeader($expan = FALSE) {
        echo "<div class='table'><div class='row'>";
        echo $expan?"<div h style='width: 40px'>&nbsp;</div>":"";
        echo "<div h>Roll Number</div><div h style='width: 175px'>Total Periods</div>".
             "<div h style='width: 175px'>Periods Attended</div>".
             "<div h style='width: 175px'>Attendance Percentage</div>";
        echo "<div h style='width: ".($expan?"40":"100")."px'>&nbsp;</div></div>";
    }
    public function perStudent($range) {    
        $clause = " AND date between '".$this->fromDate."' and '".$this->toDate."'";
        $query = "SELECT abs FROM st_attendance WHERE dept= '".$this->dept."' AND batch= '".$this->batch."' ".$clause;
        $this->displayTableHeader(TRUE);
        $this->generateTable($query, $range, $clause, TRUE);
        echo "</div>";
    }
    public function perSubject($range, $subject) {                
        $clause = " AND subject = '".$subject."' AND date between '".$this->fromDate."' AND '".$this->toDate."'";
        $query = "SELECT abs FROM st_attendance WHERE dept= '".$this->dept."' AND batch= '".$this->batch."' ".$clause;
        $this->displayTableHeader();
        $this->generateTable($query, $range, $clause);
        echo "</div>";
    }
    public function genCSText($range) {
        $clause = " AND date between '".$this->fromDate."' and '".$this->toDate."'";
        $query = "SELECT abs FROM st_attendance WHERE dept= '".$this->dept."' AND batch= '".$this->batch."' ".$clause;
        $number = $this->constructArray($range);
        $result = mysqli_query($this->dbc, $query) or die(mysqli_error($this->dbc));
        $out = '';
        if($row = mysqli_fetch_row($result)) {
            $out = '"Roll Number","Total Periods","Periods Attended","Attendance Percentage"'."\n";
            $total = $this->countToTotal($clause);
            for($i = 0; $i < count($number); ++$i) {
                $num = $number[$i];
                $count = 0;
                do {
                    $wholerange = array_unique($this->constructArray($row[0]));
                    if(in_array($number[$i], $wholerange)) $count += 1;
                } while($row = mysqli_fetch_row($result));
                mysqli_data_seek($result, 0);
                $out .= '"'.($this->batch % 100).' '
                           .$this->dept.' '.( intval($num) < 10 ? "00" : (intval ($num) < 100 ? "0" : "" ))
                           .$num.'","'.$total.'","'.($total - $count).'","';
                $out .= round((($total - $count)/$total*100),2).'%"'."\n";
            }
            $fi = fopen("AttReport.csv","w+");
            fwrite($fi,$out);
            return "AttReport.csv";
        }
        else return NULL;
    }
}
?>