<?php 

class LogoutController extends BaseController
{
	public function index() 
	{
		// Kontroler koji prikazuje popis svih usera
		$ls = new StoreService();

        unset($_SESSION['user_id']);
        header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
        exit();


	}
}