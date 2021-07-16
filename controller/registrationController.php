<?php

class RegistrationController extends BaseController
{

    public function index() 
	{
        if(isset($_SESSION['logged_user_id'])){
            header( 'Location: ' . __SITE_URL . '/index.php?rt=igre' );
            exit();
        }
        /*
        else{
            header( 'Location: ' . __SITE_URL . '/view/registracija.php' );
            exit();
        }
        */
        
        $this->registry->template->title = 'Registracija';

		$this->registry->template->show( 'registracija' );
	}

    public function processRegistration()
    {
        $gs = new GameService();
        $username = $_POST['username'];
        $password = $_POST['pass'];
        $pass2 = $_POST['pass2'];
        $email = $_POST['mail'];
        // provjera je li user koristio ok znakove
        if( !preg_match( '/^[a-zA-Z ,-.0-9]+$/', $username ) )
        {
            $_GET['poruka'] = 'Nedozvoljen znak u Username';
            // stavio si nedozvoljen znak u username vrati se na pocetak registracije i po mogucnosti stavi u get[poruka] da je to problem
            header( 'Location: ' .__SITE_URL . '/index.php?rt=registration/index&poruka=nedozvolje_znak_u_username' );
            exit();
        }
        echo '<p>prosli smo pregmatch</p>';
        if( $pass2 !== $password )
        {
            // user nije dobro unio sifru dvaput, vrati ga na registration
            // da u get spremim jos ['poruka'] trebam dodat jos ?poruka="sifre nisu iste" poslije rt=registracija ili?
            header( 'Location: ' .__SITE_URL . '/index.php?rt=registration/index&poruka=password_mora_oba_puta_biti_isti' );
            exit();
        }
        //header( 'Location: ' . __SITE_URL . '/index.php?rt=igre' );
        $user = $gs->getUserByUsername( $username );
        if( $user !== false )
        {
            // user vec postoji            +               ?poruka="taj user vec postoji"
            header( 'Location: ' . __SITE_URL . '/index.php?rt=registration/index&poruka=user:_'. $user->username .'_vec_postoji'  );
            exit();
        }
        if( $user === false ){
            // header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            // dakle nema tog usera, trebamo sad stvorit novog
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $gs->addNewUser($username, $email, $hash );
            // sad trebamo zapoceti session s njime, ujedno i provjera da addNewUser radi
            $user = $gs->getUserByUsername( $username );
            if( isset($user) )
            {
                $_SESSION['logged_user_id'] = $user->id;
                header( 'Location: ' . __SITE_URL . '/index.php?rt=profile' );
            }
            else{
                // ?poruka=nije_uspio_addNewUser
                header( 'Location: ' . __SITE_URL . '/index.php?rt=registracija' );
            }
            exit();
        }
        else{
            header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
        }
    }
}

?>