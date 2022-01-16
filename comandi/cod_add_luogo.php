<?php
       
        $comandoH=$_SESSION["comandoDaPassare"];
        $arrayWords=explode(' ',$comandoH);
        $dimArray=count($arrayWords);
        $luogoTrovato=0;

        if($comandoH==""){
            echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : La sintassi del comando è:  aggiungi_luogo (nome_stanza) al (nome_piano)  &lt;br /> &lt;/span&gt; </testo></messaggio>";
        }else if($dimArray==4){
            include_once "database.php";
            $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
            if (mysqli_connect_errno($conn)) {
                echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
                exit();
            }
            $queryVerificaPiano="select * from piani where(nome_piano='".$arrayWords[3]."');";
            $result=$conn->query($queryVerificaPiano);
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                $idPiano=$row["id"];
                $queryVerificaLuogo="select nome_luogo from luoghi,piani where((luoghi.id_piano=piani.id)AND(piani.nome_piano='".$arrayWords[3]."')AND(luoghi.nome_luogo='".$arrayWords[1]."'));";
                $result1=$conn->query($queryVerificaLuogo);

                if(!($result1->num_rows>0)){
                    $queryAggiuntaLuogo="insert into luoghi (nome_luogo,id_piano) values ('".$arrayWords[1]."',".$idPiano.");";
                    $conn->query($queryAggiuntaLuogo);

                    echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : ".$_SESSION["nome"]." ci sono riuscito, finalmente !!! &lt;br /> &lt;/span&gt; </testo></messaggio>";
                    
                    mkdir("xml/".$arrayWords[1]);
                }else{
                    echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]." temo di non poterlo fare già esiste un luogo con questo nome,per evitare ambiguità inseriscine uno con un nome diverso &lt;br /> &lt;/span&gt; </testo></messaggio>";
                       
                }
            }else{
                echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]." temo di non poterlo fare hai inserito un piano che non eiste &lt;br /> &lt;/span&gt; </testo></messaggio>";
                       
            }
            $conn->close();
            
        }else{
            echo "<messaggio tipoMex=\"messaggio\"><testo>&lt;span&gt; H.A.L. : Te lo ripeto un ultima volta &lt;br /&gt; la sintassi è: aggiungi_luogo (nome_stanza) al (nome_piano)  &lt;br /> &lt;/span&gt; </testo></messaggio>";
        }

        $_SESSION["comandoDaPassare"]="";
        
?>