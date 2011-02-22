<?php
class RelativeTimeHelper extends AppHelper {
		function plural($num) {
		 	if ($num != 1) return "s";
		}
	
		function getRelativeTime($date) {
			 $diff = time() - strtotime($date);
			return $this->relativeTime($diff);
			
		}
		
		function relativeTime($diff){
			 if ($diff<60) return $diff . " second" . $this->plural($diff);
			 
			$diff = round($diff/60); 
			if ($diff<60) return $diff . " minute" . $this->plural($diff);

			$diff = round($diff/60);
 			if ($diff<24) return $diff . " hour" . $this->plural($diff);
			 
			$diff = round($diff/24);
			if ($diff<7) return $diff . " day" . $this->plural($diff);
			$diff = round($diff/7);
            
			if ($diff<4) return $diff . " week" . $this->plural($diff);
			return "on " . date("F j, Y", strtotime($date));
		}
}
?>
