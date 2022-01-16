<?php
           
            $comandoH=$_SESSION["comandoDaPassare"];
            $arrayWords=explode(' ',$comandoH);
            $dimArray=count($arrayWords);
            $emailTrovata=0;
            if($comandoH==""){
                echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : La sintassi del comando è: modifica_livello_utente (email_utente) in (nuovo_livello)   &lt;br /> &lt;/span&gt; </testo></messaggio>";
            
            }else if($dimArray==4){
                    $emailRicevuta=$arrayWords[1];
                    include_once "database.php";
                    $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
                    if (mysqli_connect_errno($conn)) {
                        echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
                        exit();
                    }
                    $queryVerificaEmail="select * from utenti_casa;";
                    $result=$conn->query($queryVerificaEmail);
                    if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){
                            if($row["email"]==$emailRicevuta){
                                $emailTrovata=1;
                                $queryUpdateLivello="update utenti_casa set livello_permesso=".$arrayWords[3]." where email='".$emailRicevuta."';";
                                $conn->query($queryUpdateLivello);
                                echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : Update eseguito con successo &lt;br /> &lt;/span&gt; </testo></messaggio>";
                                break;

                            }
                        }
                       
                    }
                    $conn->close();
                    if($emailTrovata==0){
                        echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]." temo di non poterlo fare &lt;br /> &lt;/span&gt; </testo></messaggio>";
                                
                    }
           }else{
            echo "<messaggio tipoMex=\"messaggio\"><testo>&lt;span&gt;H.A.L. : Te lo ripeto un ultima volta&lt;br /&gt;  La sintassi del comando è: modifica_livello_utente (email_utente) in (nuovo_livello)   &lt;br /> &lt;/span&gt; </testo></messaggio>";
           }
           $_SESSION["comandoDaPassare"]="";
             
           
        
?>