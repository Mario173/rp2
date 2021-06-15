<?php 

class ProductsController extends BaseController
{
	public function index() 
	{
		// Kontroler koji prikazuje popis svih usera
		$ls = new StoreService();

        //$_SESSION['user_id'] = 1;

		if(!isset($_SESSION['user_id'])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
		}
        $user_id = $_SESSION['user_id'];

		// Popuni template potrebnim podacima
		$this->registry->template->user_id = $user_id;
		$this->registry->template->title = 'Popis svih proizvoda koje prodajete';
		$this->registry->template->productsList = $ls->getProductsByUser($user_id);

        $this->registry->template->show( 'products_index' );
	}


	public function showReviews()
	{
		// Kontroler koji prikazuje popis svih posuđenih knjiga odabranog usera
		// te omogućuje razduživanje i posuđivanje novih knjiga

		$ls = new StoreService();

		if(!isset($_SESSION['user_id'])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
		}

        $user_id = $_SESSION['user_id'];

		// Da li nam se šalje (novi) user_id preko post-a? Ako ne, provjeri $_SESSION.
		if( isset( $_POST["product_id"] ) )
		{
			// user_id iz post-a izgleda ovako "user_123" -> pravi id je zapravo samo 123 -> preskoči prvih 5 znakova
			$product_id = substr( $_POST["product_id"], 8 );
		}
		else if( isset( $_SESSION["product_id"] ) )
			$product_id = $_SESSION["product_id"];
		else
		{
			// Nema treće opcije -- nešto ne valja. Preusmjeri na početnu stranicu.
			header( 'Location: ' . __SITE_URL . '/index.php?rt=products' );
			exit;
		}

		// Dohvati podatke o korisniku
		$product = $ls->getProductById( $product_id );
		if( $product === null )
			exit( 'Nema korisnika s id-om ' . $product_id );

		// Stavi ga u $_SESSION tako da uvijek prikazujemo njegove podatke
		$_SESSION[ 'product_id' ] = $product_id;

        $product = $ls->getProductById($product_id);

		// Dohvati sve njegove posudbe
		$salesList = $ls->getReviewsByProductId( $product_id );

		// Napravi popis knjiga koje je on posudio.
		// Svaki element book liste je par (knjiga, datum isteka)
		$reviewList = array();
		foreach( $salesList as $sale )
			$reviewList[] = array( "user" => $ls->getUserById( $sale->id_user ), "sale" => $sale );
		
		$hasBought = $ls->didUserBuyProduct($user_id,$product_id);
		if ( ($user_id == $product->id_user) || ($hasBought === true ) ) $canBuy = false;
		else $canBuy = true;
		// Napravi popis svih knjiga koje su dostupne za posudbu.

		$seller_id = $product->id_user;
		$seller = $ls->getUserById($seller_id);

		$suma = 0;
		$broj = 0;

		foreach($reviewList as $review){
			$suma += $review['sale']->rating;
			$broj++;
		}

		$average_review = $suma / (float) $broj;

		$this->registry->template->user_id = $user_id;
        $this->registry->template->product_id = $product_id;
		$this->registry->template->product = $product;
		$this->registry->template->average_rating = $average_review;
		$this->registry->template->seller = $seller;
		$this->registry->template->reviewList = $reviewList;
		$this->registry->template->canBuy = $canBuy;
		$this->registry->template->hasBought = $hasBought;
		$this->registry->template->title = 'Popis recenzija proizvoda ' . $product->name;
        $this->registry->template->show( 'products_showReviews' );
	}

	public function buyProduct()
	{
		// Kontoler koji omogućuje posuđivanje nove knjige tako da obradi podatke iz forme users_showLoans
		// Na kraju samo napravi redirect na početnu stranicu.

		if(!isset($_SESSION['user_id'])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
		}

		$ls = new StoreService();

		$user_id = $_SESSION['user_id'];
		$product_id = $_SESSION[ 'product_id' ];

		$ls->makeNewSale( $product_id, $user_id);

		header( 'Location: ' . __SITE_URL . '/index.php?rt=products/showReviews' );
		exit();
	}

	public function reviewProduct()
	{
		// Kontoler koji omogućuje posuđivanje nove knjige tako da obradi podatke iz forme users_showLoans
		// Na kraju samo napravi redirect na početnu stranicu.

		$ls = new StoreService();

		$user_id = $_SESSION['user_id'];
		$product_id = $_SESSION[ 'product_id' ];

		$rating = $_POST['rating'];
		$comment = $_POST['comment'];

		$ls->reviewProduct($user_id, $product_id, $rating, $comment);

		header( 'Location: ' . __SITE_URL . '/index.php?rt=products/showReviews' );
		exit();
	}

	public function bought() 
	{
		// Kontroler koji prikazuje popis svih usera
		$ls = new StoreService();

		if(!isset($_SESSION['user_id'])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
		}
		
        $user_id = $_SESSION['user_id'];

		$sales_list = $ls->getSalesUserBought($user_id);
		foreach($sales_list as $sale){
			$products_list[$sale->id_product] = $ls->getProductById($sale->id_product);
		}

		// Popuni template potrebnim podacima
		$this->registry->template->user_id = $user_id;
		$this->registry->template->title = 'Popis svih proizvoda koje ste kupili';
		$this->registry->template->productsList = $products_list;

        $this->registry->template->show( 'products_bought' );
	}

    
}


?>
