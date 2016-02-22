<?php

$password	=	isset($_REQUEST['password'])?mysql_real_escape_string(trim(@$_REQUEST['password'])):""; 

    $hash = hash('sha256', $password);
     
    function createSalt()
    {
    $text = md5(uniqid(rand(), true));
    return substr($text, 0, 3);
    }
     
    //$salt = createSalt();
    $salt = "3ab";
    $password = hash('sha256', $salt . $hash);
    echo $password."<br/>";
	echo $salt."<br/>";
	//ho $password;
?>