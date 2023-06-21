<?php


//print_r($_POST);

if(empty($_POST['name'])){
    die('please enter your name ');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
 
  die(" is not a valid email address");
}
if(strlen($_POST['password']) < 8){
    die('password is too short');
}
if(!preg_match('/[a-z]/i',$_POST['password'])){
    die('password must contain at least one char');
}
if(!preg_match('/[0-9]/i',$_POST['password'])){
    die('password must contain at least one number');
}

if($_POST['reppassword'] !== $_POST['password']){
    die('passwords must be equals');
}
$password_hash=password_hash($_POST['password'],PASSWORD_DEFAULT);

//var_dump($password_hash);
require __DIR__. '/db.php';
$sql = "INSERT INTO user (name, email,password,reppassword)
VALUES (?,?,?,? )";

$stmt=$conn-> stmt_init();

if(!$stmt->prepare($sql)){
    die('sql erorr:'. $mysqli->erorr);
}
$stmt->bind_param('bbbb' ,$_POST['name'], $_POST['email'],$_POST['reppassword'] , $_POST['password']);
if($stmt->execute()){
    header("location:hi.php");
}
