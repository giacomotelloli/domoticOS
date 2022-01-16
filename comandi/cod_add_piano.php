<?php
        
        $comandoH=$_SESSION["comandoDaPassare"];
        $arrayWords=explode(' ',$comandoH);
        $dimArray=count($arrayWords);
        $luogoTrovato=0;

        if($comandoH==""){
            echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : La sintassi del comando è:  aggiungi_piano (nome_piano) &lt;br /> &lt;/span&gt; </testo></messaggio>";
        }else if($dimArray==2){
           include_once "database.php";
            $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
            if (mysqli_connect_errno($conn)) {
                echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
                exit();
            }
                    $queryAggiuntaPiano="insert into piani (nome_piano) values ('".$arrayWords[1]."');";
                    
                    if (!$conn->query($queryAggiuntaPiano)){
                        $_SESSION["messaggioRitorno"]=$conn->error."<br/>";
                    }else{

                        echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : ".$_SESSION["nome"]." ci sono riuscito, finalmente !!! &lt;br /> &lt;/span&gt; </testo></messaggio>";
                    }
            $conn->close();
            
        }else{
            echo "<messaggio tipoMex=\"messaggio\"><testo>&lt;span&gt; H.A.L. : Te lo ripeto un ultima volta &lt;br /&gt; la sintassi è: aggiungi_piano (nome_piano)  &lt;br /> &lt;/span&gt; </testo></messaggio>";
        }

        $_SESSION["comandoDaPassare"]="";
        
?>