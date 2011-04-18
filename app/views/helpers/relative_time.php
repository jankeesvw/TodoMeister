<?php
class RelativeTimeHelper extends AppHelper {

		function getRelativeTime($date) {
			return $this->relativeTime(time() - strtotime($date),$date);
		}
		
		function relativeTime($diff,$date = ""){
			if ($diff < 60){
				return $diff . " second" . $this->plural($diff) . " ago";
			}
			 
			$diff = round($diff/60); 
			if ($diff < 60){
				return $diff . " minute" . $this->plural($diff) . " ago";	
			} 

			$diff = round($diff/60);
 			if ($diff < 24){
				return $diff . " hour" . $this->plural($diff) . " ago";
			} 
			 
			$diff = round($diff/24);
			if ($diff < 7){
				return $diff . " day" . $this->plural($diff) . " ago";
			} 

			$diff = round($diff/7);            
			if ($diff < 4){
				return $diff . " week" . $this->plural($diff) . " ago";
			} 
			
			return "on " . date("F j, Y", strtotime($date));
		}
		
		function plural($num) {
		 	if ($num != 1){
			 	return "s";
			}
		}
}
?>
