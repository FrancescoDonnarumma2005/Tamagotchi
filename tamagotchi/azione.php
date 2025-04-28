<?php
require_once("config.php");
require_once("Animaletto.php");
require_once("Pipistrello.php");
require_once("Volpe.php");
require_once("Foca.php");
session_start();
// Verifica se la richiesta è stata inviata tramite POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica quale azione è stata richiesta
    if ($_POST['action'] == 'eat') {
        $animale = $_SESSION['animale'];
        $animale->mangia();
        aggiornaStato($animale);
    } elseif ($_POST['action'] == 'sleep') {
        $animale = $_SESSION['animale'];
        $animale->dormi();
        aggiornaStato($animale);
    } elseif ($_POST['action'] == 'accarezza') {
        $animale = $_SESSION['animale'];
        $animale->addDivertimento(2);
        aggiornaStato($animale);
    } elseif ($_POST['action'] == 'decrease'){
        $animale = $_SESSION['animale'];
        $animale->decrease();
        
        aggiornaStato($animale);
    }elseif ($_POST['action'] == 'save'){
        try{
            $animale = $_SESSION['animale'];
            $stmt = $connection->prepare("UPDATE animaletti SET fame=?, divertimento=?, energia=?, vita=?, lastUpdate=? WHERE idAnimaletto = ? AND idUtente=?");
            $lastUpdate = $animale->lastUpdate->format('Y-m-d H:i:s');
            $stmt->bind_param('ddddsii', $animale->fame, $animale->divertimento, $animale->energia, $animale->vita,  $lastUpdate ,$_SESSION['idAnimaletto'], $_SESSION['idUtente']);
            $stmt->execute();
            $stmt->execute();
            
        } catch(PDOException $e){
            echo $e->getMessage();
        }
    }elseif($_POST['action']=="start"){
       $animale = $_SESSION['animale'];
       $timeAfterOffline=new DateTime();
        $animale->offlineDecrease($timeAfterOffline);
        aggiornaStato($animale);
    }elseif($_POST['action']=="dead"){
        $stmt = $connection->prepare("DELETE FROM animaletti WHERE idAnimaletto = ? AND idUtente=?");
        $stmt->bind_param('ii', $_SESSION['idAnimaletto'], $_SESSION['idUtente']);
        $stmt->execute();

    }
}

// Funzione per aggiornare lo stato dell'animale e restituire lo stato come JSON
function aggiornaStato($animale) {
    
    $animale->calcolaVita();
    $_SESSION['animale'] = $animale;
    echo json_encode($animale);

}



?>
