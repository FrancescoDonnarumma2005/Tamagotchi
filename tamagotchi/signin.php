<?php 
require_once("config.php");
session_start();x\ 
$username= $connection->real_escape_string($_POST["username"]);
$password= $connection->real_escape_string($_POST["password"]);
$hashed_password=password_hash($password, PASSWORD_DEFAULT);
$checksql="SELECT * FROM utenti WHERE username='$username'";
if($connection->query($checksql)->num_rows==0){
    $stmt=$connection->prepare("INSERT INTO utenti (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    if($stmt->affected_rows==1){
    $_SESSION["loggedin"]=true;
    $_SESSION["idUtente"]=$stmt->insert_id;
    $_SESSION["username"]=$username;
    header("Location: ./lobby.html");
    }
}  
else{
    echo "username già esistente";
}