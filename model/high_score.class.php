<?php 

class High_score 
{
    protected $id, $id_game, $id_user, $high_score, $date_achieved;

    function __construct($id, $id_game, $id_user, $high_score, $date_achieved){
        $this->id = $id;
        $this->id_game = $id_game;
        $this->id_user = $id_user;
        $this->high_score = $high_score;
        $this->date_achieved = $date_achieved;
    }
    
    function __get($prop) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }

}

?>