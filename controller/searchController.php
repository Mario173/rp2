<?php 

class SearchController extends BaseController
{
	public function index() 
	{

		if(!isset($_SESSION['logged_user_id'])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
		}

		if(isset($_SESSION['errorMsg'])){
			$msg = $_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
		else{
			$msg = "";
		}
		$this->registry->template->msg = $msg;
		$this->registry->template->title = 'Pretraži igrače po imenu';
		$this->registry->template->show( 'search' );
	}


	public function process_search(){
		if( !isset( $_POST['username'] ) || !preg_match( '/^[a-zA-Z ,-.0-9]+$/', $_POST['username'] ) )
		{
			//nevaljali input
			$_SESSION['errorMsg'] = 'Ne postoji korinik s upisanim imenom!';
			header( 'Location: ' . __SITE_URL . '/index.php?rt=search');
			exit();
		}
		else{
			$gs = new GameService();
			if( $gs->getUserByUsername($_POST['username']) === false){
				$_SESSION['errorMsg'] = 'Ne postoji korinik s upisanim imenom!';
				$_GET['msg'] = 'Nep';
				header( 'Location: ' . __SITE_URL . '/index.php?rt=search');
				exit();
			}
			else{
				$_SESSION['searched_user_id'] = (int) $gs->getUserByUsername($_POST['username'])->id;
				header( 'Location: ' . __SITE_URL . '/index.php?rt=profile');
				exit();
			}
		}
	}

	public function search_help() 
	{

        if( isset($_POST['q'])){
            //$imena = [ "Ana", "Ante", "Boris", "Maja", "Marko", "Mirko", "Slavko", "Slavica" ];
            $q = $_POST[ "q" ];
        
            $gs = new GameService();
        
            $imena = $gs->getUsersByUsername($q);
        
            // Protrči kroz sva imena i vrati HTML kod <option> za samo ona 
            // koja sadrže string q kao podstring.
            foreach( $imena as $el )
                if( strpos( $el->username, $q ) !== false )
                    echo "<option value='" . $el->username . "' />\n";
        }

    
    }	
}; 

?>
