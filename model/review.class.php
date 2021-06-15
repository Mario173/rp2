<?php 

class Review 
{
    protected $id, $id_game, $id_user, $rating, $comment;

    function __construct($id, $id_game, $id_user, $rating, $comment){
        $this->id = $id;
        $this->id_game = $id_game;
        $this->id_user = $id_user;
        $this->rating = $rating;
        $this->comment = $comment;
    }
    
    function __get($prop) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }

}

?>