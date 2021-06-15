<?php

class Favorite_game{
    protected $id, $id_game, $id_user;

    function __construct($id, $id_game, $id_user){
        $this->id =  $id;
        $this->id_game = $id_game;
        $this->id_user = $id_user;
    }

    function __get($prop) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>