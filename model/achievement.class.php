<?php

class Achievement{
    protected $id, $id_game, $name, $description, $required_score;

    function __construct($id, $id_game, $name, $description, $required_score){
        $this->id =  $id;
        $this->id_game =  $id_game;
        $this->name = $name;
        $this->description = $description;
        $this->required_score =  $required_score;
    }

    function __get($prop) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>