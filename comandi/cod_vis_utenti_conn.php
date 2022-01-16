<?php
include_once "database.php";

$connessione=new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   

if (mysqli_connect_errno($connessione)) {
    echo "Connessione fallita: ". mysqli_connect_errno($connessione) . ".";
    $connessione->close();
    exit();
}
    $query="select * from utenti_casa;";
   
    $result=$connessione->query($query);
    
    if($result->num_rows > 0){  
        echo "<messaggio tipoMex=\"info\"><testo>";
                while($row=$result->fetch_assoc()){
                    if($row["logged"]==1){
                     echo "&lt;div style=\"border-radius:5px; margin:1%; background-color:black; padding:1%; color:white;\" &gt;";
                    echo "Nome :".$row["nome"]." Cognome:".$row["cognome"]."&lt;br /&gt; Livello:".$row["livello_permesso"]." Email:".$row["email"];
                    echo "&lt;/div&gt;";
                  }
                }
        echo "</testo></messaggio>";
    }
    $connessione->close();
?>