<?php 

class IgreController extends BaseController
{
	public function index() 
	{
		$this->registry->template->show( 'igre' );
	}
}; 

?>