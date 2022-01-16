<?php

    $comandoH=$_SESSION["comandoDaPassare"];
    $arrayWords=explode(' ',$comandoH);
    $dimArray=count($arrayWords);
    $luogoDaControllare=$arrayWords[4];
    $oggettoDaControllare=$arrayWords[2];
    if($dimArray==1){
        echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : La sintassi del comando è: modifica_livello_comando (verbo_comando) (oggetto) in (luogo)  in (nuovo_livello) &lt;br /> &lt;/span&gt; </testo></messaggio>";       
    }else if($dimArray==7){
        include_once "database.php";
        $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
                    if (mysqli_connect_errno($conn)) {
                        echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
                        exit();
                    }
        $queryControlloPosto="select nome from oggetti,luoghi where ((oggetti.id_luogo=luoghi.id) AND (luoghi.nome_luogo='".$luogoDaControllare."'));";
        $result=$conn->query($queryControlloPosto);

        if($result->num_rows > 0){
            while($row=$result->fetch_assoc()){
                if($row["nome"]==$oggettoDaControllare){
                    $xmlStringa = "";
                    foreach ( file("xml/".$oggettoDaControllare."/".$oggettoDaControllare."_commands.xml") as $node ) {
                            $xmlStringa.= trim($node);
                    }
                    $docx=new DOMDocument();
                    $docx->loadXMl($xmlStringa);
                    $radice=$docx->documentElement;
                    $elements=$radice->childNodes;
                    $flagComTrov=0;
                    for($i=0;$i<$elements->length;$i++){
                        $element=$elements->item($i);
                        $levelCom=$element->childNodes->item(0)->textContent;
                        $nameCom=$element->childNodes->item(1)->textContent;
                        if($nameCom==$arrayWords[1]){
                            $flagComTrov=1;
                           
                            $element->childNodes->item(0)->replaceChild($docx->createTextNode($arrayWords[6]),$element->childNodes->item(0)->childNodes->item(0));
                            $docx->save("xml/".$oggettoDaControllare."/".$oggettoDaControllare."_commands.xml");
                        break;
                        }
                    }
                    if($flagComTrov==0){
                        echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : Scusa ".$_SESSION["nome"]." temo che non esista alcun comando con quel nome collegato a questo oggetto &lt;br /> &lt;/span&gt; </testo></messaggio>";            
                    }else{
                        echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : Ehi ".$_SESSION["nome"]." ho cambiato il livello,sono stato bravo? &lt;br /> &lt;/span&gt; </testo></messaggio>";             
                    }
                   
                break;
                }
            }
            
        }else{
            echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : Scusa ".$_SESSION["nome"]." temo che il luogo sia sbagliato o non esista proprio &lt;br /> &lt;/span&gt; </testo></messaggio>";           
    
        }
        $conn->close();
        
    }else{
        echo "<messaggio tipoMex=\"messaggio\"><testo> &lt;span&gt;H.A.L. : Scusa ".$_SESSION["nome"]." temo di non poterlo fare &lt;br /> &lt;/span&gt; </testo></messaggio>";           
    }
    $_SESSION["comandoDaPassare"]="";
?>