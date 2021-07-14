<?php

class ProfileController extends BaseController
{
	public function index() 
	{
		if(!isset($_SESSION['logged_user_id'])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
			exit();
		}
		else if(isset($_SESSION['searched_user_id'])){
			$user_id = $_SESSION['searched_user_id'];
			unset($_SESSION['searched_user_id']);
		}
		else{
			$user_id = $_SESSION['logged_user_id'];
		}
		$gs = new GameService();

		$user = $gs->getUserById($user_id);

		$username = $user->username;

		// dobili smo avatar id iz baze sad trebamo obraditi taj id da se zna koju sliku povuci i koju postaviti u bazu
		$avatar = $user->avatar_id;
		switch ($avatar) {
			case 1:
				# code...
				$avatar = 'view/avatar2.jpg';
				break;
			case 2:
				$avatar = 'view/icon.png';
				break;
			default:
				# code...
				$avatar = 'view/avatar.webp';
				break;
		}
		

		$game_id_array = $gs->getAllGameIds();

		$game_name_array = array();
		$high_scores_array = array();

		
		foreach( $game_id_array as $game_id){
			$game_name_array[] = $gs->getGameById($game_id)->name;
			if($gs->checkIfHighScoreExists($game_id,$user_id)){
				$novi_elem = array();
				$novi_elem['name'] = $gs->getGameById($game_id)->name;
				$temp_high = $gs->getHighScoreByIds($game_id,$user_id);
				$novi_elem['high_score'] = $temp_high->high_score;
				$novi_elem['date_achieved'] = $temp_high->date_achieved;
				$high_scores_array[] =  $novi_elem;
			}
		}
		
		$favorite_games_array = $gs->getFavoriteGamesByUser($user_id);
		$favorite_games_names_array = array();
		foreach( $favorite_games_array as $fav_game){
			$favorite_games_names_array[] = $gs->getGameById($fav_game->id_game)->name;
		}

		$reviews_array = array();
		$reviews = $gs->getReviewsByUser($user_id);
		foreach($reviews as $el){
			$temp_el = array();
			$temp_el[0] = $gs->getGameById($el->id_game)->name;
			$temp_el[1] = $el->rating;
			$temp_el[2] = $el->comment;
			$reviews_array[] = $temp_el;
		}

		$achievements_array = array();
		$achievements = $gs->getAchievementsByUser($user_id);
		foreach($achievements as $el){
			$temp_el = array();
			$temp_el[0] = $gs->getAchievementById($el->id_achievement)->name;
			$temp_el[1] = $el->date_achieved;
			$achievements_array[] = $temp_el;
		}

		$level_and_exp = $gs->getLevelAndPercentageFromUserId($user_id);
		
		$this->registry->template->avatar = $avatar;
		$this->registry->template->level = $level_and_exp['level'];
		$this->registry->template->percentage = $level_and_exp['percentage'];
		$this->registry->template->achievements_array = $achievements_array;
		$this->registry->template->high_scores = $high_scores_array;
		$this->registry->template->reviews_array = $reviews_array;
		$this->registry->template->username = $username;


		$this->registry->template->show( 'profile' );
		
	}

	public function sendJSONandExit( $message ) {
		// Kao izlaz skripte pošalji $message u JSON formatu i prekini izvođenje.
		header('Content-type:application/json;charset=utf-8');
		echo json_encode( $message );
		flush();
		exit(0);
	}

	public function spremi_avatara()
	{
		// pogledaj jesu li u postu spremljeni ispravni podaci
		if( !isset($_POST['avatar']) || !isset($_SESSION['logged_user_id']) )
		{
			
			$this->sendJSONandExit("nisu poslani potrebni podaci");
		}
		else{
			$avatar = $_POST['avatar'];
			$id = $_SESSION['logged_user_id'];
		}
		if( !isset($_SESSION['searched_user_id'] ) )
		{
			
		}
		else
		{
			$this->sendJSONandExit("netko drugi klika na ikonu avatara");
			return false;
		}
		echo 'Avatar je: ' . $avatar;
		$GS = new GameService();
		// sad ces moci promjeniti i svoj avatar klikanjem na tudi
		$av = $GS->changeAvatarById( $id, $avatar );
		echo 'Postavili smo avatara ' . $av . '  ';
		$msg['avatar'] = $avatar;
		$this->sendJSONandExit($msg);
	}
};

?>