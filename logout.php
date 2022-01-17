<?php
    session_start();
    if(isset($_SESSION["LOGUS"])){
        if($_SESSION["LOGUS"]==1){
            $_SESSION["LOGUS"]=0;
           
            require_once "database.php";
            $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
            
            if (mysqli_connect_errno($conn)) {
                echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
                exit();
            }
            $queryLogout="update utenti_casa set logged=0 where id=".$_SESSION["id"];
            $conn->query($queryLogout);

            $conn->close();

            unset($_SESSION["email"]);
            unset($_SESSION["id"]);
            unset($_SESSION["nome"]);
            unset($_SESSION["livello_utente"]);
            unset($_SESSION["cognome"]);
            header("Location:home_access.php");
            exit;
        }
    }else{
        header("Location:home_access.php");
        exit;
    }

?>