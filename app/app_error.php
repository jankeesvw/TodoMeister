<?php
class AppError extends ErrorHandler {
	
	public function missingController($params) {
 		$this->controller->redirect('/');
 	}
 	public function missingAction($params) {
		$this->controller->redirect('/');
 	}
}
?>