<?php

class GameService {
    
    function getUserById( $id )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, username, password_hash, email, registration_sequence, has_registered, avatar_id, experience, level
                FROM project_users WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new User( $row['id'], $row['username'], $row['password_hash'], $row['email'],
             $row['registration_sequence'], $row['has_registered'], $row['avatar_id'], $row['experience'],$row['level']);
	}

	function getUserByUsername( $username )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, username, password_hash, email, registration_sequence, has_registered, avatar_id, experience, level
                FROM project_users WHERE username=:username' );
			$st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new User( $row['id'], $row['username'], $row['password_hash'], $row['email'],
             $row['registration_sequence'], $row['has_registered'], $row['avatar_id'], $row['experience'],$row['level']);
	}

    function getGameById( $id )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, name, description FROM project_games WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new Game( $row['id'], $row['name'], $row['description']);
	}

    function getAchievementById( $id ){
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_game, name, description, required_score FROM project_achievements WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new Achievement( $row['id'], $row['id_game'], $row['name'], $row['description'], $row['required_score']);
    }

    function getReviewByIds( $id_game, $id_user){
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_game, id_user,rating, comment FROM project_reviews WHERE id_user=:id_user AND id_game=:id_game' );
			$st->execute( array( 'id_user' => $id_user, 'id_game' => $id_game ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new Review( $row['id'], $row['id_game'], $row['id_user'], $row['rating'], $row['comment']);
    }

    function getAchievementsByUser($id_user)
    {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_game, id_achievement, date_achieved FROM
                project_unlocked_achievements WHERE id_user = :id_user');
			$st->execute( array( 'id_user' => $id_user ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Unlocked_Achievement( $row['id'], $row['id_game'],  $row['id_achievement'], $row['date_achieved'] );
		}

		return $arr;
	}

    function getReviewsByGame($id_game)
    {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_game, id_user, rating, comment FROM
                project_reviews WHERE id_game = :id_game');
			$st->execute( array( 'id_game' => $id_game ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Review( $row['id'], $row['id_game'],  $row['id_user'], $row['rating'], $row['comment'] );
		}

		return $arr;
	}

    function getFavoriteGamesByUser($id_user)
    {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_game, id_user FROM
                project_favorite_games WHERE id_user = :id_user');
			$st->execute( array( 'id_user' => $id_user ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Favorite_game( $row['id'], $row['id_game'], $row['id_user']);
		}

		return $arr;
	}


    function getHighScoreByIds( $id_game, $id_user){
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_game, id_user,high_score, date_achieved FROM project_high_scores WHERE id_user=:id_user AND id_game=:id_game' );
			$st->execute( array( 'id_user' => $id_user, 'id_game' => $id_game ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new High_score( $row['id'], $row['id_game'], $row['id_user'], $row['high_score'], $row['date_achieved']);
    }

    function getHighScoresByGame($id_game)
    {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_game, id_user, high_score, date_achieved FROM
                project_high_scores WHERE id_game = :id_game');
			$st->execute( array( 'id_game' => $id_game ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new High_score(  $row['id'], $row['id_game'], $row['id_user'], $row['high_score'], $row['date_achieved']);
		}

		return $arr;
	}

    function getUsersByUsername( $name )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->query( "SELECT SELECT id, username, password_hash, email, registration_sequence, has_registered, experience, level
                 FROM project_users WHERE username LIKE '%" . $name . "%' ORDER BY name ");
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new User( $row['id'], $row['username'], $row['password_hash'], $row['email'],
                $row['registration_sequence'], $row['has_registered'], $row['avatar_id'], $row['experience'],$row['level']);
		}

		return $arr;
	}

	function checkIfHighScoreExists($id_game, $id_user){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, id_game, id_user,high_score, date_achieved FROM project_high_scores WHERE id_user = :id_user AND id_game = :id_game ;');
			$st->execute( array( 'id_user' => (int) $id_user, 'id_game' => (int)$id_game ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return false;
		else
			return true;
	}

	function updateHighScore( $id_game, $id_user, $high_score){
		// Sad napokon možemo stvoriti novi loan (možda bi trebalo provjeriti i da ta knjiga nije već posuđena...)
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE project_high_scores 
									SET high_score = :high_score, date_achieved = CURRENT_DATE() 
									WHERE id_game = :id_game AND id_user = :id_user');
			$st->execute( array( 'id_game' => $id_game, 'id_user' => $id_user, 'high_score' => $high_score) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function addHighScore($id_game, $id_user, $high_score){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO project_high_scores(id_game, id_user, date_achieved) VALUES(:id_game, :id_user, :high_score,CURRENT_DATE());');
			$st->execute( array( 'id_user' => $id_user, 'id_game' => $id_game, 'high_score' => $high_score) );
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

	function getAllGameIds(){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id FROM
                project_games');
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] =(int) $row['id'];
		}

		return $arr;
	}

	function getAllUsernames(){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM
                project_users;');
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] =$row['username'];
		}

		return $arr;
	}







}



?>