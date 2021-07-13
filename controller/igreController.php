<?php 

class IgreController extends BaseController
{
	public $board = array();

	public function index() 
	{
		$this->registry->template->show( 'igre' );
	}

	public function sendJSONandExit( $message ) {
		// Kao izlaz skripte pošalji $message u JSON formatu i prekini izvođenje.
		header('Content-type:application/json;charset=utf-8');
		echo json_encode( $message );
		flush();
		exit(0);
	}

	public function generiraj_memory() {
		$data = [];

		$rand = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
					'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R'];
		
		shuffle( $rand ); // random poredak

		$data['table'] = $rand;

		$this->sendJSONandExit( $data );
	}

	// vraća id, te 2 arraya -> rows i cols
	public function generiraj_potapanje() {
		$data = [];

		$this->board = array();
		for($i = 0; $i < 10; $i++) {
			$this->board[$i] = array_fill(0, 10, 0);
		}

		// napuni ploču brodovima
		for($i = 4; $i > 0; $i--) {
			for($j = 0; $j < 5 - $i; $j++) {
				$notFree = [true, ''];
				while( $notFree[0] ) { // random generiraj dok ne pogodiš dobro mjesto
					$x = rand(0, 9);
					$y = rand(0, 9);

					$notFree = $this->slobodno($x, $y, $i, $this->board);
				}
				for($k = 0; $k < $i; $k++) {
					$this->board[$x + $k * $notFree[1][0]][$y + $k * $notFree[1][1]] = 1;
				}
			}
		}

		// generiraj retke i stupce
		$rows = []; $cols = [];
		for($i = 0; $i < 10; $i++) {
			$rows[$i] = 0;
			for($j = 0; $j < 10; $j++) {
				$rows[$i] += $this->board[$i][$j]; // 0 ako nema broda, 1 ako ima
			}
		}
		for($j = 0; $j < 10; $j++) {
			$cols[$j] = 0;
			for($i = 0; $i < 10; $i++) {
				$cols[$j] += $this->board[$i][$j]; // 0 ako nema broda, 1 ako ima
			}
		}
		$data['id'] = $cols[2] . '_' . $rows[1] . '_' . $rows[7] . $cols[8];
		$data['rows'] = $rows;
		$data['cols'] = $cols;
		$this->sendJSONandExit( $data );
	}

	public function slobodno($x, $y, $duljina, $board) {
		$pomak = [[1, 0], [-1, 0], [0, 1], [0, -1]];
		$temp_x = $x; $temp_y = $y;

		// dolje ili gore ili desno ili lijevo
		for($i = 0; $i < 4; $i++) {
			$x = $temp_x; $y = $temp_y;
			for($j = 0; $j < $duljina; $j++) {
				if( $x < 0 || $x > 9 || $y < 0 || $y > 9 ) {
					break;
				}
				if( $x > 0 ) {
					if( $y > 0 ) {
						if( $board[$x][$y] === 1 || $board[$x - 1][$y] === 1 || $board[$x - 1][$y - 1] === 1 || $board[$x][$y - 1] === 1 ) {
							break;
						}
					}
					if( $y < 9 ) {
						if( $board[$x][$y] === 1 || $board[$x - 1][$y] === 1 || $board[$x - 1][$y + 1] === 1 || $board[$x][$y + 1] === 1 ) {
							break;
						}
					}
				}
				if( $x < 9 ) {
					if( $y > 0 ) {
						if( $board[$x][$y] === 1 || $board[$x + 1][$y] === 1 || $board[$x + 1][$y - 1] === 1 || $board[$x][$y - 1] === 1 ) {
							break;
						}
					}
					if( $y < 9 ) {
						if( $board[$x][$y] === 1 || $board[$x + 1][$y] === 1 || $board[$x + 1][$y + 1] === 1 || $board[$x][$y + 1] === 1 ) {
							break;
						}
					}
				}

				$x += $pomak[$i][0]; $y += $pomak[$i][1];
			}
			if( $j === $duljina ) {
				return [false, $pomak[$i]];
			}
		}

		return [true, []];
	}

	public function provjeri_potapanje() {
		$id = $_POST['id'];
		$lista = $_POST['list'];

		$data = array();
		$data['id'] = $id;

		for($i = 0; $i < count($lista); $i++) {
			if( $this->board[$lista[$i][0]][$lista[$i][1]] === 1 && $lista[$i][3] === 'ship' ) {
				$lista[$i][] = 'correct';
			} else if( $this->board[$lista[$i][0]][$lista[$i][1]] === 0 && $lista[$i][3] === 'sea' ) {
				$lista[$i][] = 'correct';
			} else {
				$lista[$i][] = 'wrong';
			}
		}
		// tu ide correct i wrong
		$data['list'] = $lista;

		$this->sendJSONandExit( $data );
	}

	public function generiraj_vjesala() {
		$dictionary = ['RIJEČ', 'VJEŠALA', 'POKUŠAJ', 'SNTNTN', 'LOKOMOTIVA', 'MATEMATIKA', 'TRIGONOMETRIJA', 'KUĆA', 'JAHTA', 'SEDLO'];

		$data["id"] = $_SESSION['logged_user_id'];
		$koji = rand(0, count($dictionary));

		$data['riječ'] = $dictionary[$koji];

		$this->sendJSONandExit( $data );
	}

	public function obradiRezultate()
	{
		// 
		// $igre = array( "potapanje_brodova" => 1, "memory" => 2, "vjesala" => 3, "krizic_kruzic" => 4 );
		// funkcija koja je najmjenjana obradi score-a kojeg je user postigao na kraju igre
		// gleda se je li to highscore, je li unlockan achievment
		if( isset($_SESSION['logged_user_id']) )
			$id = $_SESSION['logged_user_id'];
		else
		{
			// user nije ulogiran
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
            exit();
		}
		// game treba biti u postu i prakticki uvijek i hoce
		if( isset($_POST['game']) && isset($_POST['score']) )
		{
			$gameid = $_POST['game'];
			$score = $_POST['score'];
		}
		else
		{
			$this->sendJSONandExit("nisu poslani svi potrebni podaci");
			//  ˇ there is no such thing as overkill 
			return false;
		}	

		$GS = new GameService();
		
		// provjera je li ovo highscore i ako jest, onda ga postaviti u bazu
		if( $GS->checkIfHighScoreExists($gameid, $id) )
		{
			echo '<p>highscore postoji</p>';
			$highScore = $GS->getHighScoreByIds($gameid, $id);
			print_r( $highScore);
			echo 'Echo: ' . $highScore->high_score;
			if( $highScore->high_score < $score )
			{
				//trenutni highscore je manji od upravo postignutog, sad u bazu stavi novi HS
				$GS->updateHighScore($gameid, $id, $score );
			}
			// sendJSONandExit("postavili smo novi highscore:" . $score . " za: " . $id);
		}
		else{
			echo 'user dosad nije imao high score';
			$GS->addHighScore($gameid, $id, $score);
			//sendJSONandExit("postavili smo novi highscore:" . $score . " za: " . $id);
		}

		// sad idemo provjeriti koje sve achievmente moze dobiti za ovu igru i jesu li vec otkljucani
		// koje achievmente ima user
		echo 'get Achievment by User ';
		$unlocked = $GS->getAchievementsByUser($id);
		// koji su achievmneti moguci za tu igru
		echo 'get Achievment by game ';
		$achiev = $GS->getAchievementByGame($gameid);
		// sada treba proci po svim achiev, pogledati je li score dovoljan, ako jest i ako nije vec u unlocked ubaci ga u tablicu kao novog
		echo 'idemo sada na achievmente ';
		foreach ($achiev as $value) {
			# code...
			// ako nemamo dovoljan score idi na slijedeci achievment
			echo 'req: '.  $value->required_score .' ? score: ' . $score;
			if( $value->required_score > $score )
				continue;
			$flag = true;
			echo '$valueID= ' . $value->id;
			foreach ($unlocked as $val) {
				# code...
				echo '   valIdAchievement= ' . $val->id_achievement;
				if( $value->id === $val->id_achievement )
					$flag = false;
			}
			if( $flag )
			{
				echo 'dodajemo novi achievement za ' . $id . ' ' . $value->id;
				// dakle imamo dovoljan score i nijedan id iz achivmenta nije jednak ijednom iz ulockanih, dakle ubacimo ga u bazu
				$GS->addAchievementByUser($id, $value->id);
			}  
		} 

		$this->sendJSONandExit("high score i achievment update-an. userid=" . $id . " gameid=" . $gameid . " score=" . $score);
		
	}


}; 

?>