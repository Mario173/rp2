<?php

class User
{
	protected $id, $username, $password_hash,
	 $email, $registration_sequence, $has_registered,
	 $privacy, $experience, $level;

	function __construct( $id, $username, $password_hash, $email,
		$registration_sequence, $has_registered,
		$privacy, $experience, $level )
	{
		$this->id = $id;
		$this->username = $username;
		$this->password_hash = $password_hash;
		$this->email = $email;
		$this->registration_sequence = $registration_sequence;
		$this->has_registered = $has_registered;
		$this->privacy = $privacy;
		$this->experience = $experience;
		$this->level = $level;
	}	

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>