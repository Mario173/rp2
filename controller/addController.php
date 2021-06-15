<?php 

class AddController extends BaseController
{
	public function index() 
	{
		// Kontroler koji prikazuje popis svih usera
		$ls = new StoreService();

		if(!isset($_SESSION['user_id'])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
		}

        $user_id = $_SESSION['user_id'];

		// Popuni template potrebnim podacima
		$this->registry->template->title = 'Unošenje novog proizvoda';

        $this->registry->template->show( 'add' );
	}

    public function newProduct()
	{
		// Kontoler koji omogućuje posuđivanje nove knjige tako da obradi podatke iz forme users_showLoans
		// Na kraju samo napravi redirect na početnu stranicu.

		$ls = new StoreService();

		if(!isset($_SESSION['user_id'])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
		}

		$user_id = $_SESSION['user_id'];
		$name = $_POST[ 'name' ];
        $description = $_POST[ 'description' ];
        $price = floatval($_POST[ 'price' ]);
        

		$ls->addNewProduct($user_id, $name, $description, $price);

		header( 'Location: ' . __SITE_URL . '/index.php?rt=products' );
		exit();
	}

}