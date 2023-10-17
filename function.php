<?php
function nameCheck($name){
    $nameRegex = '/^[A-Za-z]{2,}$/';
    return preg_match($nameRegex,$name);
}

function emailCheck($email){
    $emailRegex = '/^[A-Za-z0-9]+@[A-Za-z]+\.[A-Za-z]{2,}$/';
    return preg_match($emailRegex,$email);
}

function passwordCheck($password,$re_password){
    return ($password === $re_password);
}
?>