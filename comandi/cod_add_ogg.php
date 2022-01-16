<?php
       
        $comandoH=$_SESSION["comandoDaPassare"];
        $arrayWords=explode(' ',$comandoH);
        $dimArray=count($arrayWords);
        $luogoTrovato=0;

        if($comandoH==""){
            echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : La sintassi del comando è: aggiungi_oggetto (nome_oggetto) in (nome_luogo)   &lt;br /> &lt;/span&gt; </testo></messaggio>";
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
                $result1=$conn->query($queryVerificaLuogo);

                if(!($result1->num_rows>0)){
                    $queryAggiuntaOggetto="insert into oggetti (nome,id_luogo) values ('".$arrayWords[1]."',".$idLuogo.");";
                    $conn->query($queryAggiuntaOggetto);

                    if(mkdir("xml/".$arrayWords[3]."/".$arrayWords[1])){
                        mkdir("xml/".$arrayWords[3]."/".$arrayWords[1]."/comandi");
                        touch("xml/".$arrayWords[3]."/".$arrayWords[1]."/".$arrayWords[1]."_variables.xml");
                        $fp = fopen("xml/".$arrayWords[3]."/".$arrayWords[1]."/".$arrayWords[1]."_variables.xml", "w+");
                        fwrite($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\"?><variabili xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../variables.xsd\"></variabili>");
                        fclose($fp);

                        touch("xml/".$arrayWords[3]."/".$arrayWords[1]."/".$arrayWords[1]."_commands.xml");
                        $fp = fopen("xml/".$arrayWords[3]."/".$arrayWords[1]."/".$arrayWords[1]."_commands.xml", "w+");
                        fwrite($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\"?><comandi xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../commands.xsd\"></comandi>");
                        fclose($fp);

                        touch("xml/".$arrayWords[3]."/".$arrayWords[1]."/".$arrayWords[1]."_memo.xml");
                        $fp = fopen("xml/".$arrayWords[3]."/".$arrayWords[1]."/".$arrayWords[1]."_memo.xml", "w+");
                        fwrite($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\"?><lista_memo xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../memo.xsd\"></lista_memo>");
                        fclose($fp);

                        touch("xml/".$arrayWords[3]."/".$arrayWords[1]."/".$arrayWords[1]."_status.xml");
                        $fp = fopen("xml/".$arrayWords[3]."/".$arrayWords[1]."/".$arrayWords[1]."_status.xml", "w+");
                        fwrite($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\"?><stati xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../status.xsd\"></stati>");
                        fclose($fp);
                    } else{
                        echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : ".$_SESSION["nome"]."  non ci sono riuscito, c'è stato un problema nella creazione della cartella !!! &lt;br /> &lt;/span&gt; </testo></messaggio>";
                    }

                    echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : ".$_SESSION["nome"]." ci sono riuscito, finalmente !!! &lt;br /> &lt;/span&gt; </testo></messaggio>";
                    
                }else{
                    echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]." temo di non poterlo fare già esiste un oggetto con questo nome,per evitare ambiguità inseriscine uno con un nome diverso &lt;br /> &lt;/span&gt; </testo></messaggio>";
                       
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