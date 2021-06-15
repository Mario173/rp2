<?php

class Game{
    protected $id, $name, $description;

    function __construct($id, $name, $description){
        $this->id =  $id;
        $this->name = $name;
        $this->description = $description;
    }

    function __get($prop) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>