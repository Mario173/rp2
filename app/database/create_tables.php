<?php


require_once __DIR__ . '/db.class.php';

create_table_users();
create_table_games();
create_table_favorite_games();
create_table_reviews();
create_table_achievements();
create_table_unlocked_achievements();
create_table_high_scores();

exit( 0 );

// --------------------------
function has_table( $tblname )
{
	$db = DB::getConnection();
	
	try
	{
		$st = $db->query( 'SELECT DATABASE()' );
		$dbname = $st->fetch()[0];

		$st = $db->prepare( 
			'SELECT * FROM information_schema.tables WHERE table_schema = :dbname AND table_name = :tblname LIMIT 1' );
		$st->execute( ['dbname' => $dbname, 'tblname' => $tblname] );
		if( $st->rowCount() > 0 )
			return true;
	}
	catch( PDOException $e ) { exit( "PDO error [show tables]: " . $e->getMessage() ); }

	return false;
}


function create_table_users()
{
	$db = DB::getConnection();

	if( has_table( 'project_users' ) )
		exit( 'Tablica project_users vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_users (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'username varchar(50) NOT NULL,' .
			'password_hash varchar(255) NOT NULL,'.
			'email varchar(50) NOT NULL,' .
			'registration_sequence varchar(20) NOT NULL,' .
			'has_registered int,' .
			'privacy int,' .
			'experience int NOT NULL,' .
			'level int NOT NULL' .
			')'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_users]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_users.<br />";
}


function create_table_games()
{
	$db = DB::getConnection();

	if( has_table( 'project_games' ) )
		exit( 'Tablica project_games vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_games (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'name varchar(100) NOT NULL,' .
			'description varchar(1000) NOT NULL' .
			')'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_games]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_games.<br />";
}


function create_table_reviews()
{
	$db = DB::getConnection();

	if( has_table( 'project_reviews' ) )
		exit( 'Tablica project_reviews vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_reviews (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'id_game INT NOT NULL,' .
			'id_user INT NOT NULL,' .
			'rating INT NOT NULL,' .
			'comment varchar(1000)' .
			')'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_reviews]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_reviews.<br />";
}

function create_table_favorite_games()
{
	$db = DB::getConnection();

	if( has_table( 'project_favorite_games' ) )
		exit( 'Tablica project_favorite_games vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_favorite_games (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'id_game INT NOT NULL,' .
			'id_user INT NOT NULL' .
			')'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_favorite_games]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_favorite_games.<br />";
}

function create_table_high_scores()
{
	$db = DB::getConnection();

	if( has_table( 'project_high_scores' ) )
		exit( 'Tablica project_high_scores vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_high_scores (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'id_game INT NOT NULL,' .
			'id_user INT NOT NULL,' .
			'high_score INT NOT NULL,' .
			'date_achieved DATE)'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_high_scores]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_high_scores.<br />";
}

function create_table_achievements()
{
	$db = DB::getConnection();

	if( has_table( 'project_achievements' ) )
		exit( 'Tablica project_achievments vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_achievements (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'id_game INT NOT NULL,' .
			'name varchar(100) NOT NULL,' .
			'description varchar(1000) NOT NULL,' .
			'required_score INT NOT NULL' .
			')'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_achievements]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_achievements.<br />";
}

function create_table_unlocked_achievements()
{
	$db = DB::getConnection();

	if( has_table( 'project_unlocked_achievements' ) )
		exit( 'Tablica project_unlocked_achievements vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_unlocked_achievements (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'id_user int NOT NULL,' .
			'id_achievement int NOT NULL,' .
			'date_achieved DATE)'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_unlocked_achievements]: " . $e->getMessage() ); }

	echo "Napravio tablicu unlocked_achievements.<br />";
}

?> 




