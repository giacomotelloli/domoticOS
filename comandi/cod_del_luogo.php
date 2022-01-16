<?php
        
        session_start();
        $comandoH=$_SESSION["comandoDaPassare"];
        $arrayWords=explode(' ',$comandoH);
        $dimArray=count($arrayWords);
        $luogoTrovato=0;

        if($comandoH==""){
            echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : La sintassi del comando è:  rimuovi_luogo (nome_stanza) al (nome_piano)  &lt;br /> &lt;/span&gt; </testo></messaggio>";
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
                $queryVerificaLuogo="select * from luoghi,piani where((luoghi.id_piano=piani.id)AND(piani.nome_piano='".$arrayWords[3]."')AND(luoghi.nome_luogo='".$arrayWords[1]."'));";
                $result1=$conn->query($queryVerificaLuogo);

                if($result1->num_rows>0){
                    $row=$result1->fetch_assoc();
                    $idLuogo=$row["id"];
                    $queryRimuoviLuogo="delete from luoghi where((nome_luogo='".$arrayWords[1]."')AND(id_piano=".$idPiano."));";
                    $conn->query($queryRimuoviLuogo);

                      
                    $queryEliminaOggetti="delete from oggetti where(id_luogo=".$idLuogo.");";
                    $conn->query($queryEliminaOggetti);

                    
                    cancellaContenutoCartella("xml/".$arrayWords[1]);
                    cancellaCartelle("xml/".$arrayWords[1]);
                    rmdir("xml/".$arrayWords[1]);

                    echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : ".$_SESSION["nome"]." ci sono riuscito, Ho eliminato il luogo e gli oggetti al suo interno!!! &lt;br /> &lt;/span&gt; </testo></messaggio>";
                    
                }else{
                    echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]." temo di non poterlo fare  &lt;br /> &lt;/span&gt; </testo></messaggio>";
                       
                }
            }else{
                echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  Scusa ".$_SESSION["nome"]." temo di non poterlo fare hai inserito un piano che non eiste &lt;br /> &lt;/span&gt; </testo></messaggio>";
                       
            }
            $conn->close();
            
        }else{
            echo "<messaggio tipoMex=\"messaggio\"><testo>&lt;span&gt; H.A.L. : Te lo ripeto un ultima volta &lt;br /&gt; la sintassi è: aggiungi_luogo (nome_stanza) al (nome_piano)  &lt;br /> &lt;/span&gt; </testo></messaggio>";
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

    
}
?>