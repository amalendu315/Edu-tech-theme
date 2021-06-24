<?php
session_start();
//initializing variables
$name = "";
$email= "";

$errors = array();
//connect to db
$db = mysqli_connect('localhost','root','','practice') or die("Could not connect to DataBase")

//register users

$name = mysqli_real_escape_string($db, $_POST['name'])
$email = mysqli_real_escape_string($db, $_POST['email'])
$password = mysqli_real_escape_string($db, $_POST['password'])

//form validation
if(empty($name)) {array_push($errors, "Name is required")};
if(empty($email)) {array_push($errors, "Email is required")};
if(empty($password)) {array_push($errors, "Password is required")};

//check db for existing user for same username

$user_check_query = "SELECT * FROM user WHERE name = '$name' or email = '$email' LIMIT 1";

$results = mysqli_query($db,$user_check_query);
$user = mysqli_fetch_assoc($results);

if($user){
    if ($user['name']) {array_push($errors, "User Already Exists")};
    if ($user['email']) {array_push($errors, "Email Already Exists")}
};

//register the user if no error

if (count($errors) == 0) {
    $password_1 = md5($password);
    $query = "INSERT INTO user(name, email, password) VALUES($name, $email, $password_1)";
    mysqli_query($db, $query);
    $_SESSION['name'] = $name;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.html');
}

?>