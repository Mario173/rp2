<?php

class ProfileController extends BaseController
{
	public function index() 
	{
		$this->registry->template->show( 'profile' );
	}
};

?>