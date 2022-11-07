<?php
class User{
    public $id, $username, $type, $name, $email, $phone;

    function __construct($user){
        $this->$id = $user->$id;
        $this->$username = $user->$username;
        $this->$type = $user->$type;
        $this->$name = $user->$name;
        $this->$email = $user->$email;
        $this->$phone = $user->$phone;
    }
    
}
?><?php
