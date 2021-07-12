<?php 

class IgreController extends BaseController
{
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
		
		$rand = shuffle( $rand ); // random poredak

		$data['table'] = $rand;

		$this->sendJSONandExit( $data );
	}

	// vraća id, te 2 arraya -> rows i cols
	public function generiraj_potapanje() {
		$data = [];

		$board = array();
		for($i = 0; $i < 10; $i++) {
			$board[$i] = array_fill(0, 10, 0);
		}

		for($i = 4; $i > 0; $i--) {
			for($j = 0; $j < 5 - $i; $j++) {
				$notFree = [true, ''];
				while( $notFree ) { // random generiraj dok ne pogodiš dobro mjesto
					$x = rand(0, 9);
					$y = rand(0, 9);

					$notFree = $this->slobodno($x, $y, $i);
				}
			}
		}
	}

	public function slobodno($x, $y, $duljina) {
		$isFree = false;

		$pomak = [[1, 0], [-1, 0], [0, 1], [0, -1]];

		// dolje ili gore ili desno ili lijevo
		for($i = 0; $i < 4; $i++) {
			for($j = 0; $j < $duljina; $j++) {
				if( $x > 0 ) {

				}
				if( $x < 9 ) {

				}
			}
		}

		return [true, ''];
	}

	public function provjeri_potapanje() {

	}

	public function generiraj_vjesala() {

	}

	public function generiraj_krizic_kruzic() {
		
	}
}; 

?>