<?php

require_once("config.php");
session_start();
require_once("Animaletto.php");
require_once("Pipistrello.php");
require_once("Volpe.php");
require_once("Foca.php");

define("startStat",100);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
$idAnimaletto=$_POST['idAnimaletto'];
$_SESSION["idAnimaletto"]=$idAnimaletto;    
$nome=$_POST['nomeAnimaletto'];
$tipo=$_POST['tipoAnimaletto'];

 $startStat=startStat;
 
 $connection->begin_transaction();
try{
    $stmt=$connection->prepare("SELECT * FROM animaletti WHERE idAnimaletto=? AND idUtente=?");
    $stmt->bind_param("ii", $idAnimaletto, $_SESSION["idUtente"]);
    $stmt->execute();
    $result=$stmt->get_result();
    if(!isset($_POST["userChoice"]) && $result->num_rows==1){
        echo json_encode(["status"=>false, "message"=>"Animaletto già esistente. Vuoi sostituirlo?", "error"=>false]) ;
        exit;
}elseif((!isset($_POST["userChoice"]) && $result->num_rows==0 ) || (isset($_POST["userChoice"])) ){
$stmt=$connection->prepare("DELETE FROM animaletti WHERE idAnimaletto=? AND idUtente=?");
$stmt->bind_param("ii", $idAnimaletto, $_SESSION["idUtente"]);
$stmt->execute();
$stmt2=$connection->prepare("INSERT INTO animaletti (idAnimaletto, idUtente, nome, tipo, fame, divertimento, energia, vita) VALUES (?, ?,?,?,?,?,?,?)");
$stmt2->bind_param("iisidddd", $idAnimaletto, $_SESSION["idUtente"], $nome, $tipo, $startStat, $startStat, $startStat, $startStat);
$stmt2->execute();
$connection->commit();
if($stmt2->affected_rows > 0){
    // $tipo ha 3 valori possibili 1=Pipistrello 2=volpe 3=foca
    if($tipo==1){
     $_SESSION["animale"]=new Pipistrello($nome, startStat, startStat, startStat, startStat, startStat, startStat, startStat);
    } else if($tipo==2){
    $_SESSION["animale"]=new Volpe($nome, startStat, startStat, startStat, startStat, startStat, startStat, startStat);
    }else if($tipo==3){
    $_SESSION["animale"]=new Foca($nome, startStat, startStat, startStat, startStat, startStat, startStat, startStat);

    }
    
    echo json_encode(["status"=>true, "message"=>"Animaletto creato con successo", "error"=>false]) ;
    exit;
    

}
}
} catch(Exception $e){
    echo json_encode(["status"=>false, "message"=>"Animaletto non è stato creato".$e->getMessage(), "error"=>true]) ;
    $connection->rollback();
}
}


if($_SERVER['REQUEST_METHOD'] == 'GET'){
    
    
    $idAnimaletto=$_GET['idAnimaletto'];
    $idUtente=$_SESSION['idUtente'];
    $_SESSION["idAnimaletto"]=$idAnimaletto;
    $stmt=$connection->prepare("SELECT * FROM animaletti WHERE idAnimaletto=? AND idUtente=?");
    $stmt->bind_param("ii", $idAnimaletto, $idUtente);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows==1){
        $row=$result->fetch_assoc();
        $nome=$row['nome'];
        $tipo=$row['tipo'];
        $fame=$row['fame'];
        $divertimento=$row['divertimento'];
        $energia=$row['energia'];
        $vita=$row['vita'];
        if($tipo==1){
            $_SESSION["animale"]=new Pipistrello($nome, $fame, $divertimento, $energia, $vita);
           } else if($tipo==2){
           $_SESSION["animale"]=new Volpe($nome, $fame, $divertimento, $energia, $vita);
           }else if($tipo==3){
           $_SESSION["animale"]=new Foca($nome, $fame, $divertimento, $energia, $vita);
       
           }
           echo json_encode(["status"=>true, "message"=>"Animaletto caricato con successo", "error"=>false]) ;
           exit;
    }else if($result->num_rows==0){
        echo json_encode(["status"=>false, "message"=>"Animaletto non esistente crea una nuova partita", "error"=>false]) ;
        exit;
    }
    echo json_encode(["status"=>false, "message"=>"Non e' stato possibile caricare il tuo animaletto", "error"=>true]);
    exit;
}