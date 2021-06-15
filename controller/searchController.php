<?php 

class SearchController extends BaseController
{
	public function index() 
	{
		if(!isset($_SESSION['user_id'])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
		}
		$this->registry->template->title = 'Pretraži proizvode po imenu';
		$this->registry->template->show( 'search' );
	}

	public function searchResults() 
	{
		$ls = new StoreService();


		// Ako nam forma nije u $_POST poslala autora u ispravnom obliku, preusmjeri ponovno na formu.
		if( !isset( $_POST['product_name'] ) || !preg_match( '/^[a-zA-Z ,-.0-9]+$/', $_POST['product_name'] ) )
		{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=search');
			exit();
		}

		$this->registry->template->title = 'Popis svih proizvoda ' . $_POST['product_name'];
		$this->registry->template->productList = $ls->getProductsByName( $_POST['product_name'] );

		$this->registry->template->show( 'search_results' );
	}	
}; 

?>
