<?php 
require_once("config.php");

$username= $connection->real_escape_string($_POST["username"]);
$password= $connection->real_escape_string($_POST["password"]);


if($_SERVER["REQUEST_METHOD"]==="POST"){
$query = "SELECT * FROM utenti WHERE username= '$username'";
if($result = $connection->query($query)){
if ($result->num_rows ==1) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if (password_verify($password, $row["password"])) {
    session_start();
    $_SESSION["loggedin"]=true;
    $_SESSION["idUtente"]=$row["id"];
    $_SESSION["username"]=$row["username"];

    header("location: lobby.html");
} else {
    echo "Password errata";
} 
} 
else {
    echo "Username non registrato";
    
}
} else{

echo "Errore: " . $query . "<br>" . $connection->error;

}
$connection->close();

}