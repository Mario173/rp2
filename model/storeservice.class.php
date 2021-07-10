<?php

/*class StoreService
{
    function getUserById( $id )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, username, password_hash, email, registration_sequence, has_registered FROM dz2_users WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new User( $row['id'], $row['username'], $row['password_hash'], $row['email'],
             $row['registration_sequence'], $row['has_registered']);
	}

    function getUserByUsername( $username )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, username, password_hash, email, registration_sequence, has_registered FROM dz2_users WHERE username=:username' );
			$st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new User( $row['id'], $row['username'], $row['password_hash'], $row['email'],
             $row['registration_sequence'], $row['has_registered']);
	}

    function getProductById( $id )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_user, name, description, price FROM dz2_products WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new Product( $row['id'], $row['id_user'], $row['name'], $row['description'], $row['price'] );
	}

    function getProductsByName( $name )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->query( "SELECT id, id_user, name, description, price
                 FROM dz2_products WHERE name LIKE '%" . $name . "%' ORDER BY name ");
			//$st->execute( array( 'name' => $name ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Product( $row['id'], $row['id_user'], $row['name'], $row['description'], $row['price'] );
		}

		return $arr;
	}

    function getProductsByUser( $id_user )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_user, name, description, price
                 FROM dz2_products WHERE id_user = :id_user ORDER BY name ');
			$st->execute( array( 'id_user' => $id_user ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Product( $row['id'], $row['id_user'], $row['name'], $row['description'], $row['price'] );
		}

		return $arr;
	}

    function getSalesByProductId($id_product )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_product, id_user, rating, comment
                 FROM dz2_sales WHERE id_product = :id_product');
			$st->execute( array( 'id_product' => $id_product ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Sales( $row['id'], $row['id_product'], $row['id_user'], $row['rating'], $row['comment'] );
		}

		return $arr;
	}

	function getReviewsByProductId($id_product )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_product, id_user, rating, comment
                 FROM dz2_sales WHERE id_product = :id_product AND rating is not null');
			$st->execute( array( 'id_product' => $id_product ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Sales( $row['id'], $row['id_product'], $row['id_user'], $row['rating'], $row['comment'] );
		}

		return $arr;
	}

    function getSalesUserBought($id_user)
    {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_product, id_user, rating, comment FROM
                dz2_sales WHERE id_user = :id_user');
			$st->execute( array( 'id_user' => $id_user ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Sales( $row['id'], $row['id_product'],  $row['id_user'], $row['rating'], $row['comment'] );
		}

		return $arr;
	}

	function didUserBuyProduct( $id_user, $id_product)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_product, id_user, rating, comment FROM
                dz2_sales WHERE id_user = :id_user AND id_product = :id_product');
			$st->execute( array( 'id_user' => $id_user,'id_product' => $id_product ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Sales( $row['id'], $row['id_product'], $row['id_user'], $row['rating'], $row['comment'] );
		}

		if( empty($arr) ) return false;
		else return true;
	}

    function makeNewSale( $id_product, $id_user)
    {
        // Provjeri prvo jel postoje taj user i ta knjiga
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_users WHERE id=:id' );
			$st->execute( array( 'id' => $id_user ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() !== 1 )
			throw new Exception( 'makeNewLoan :: User with the given id_user does not exist.' );


		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_products WHERE id=:id' );
			$st->execute( array( 'id' => $id_product) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() !== 1 )
			throw new Exception( 'makeNewLoan :: Book with the given id_book does not exist.' );


		// Sad napokon možemo stvoriti novi loan (možda bi trebalo provjeriti i da ta knjiga nije već posuđena...)
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO dz2_sales(id_product, id_user, rating, comment ) 
                VALUES (:id_product, :id_user, NULL, NULL)' );
			$st->execute( array( 'id_product' => $id_product, 'id_user' => $id_user ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
    }

    function reviewProduct( $id_user, $id_product, $rating, $comment ){
		// Sad napokon možemo stvoriti novi loan (možda bi trebalo provjeriti i da ta knjiga nije već posuđena...)
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE dz2_sales SET rating = :rating, comment = :comment WHERE id_product = :id_product AND id_user = :id_user');
			$st->execute( array( 'id_user' => $id_user, 'id_product' => $id_product, 'comment' => $comment, 'rating' => $rating ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function addNewProduct($id_user, $name, $description, $price){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO dz2_products(id_user, name, description, price) VALUES(:id_user, :name, :description, :price)');
			$st->execute( array( 'id_user' => $id_user, 'name' => $name, 'description' => $description, 'price' => $price ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}



};

*/
?>
