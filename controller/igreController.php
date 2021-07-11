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
	}

	public function provjeri_potapanje() {

	}

	public function generiraj_vjesala() {

	}

	public function generiraj_krizic_kruzic() {
		
	}
}; 

?>