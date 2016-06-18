<?php
class Analysis {
	private $sem;
	private $dept;
	private $batch;
	private $dbc;
	public function __construct($dept, $batch, $sem, $connector) {
		$this->dept = $dept;
		$this->batch = $batch;
		$this->sem = $sem;
		$this->dbc = $connector;
	}
	public function perSubject($test, $subject) {
		$rlt25 = 0;
		$r2545 = 0;
		$r4560 = 0;
		$r6075 = 0;
		$r7590 = 0;
		$rgt90 = 0;
		$absen = 0;
		$fulst = 0;
		$rgt50 = 0;
		
		$query = "SELECT " . $test . " FROM st_marks WHERE dept = '" . $this->dept . "' AND batch = '" . $this->batch . "' ";
		$query .= "AND sem = '" . $this->sem . "' AND subject = '" . $subject . "'";
		$result = mysqli_query ( $this->dbc, $query ) or die ( mysqli_error ( $this->dbc ) );
		if ($row = mysqli_fetch_row ( $result )) {
			do {
				$fulst += 1;
				$a = $row [0];
				if ($a > 90 || $a == -2)
					$rgt90 += 1;
				else if ($a > 75 || $a == -3 || $a == -4)
					$r7590 += 1;
				else if ($a > 60 || $a == -5 || $a == -6)
					$r6075 += 1;
				else if ($a > 45 || $a == -7)
					$r4560 += 1;
				else if ($a > 25 || $a == -8)
					$r2545 += 1;
				else if ($a >= 0)
					$rlt25 += 1;
				else if ($a < 0 || $a == -8)
					$absen += 1;
				if ($a >= 50 || ($a != -8 && $a != -1))
					$rgt50 += 1;
			} while ( $row = mysqli_fetch_row ( $result ) );
			echo "<table class='analysis'><tr>";
			echo "<td>&lt; 25</td><td>26 - 45</td><td>46 - 60</td><td>61 - 75</td><td>76 - 90</td><td>&gt; 90</td><td>Absentees</td></tr><tr>";
			echo "<td>" . $rlt25 . "</td><td>" . $r2545 . "</td><td>" . $r4560 . "</td><td>" . $r6075 . "</td>";
			echo "<td>" . $r7590 . "</td><td>" . $rgt90 . "</td><td>" . $absen . "</td></tr>";
			echo "<tr><td colspan='7'></td></tr>";
			echo "<tr><td colspan='3' style='background-color: #300; color: #fff'>Class Pass Percentage</td>";
			echo "<td colspan='4'>" . round ( ($rgt50 / $fulst * 100), 2 ) . " %</td></tr>";
			echo "<tr><td colspan='3' style='background-color: #300; color: #fff'>Class Pass Percentage (Excluding Absentees)</td>";
			echo "<td colspan='4'>" . round ( ($rgt50 / (($fulst - $absen)?($fulst - $absen):1) * 100), 2 ) . " %</td></tr>";
			echo "</table>";
		} else
			echo "<div class='alert'>Sorry! No record found!!</div>";
	}
	public function perStudent($test) {
		$query = "SELECT roll FROM st_marks GROUP BY roll";
		$rolls = array ();
		$result = mysqli_query ( $this->dbc, $query ) or die ( mysqli_error ( $this->dbc ) );
		while ( $row = mysqli_fetch_row ( $result ) )
			$rolls [] = $row [0];
		if (count ( $rolls ) > 0) {
			$allpas = 0;
			$onearr = 0;
			$twoarr = 0;
			$thrarr = 0;
			$gtrarr = 0;
			foreach ( $rolls as $roll ) {
				$query = "SELECT " . $test . " FROM st_marks WHERE dept = '" . $this->dept . "' AND batch = '" . $this->batch . "' ";
				$query .= "AND sem = '" . $this->sem . "' AND roll = '" . $roll . "'";
				$result = mysqli_query ( $this->dbc, $query ) or die ( mysqli_error ( $this->dbc ) );
				$count = 0;
				while ( $row = mysqli_fetch_row ( $result ) )
					if ($row [0] < 50)
						$count += 1;
				switch ($count) {
					case 0 :
						$allpas += 1;
						break;
					case 1 :
						$onearr += 1;
						break;
					case 2 :
						$twoarr += 1;
						break;
					case 3 :
						$thrarr += 1;
						break;
					default :
						$gtrarr += 1;
				}
			}
			echo "<table class='analysis'><tr>";
			echo "<td l>All Pass</td><td l>One Arrear</td><td l>Two Arrears</td><td l>Three Arrears</td><td l>More than three Arrears</td></tr>";
			echo "<tr><td>" . $allpas . "</td><td>" . $onearr . "</td><td>" . $twoarr . "</td><td>" . $thrarr . "</td><td>" . $gtrarr . "</td>";
			echo "<tr><td colspan='5'></td></tr>";
			echo "<tr><td colspan='3' style='background-color: #300; color: #fff'>Overall Class Pass Percentage</td>";
			echo "<td colspan='2'>" . round ( ($allpas / count ( $rolls ) * 100), 2 ) . " %</td></tr>";
			echo "</tr></table>";
		}
	}
}
?>