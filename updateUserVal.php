<?php
    require_once "database.php";
    session_start();
    
    $id=$_SESSION["id"];
    $nomePrecedente=$_SESSION["nome"];
    $cognomePrecedente=$_SESSION["cognome"];
    $emailPrecedente=$_SESSION["email"];

    $nome=$_POST["nomeUtente"];
    $cognome=$_POST["cognomeUtente"];
    $email=$_POST["emailUtente"];
    
    
    $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
    if (mysqli_connect_errno($conn)) {
        echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
        exit();
    }
    
    
    if(($nome!=NULL)&&($nome!=$nomePrecedente)){
        $query="update utenti_casa set nome='".$nome."' where (id=".$id.");";
        $conn->query($query);
        $_SESSION["nome"]=$nome;
    }
    if(($cognome!=NULL)&&($cognome!=$cognomePrecedente)){
        $query="update utenti_casa set cognome='".$cognome."' where (id=".$id.");";
        $conn->query($query);
        $_SESSION["cognome"]=$cognome;
    }
    if(($email!=NULL)&&($email!=$emailPrecedente)){
        $query="update utenti_casa set email='".$email."' where (id=".$id.");";
        $conn->query($query);
        $_SESSION["email"]=$email;
    }

    $conn->close();
    header("Location:indexUtente.php");

?>