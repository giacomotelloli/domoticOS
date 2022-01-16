<?php
$comandoH=$_SESSION["comandoDaPassare"];
$arrayWords=explode(' ',$comandoH);
$dimArray=count($arrayWords);

    if($dimArray==4){
            include_once "database.php";
            $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
            if (mysqli_connect_errno($conn)) {
                echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
                exit();
            }
            $queryOgg="select nome from oggetti,luoghi where((oggetti.id_luogo=luoghi.id)AND(nome_luogo='".$arrayWords[3]."')AND(oggetti.nome='".$arrayWords[1]."'));";
            $result=$conn->query($queryOgg);
            if($result->num_rows>0){
                $percorsoFileComOgg="xml/".$arrayWords[1]."/".$arrayWords[1]."_commands.xml";
                
            }else{
                echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. :  ".$_SESSION["nome"]." temo che tu abbia sbagliato il nome del luogo,oppure non ci sono proprio oggetti in ".$arrayWords[3]."  &lt;br /> &lt;/span&gt; </testo></messaggio>";
             
            }
            $conn->close();
    }else{
        
    $xmlString1 = "";
    foreach ( file("hal_commands.xml") as $node1 ) {
         $xmlString1 .= trim($node1);
    }
    $doc1=new DOMDocument();
    $doc1->loadXMl($xmlString1);
    $root1=$doc1->documentElement;
    $elementi1=$root1->childNodes;
     echo "<messaggio tipoMex=\"messaggio\"><testo>&lt;span&gt;Puoi inviare i seguenti comandi ad HAL: &lt;br />";
      echo "&lt;ul &gt;";
             for($j=0;$j<$elementi1->length;$j++){
                 
                 $elemento1=$elementi1->item($j);
                 $tagLiv1=$elemento1->childNodes->item(0);
                 $livCom1=$tagLiv1->textContent;
                 
                 if($livCom1<=$livello){
                    
                     $parametri1=$elemento1->childNodes->item(1);
                     $comandoAcc=$parametri1->textContent;
                     
                    echo "&lt;li &gt; ".$comandoAcc."&lt;/li &gt;";
                 }
 
             }                    
              
      echo "&lt;/ul &gt; &lt;br/>  La sintassi dei comandi è questa: verbo [ oggetto in luogo [alle data_e_ora]] &lt;br/> &lt;/span&gt;  </testo></messaggio>";
      
 
    }
    
?>