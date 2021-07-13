<?php 

class SearchController extends BaseController
{
	public function index() 
	{
		if(!isset($_SESSION['logged_user_id'])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
		}
		$this->registry->template->title = 'Pretraži igrače po imenu';
		$this->registry->template->show( 'search' );
	}

	public function searchResults() 
	{
		$gs = new GameService();


		// Ako nam forma nije u $_POST poslala autora u ispravnom obliku, preusmjeri ponovno na formu.
		if( !isset( $_POST['username'] ) || !preg_match( '/^[a-zA-Z ,-.0-9]+$/', $_POST['username'] ) )
		{
			//nevaljali input
			header( 'Location: ' . __SITE_URL . '/index.php?rt=search');
			exit();
		}

		

		$this->registry->template->title = 'Popis svih proizvoda ' . $_POST['username'];
		//$this->registry->template->productList = $gs->getProductsByName( $_POST['product_name'] )



		$this->registry->template->show( 'search_results' );
	}

	public function search_help() 
	{

        if( isset($_POST['q'])){
            //$imena = [ "Ana", "Ante", "Boris", "Maja", "Marko", "Mirko", "Slavko", "Slavica" ];
            $q = $_POST[ "q" ];
        
            $gs = new GameService();
        
            $imena = $gs->getAllUsernames();
        
            // Protrči kroz sva imena i vrati HTML kod <option> za samo ona 
            // koja sadrže string q kao podstring.
            foreach( $imena as $ime )
                if( strpos( $ime, $q ) !== false )
                    echo "<option value='" . $ime . "' />\n";
        }

    
    }	
}; 

?>
