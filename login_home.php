<?php
    session_start();
    require_once "database.php";
    $_SESSION['LOGUS']=0;
    $username=$_POST["email"];
    $password=$_POST["password"];
     
    if(($username!=NULL)&&($password!=NULL)){
        
    $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
    if (mysqli_connect_errno($conn)) {
        echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
        exit();
    }
    $query="select * from utenti_casa where((email='".$username."') AND (password='".$password."'));";

    $result=$conn->query($query);
    if($result->num_rows > 0 ){
        $row=$result->fetch_assoc();
            $nome=$row["nome"];
            $id=$row["id"];
            $livello=$row["livello_permesso"];
            $cognome=$row["cognome"];
            $email=$row["email"];

        $_SESSION["LOGUS"]=1;
        $_SESSION["nome"]=$nome;
        $_SESSION["id"]=$id;
        $_SESSION["livello_utente"]=$livello;
        $_SESSION["cognome"]=$cognome;
        $_SESSION["email"]=$email;

        $updateLog="update utenti_casa set logged=1 where email='".$username."'";
        $conn->query($updateLog);
        
        $conn->close();
        header("Location: indexUtente.php");
        exit();
    }else{
        $_SESSION["error"]=2;
        header("Location: home_access.php");

    }
    }
    else{
        $_SESSION["error"]=1;
        header("Location:home_access.php");
        exit;
    }
?>