<?php
        $comandoH=$_SESSION["comandoDaPassare"];
        $arrayWords=explode(' ',$comandoH);
        $dimArray=count($arrayWords);
        $luogoTrovato=0;

        if($comandoH==""){
            echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : La sintassi del comando è:  rimuovi_piano (nome_piano)  &lt;br /> &lt;/span&gt; </testo></messaggio>";
        }else if($dimArray==2){
            include_once "database.php";
            $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
            if (mysqli_connect_errno($conn)) {
                echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
                exit();
            }
            $queryVerificaPiano="select * from piani where(nome_piano='".$arrayWords[1]."');";
            $result=$conn->query($queryVerificaPiano);
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                $idPiano=$row["id"];
                $queryVerificaPiano="select * from piani where(piani.nome_piano='".$arrayWords[3]."');";
                $result1=$conn->query($queryVerificaPiano);

                if($result1->num_rows>0){
                    $row=$result1->fetch_assoc();
                    $idPiano=$row["id"];
                    $querySelectPiani="select nome_luogo from luoghi where(id_piano=".$idPiano.");";
                    $result2=$conn->query($queryVerificaPiano);
                    if($result2->num_rows>0){
                        foreach($result2->fetch_assoc() as $riga){
                            cancellaContenutoCartella("xml/".$riga["nome"]);
                            cancellaCartelle("xml/".$riga["nome"]);
                            rmdir("xml/".$riga["nome"]);
                        }
                    }

                    $queryEliminaOggetti="delete from oggetti,luoghi,piani where((id_luogo=luoghi.id)AND (piani.id=".$idPiano."));";
                    $conn->query($queryEliminaOggetti);

                    $queryRimuoviLuogo="delete from luoghi where( id_piano=".$idPiano.");";
                    $conn->query($queryRimuoviLuogo);


                      
                  


                    echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : ".$_SESSION["nome"]." ci sono riuscito, Ho eliminato tutto il piano!!! &lt;br /> &lt;/span&gt; </testo></messaggio>";
                    
                }else{
                    echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]." temo di non poterlo fare  &lt;br /> &lt;/span&gt; </testo></messaggio>";
                       
                }
            }else{
                echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]." temo di non poterlo fare hai inserito un piano che non eiste &lt;br /> &lt;/span&gt; </testo></messaggio>";
                       
            }
            $conn->close();
            
        }else{
            echo "<messaggio tipoMex=\"messaggio\"><testo>&lt;span&gt; H.A.L. : Te lo ripeto un ultima volta &lt;br /&gt; la sintassi è: rimuovi_piano (nome_piano)  &lt;br /> &lt;/span&gt; </testo></messaggio>";
        }

        $_SESSION["comandoDaPassare"]="";
    
        function cancellaCartelle($pathCartelle){
            if ($handle = opendir($pathCartelle))
            {
              while ($file = readdir($handle))
              {
                if (is_dir("./{$pathCartelle}/{$file}"))
                {
                  if ($file != "." & $file != ".."){
                      cancellaCartelle($pathCartelle."/".$file);
                  } 
                }
              }
            }
          }
          
          function cancellaContenutoCartella($pathCartella){
            if ($handle = opendir($pathCartella))
          {
            while ($file = readdir($handle))
            {
              if (is_dir("./{$pathCartella}/{$file}"))
              {
                if ($file != "." & $file != ".."){
                    cancellaContenutoCartella($pathCartella."/".$file);
                } 
              }
              else
              {
                if ($file != "." & $file != ".."){
                    foreach (glob($pathCartella."/*.xml") as $nomefile) {
                        unlink($nomefile);
                      }
                      
                } 
              }
            }
          }
            
          }
        
?>