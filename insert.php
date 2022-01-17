<?php
    session_start();

    function validaEmail($email){
        
        $regex2="/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/ ";
        if (!preg_match($regex2, $email)) {
            
            return false;
        }else{
            return true;
        }
    }

    $nome=trim($_POST["nome"]);
    $cognome=trim($_POST["cognome"]);
    $email=trim($_POST["email"]);
    $password=trim($_POST["password"]);

    if(($nome==NULL)||($cognome==NULL)||($email==NULL)||($password==NULL)){
        $_SESSION["error"]=1;
        $_SESSION["name"]=$nome;
        $_SESSION["surname"]=$cognome;
        $_SESSION["Email"]=$email;
        $_SESSION["pass1"]=$password;
        header("Location:register.php");
        exit;
    }
    if(!validaEmail($email)){
        $_SESSION["error"]=2;
        $_SESSION["name"]=$nome;
        $_SESSION["surname"]=$cognome;
        $_SESSION["Email"]=$email;
        $_SESSION["pass1"]=$password;
        header("Location:register.php");
        exit;
    }

    include_once "database.php";
    $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);

    if (mysqli_connect_errno($conn)) {
        echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
        exit();
    }
    $query="insert into utenti_casa (nome,cognome,email,password,livello_permesso) values ('".$nome."','".$cognome."','".$email."','".$password."',1);";
    $result=$conn->query($query);
    $conn->close();
    header("Location:home_access.php");
    exit;
?>