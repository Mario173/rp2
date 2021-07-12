<?php 

class LogoutController extends BaseController
{
	public function index() 
	{
		// Kontroler koji prikazuje popis svih usera
		$Gs = new GameService();

        unset($_SESSION['logged_user_id']);
        header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
        exit();


	}
}