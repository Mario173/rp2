<?php

class Unlocked_achievement{
    protected $id, $id_user, $id_achievement, $date_achieved;

    function __construct($id, $id_user, $id_achievement, $date_achieved){
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_achievement = $id_achievement;
        $this->date_achieved = $date_achieved;
    }

    function __get($prop) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>