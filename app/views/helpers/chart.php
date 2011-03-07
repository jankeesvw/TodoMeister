<?php
class ChartHelper extends AppHelper {
	
	function pieChart($values,$labels,$title = ""){

		$values_str = implode($values,",");
		$labels_str = implode($labels,"|");
		$title_str = implode(explode(" ",$title),"+");		

		$chart = "<img src=\"";		
		$chart .= "http://chart.apis.google.com/chart";
		$chart .= "?chs=300x225";
		$chart .= "&cht=p";
		$chart .= "&chd=t:".$values_str;
		$chart .= "&chdl=".$labels_str;
		$chart .= "&chtt=".$title_str;
		$chart .= "\" width=\"300px\" height=\"225px\"  />";
		return $chart;
	}
	
	function lineChart($values,$labels,$title = ""){
		
		$values_str = implode($values,",");
		$labels_str = implode($labels,"|");
		$title_str = implode(explode(" ",$title),"+");
		
		$chart = "<img src=\"";
		$chart .= "http://chart.apis.google.com/chart";
		$chart .= "?chxl=0:|".$labels_str;
		$chart .= "&chxr=0,5,100";
		$chart .= "&chxt=x,y";
		$chart .= "&chbh=a";
		$chart .= "&chs=300x150";
		$chart .= "&cht=bvg";
		$chart .= "&chco=76A4FB";
		$chart .= "&chd=t:".$values_str;
		$chart .= "&chg=20,50";
		$chart .= "&chtt=".$title_str;
		$chart .= "\" width=\"300px\" height=\"150px\" />";
		return $chart;
	}
}
?>