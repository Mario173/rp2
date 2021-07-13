<?php

class ProfileController extends BaseController
{
	public function index() 
	{
		//$_SESSION['current_user_id'] = 1; //ovo zakomentirati kasnije

		$user_id = $_SESSION['logged_user_id'];

		$gs = new GameService();

		$user = $gs->getUserById($user_id);

		$username = $user->username;

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
		
		$this->registry->template->achievements_array = $achievements_array;
		$this->registry->template->high_scores = $high_scores_array;
		$this->registry->template->reviews_array = $reviews_array;
		$this->registry->template->username = $username;

		$this->registry->template->show( 'profile' );
		
	}
};

?>