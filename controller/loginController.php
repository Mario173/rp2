<?php 

class LoginController extends BaseController
{
	public function index() 
	{
		// Kontroler koji prikazuje popis svih usera
		//$ls = new StoreService();

        if(isset($_SESSION['logged_user_id'])){
            header( 'Location: ' . __SITE_URL . '/index.php?rt=igre' );
            exit();
        }

		$this->registry->template->title = 'Prijava';

        $this->registry->template->show( 'login' );
	}

    public function processLogin()
    {
        $gs = new GameService();
        $username = $_POST['username'];
        $password = $_POST['password'];
        //header( 'Location: ' . __SITE_URL . '/index.php?rt=igre' );
        $user = $gs->getUserByUsername( $username );
        if($user === null ){
            header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
        }

        else if( password_verify ( $password, $user->password_hash) ) {
            $_SESSION['logged_user_id'] = $user->id;
            header( 'Location: ' . __SITE_URL . '/index.php?rt=profile' );
            exit();
        }

        else{
            header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
        }
    }
}
