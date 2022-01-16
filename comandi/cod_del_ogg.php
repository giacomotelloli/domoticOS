<?php
     
        $comandoH=$_SESSION["comandoDaPassare"];
        $arrayWords=explode(' ',$comandoH);
        $dimArray=count($arrayWords);
        $luogoTrovato=0;

        if($comandoH==""){
            echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : La sintassi del comando è:   rimuovi_oggetto (nome_oggetto) in (nome_luogo)   &lt;br /> &lt;/span&gt; </testo></messaggio>";
        }else if($dimArray==4){
            include_once "database.php";
            $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
            if (mysqli_connect_errno($conn)) {
                echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
                exit();
            }
            $queryVerificaPiano="select * from luoghi where(nome_luogo='".$arrayWords[3]."');";
            $result=$conn->query($queryVerificaPiano);
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                $idLuogo=$row["id"];
                $queryVerificaOggetto="select nome from oggetti,luoghi where((oggetti.id_luogo=luoghi.id)AND(luoghi.nome_luogo='".$arrayWords[3]."')AND(oggetti.nome='".$arrayWords[1]."'));";
                $result1=$conn->query($queryVerificaOggetto);

                if($result1->num_rows>0){
                    $queryRimozioneOggetto="delete from oggetti where ((nome='".$arrayWords[1]."') AND (id_luogo=".$idLuogo."));";
                    $conn->query($queryRimozioneOggetto);

                    foreach (glob("xml/".$arrayWords[3]."/".$arrayWords[1]."/*.xml") as $nomefile) {
                        unlink($nomefile);
                      }
                      foreach (glob("xml/".$arrayWords[3]."/".$arrayWords[1]."/comandi/*.xml") as $nomefile) {
                        unlink($nomefile);
                      }
                      
                      rmdir("xml/".$arrayWords[3]."/".$arrayWords[1]."/comandi");
                    if(rmdir("xml/".$arrayWords[3]."/".$arrayWords[1])){
                        echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : Bene ".$_SESSION["nome"]." ho rimosso l'oggetto definitivamente  &lt;br /> &lt;/span&gt; </testo></messaggio>";
                        
                    } else{
                        echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : ".$_SESSION["nome"]."  non ci sono riuscito, c'è stato un problema nella cancellazione della cartella,dovrai farlo manualmente !!! &lt;br /> &lt;/span&gt; </testo></messaggio>";
                    }

                    
                }else{
                    echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]." temo di non poterlo fare già esiste un luogo con questo nome,per evitare ambiguità inseriscine uno con un nome diverso &lt;br /> &lt;/span&gt; </testo></messaggio>";
                       
                }
            }else{
                echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]." temo di non poterlo fare hai inserito un luogo che non eiste &lt;br /> &lt;/span&gt; </testo></messaggio>";
                       
            }
            $conn->close();
            
        }else{
            echo "<messaggio tipoMex=\"messaggio\"><testo>&lt;span&gt; H.A.L. : Te lo ripeto un ultima volta &lt;br /&gt; la sintassi è:  aggiungi_oggetto (nome_oggetto) in (nome_luogo)   &lt;br /> &lt;/span&gt; </testo></messaggio>";
        }

        $_SESSION["comandoDaPassare"]="";
        
?>