<?php 

class LoginController extends BaseController
{
	public function index() 
	{
		// Kontroler koji prikazuje popis svih usera
		//$ls = new StoreService();

        if(isset($_SESSION['user_id'])){
            header( 'Location: ' . __SITE_URL . '/index.php?rt=igre' );
            exit();
        }

		$this->registry->template->title = 'Prijava';

        $this->registry->template->show( 'login' );
	}

    public function processLogin()
    {
        //$ls = new StoreService();
        $username = $_POST['username'];
        $password = $_POST['password'];
        header( 'Location: ' . __SITE_URL . '/index.php?rt=igre' );
        /*$user = $ls->getUserByUsername( $username );
        if($user === null ){
            header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
        }

        else if( password_verify ( $password, $user->password_hash) ) {
            $_SESSION['user_id'] = $user->id;
            header( 'Location: ' . __SITE_URL . '/index.php?rt=products' );
            exit();
        }

        else{
            header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
        }*/
    }
}
