<?php
        $comandoH=$_SESSION["comandoDaPassare"];
        $arrayWords=explode(' ',$comandoH);
        $dimArray=count($arrayWords);
        $luogoTrovato=0;

        if($comandoH==""){
            echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : La sintassi del comando è:  visualizza_oggetti in (nome_luogo)   &lt;br /> &lt;/span&gt; </testo></messaggio>";
        }else if($dimArray==3){
            include_once "database.php";
            $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
            if (mysqli_connect_errno($conn)) {
                echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
                exit();
            }
            $queryListaOgg="select nome from oggetti,luoghi where((oggetti.id_luogo=luoghi.id)AND(nome_luogo='".$arrayWords[2]."'));";
            $result=$conn->query($queryListaOgg);
            if($result->num_rows>0){
                echo "<messaggio tipoMex=\"messaggio\"><testo>&lt;span&gt; &lt;br /> HAL: Ecco gli oggetti in ".$arrayWords[2]."&lt;br />";
                echo "&lt;ul &gt;";
                while($row=$result->fetch_assoc()){
                    echo "&lt;li &gt; ".$row["nome"]."&lt;/li &gt;";
                }
                echo "&lt;/ul &gt; &lt;br/> Se vuoi sapere i comandi legati ad un oggetto ti basta digitare aiuto (nome_oggetto) in (luogo). &lt;br/> &lt;/span&gt;  </testo></messaggio>";
    
            }else{
                echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]."  non ci sono oggetti in ".$arrayWords[2]."  &lt;br /> &lt;/span&gt; </testo></messaggio>";
                       
            }
            $conn->close();
            
        }else{
            echo "<messaggio tipoMex=\"messaggio\"><testo>&lt;span&gt; H.A.L. : Te lo ripeto un ultima volta &lt;br /&gt; la sintassi è:  visualizza_oggetti in (nome_luogo)  &lt;br /> &lt;/span&gt; </testo></messaggio>";
        }

        $_SESSION["comandoDaPassare"]="";
        
?>
 