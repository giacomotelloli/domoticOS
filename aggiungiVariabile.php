<?php
    if(isset($_POST["stanza"])&&isset($_POST["oggetto"])){
        if(isset($_POST["tipoVal"])&&($_POST["nomeVariabile"]!="")){
            if($_POST["tipoVal"]=="Numerico"){
                if(($_POST["valMax"]!="")&&($_POST["valMin"]!="")&&($_POST["valUnita"]!="")&&($_POST["nomeVariabile"]!="")){
              
                $xmlString = "";
              foreach ( file("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_variables.xml") as $node ) {
                  $xmlString .= trim($node);
              }
              $doc1=new DOMDocument();
              $doc1->loadXMl($xmlString);
              $root=$doc1->documentElement;
              $elementi=$root->childNodes;
              
                
                $variabile=$doc1->createElement("variabile");
                $variabile->setAttribute("nome",$_POST["nomeVariabile"]);
                $variabile->setAttribute("valoreMax",$_POST["valMax"]);
                $variabile->setAttribute("valoreMin",$_POST["valMin"]);

                $unitaMisura=$doc1->createElement("unitaMisura");
                $unitaMisura->nodeValue=$_POST["valUnita"];

                $variabile->appendChild($unitaMisura);
                $root->appendChild($variabile);

                $doc1->save("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_variables.xml");
                    $xmlString = "";
                    foreach ( file("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_status.xml") as $node ) {
                        $xmlString .= trim($node);
                    }
                    $doc1=new DOMDocument();
                    $doc1->loadXMl($xmlString);
                    $root=$doc1->documentElement;

                    $ultimo=$root->lastChild;
                    $nuovoUltimo=$doc1->createElement("stato");
                    for($j=0;$j<$ultimo->childNodes->length;$j++){
                        $varOsservata=$doc1->createElement("varOsservata");
                        $varOsservata->setAttribute("nome",$ultimo->childNodes->item($j)->getAttribute("nome"));
                        $varValore=$doc1->createElement("valore");
                        $varValore->nodeValue=$ultimo->childNodes->item($j)->lastChild->nodeValue;
                        $varOsservata->appendChild($varValore);
                        $nuovoUltimo->appendChild($varOsservata);
                    }

                    $nuovoUltimo->setAttribute("timestamp",date("j-n-Y")."-".date("H-i-s"));
                    
                    $nuovoTag=$doc1->createElement("varOsservata");
                    $nuovoTag->setAttribute("nome",$_POST["nomeVariabile"]);

                    $nuovoTagValore=$doc1->createElement("valore");
                    $nuovoTagValore->nodeValue=rand($_POST["valMin"],$_POST["valMax"]);

                    $nuovoTag->appendChild($nuovoTagValore);

                    $nuovoUltimo->appendChild($nuovoTag);
                    $root->appendChild($nuovoUltimo);
                    $doc1->save("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_status.xml");
                header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);
                }else{
                    header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);    
                }
            }else if($_POST["tipoVal"]=="Letterale"){
                    $numVariabili=$_POST["numMaxValori"];
                    $flagInputVuoto=0;
                    for($i=0;$i<$numVariabili;$i++){
                        if(!isset($_POST[$i])||($_POST[$i]=="")){
                        
                          $flagInputVuoto=1;

                        }
                        
                    }
                    if($flagInputVuoto==0){
                        
                    $xmlString = "";
                    foreach ( file("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_variables.xml") as $node ) {
                        $xmlString .= trim($node);
                    }
                    $doc1=new DOMDocument();
                    $doc1->loadXMl($xmlString);
                    $root=$doc1->documentElement;

                     $nuovoNodo=$doc1->createElement("variabile");
                     $nuovoNodo->setAttribute("nome",$_POST["nomeVariabile"]);

                    for($i=0;$i<$numVariabili;$i++){
                      $nodoValore=$doc1->createElement("valoreStato");
                      $nodoValore->nodeValue=$_POST[$i];
                      $nuovoNodo->appendChild($nodoValore); 
                    }

                    $root->appendChild($nuovoNodo);
                    $doc1->save("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_variables.xml");
                    $xmlString = "";
                    foreach ( file("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_status.xml") as $node ) {
                        $xmlString .= trim($node);
                    }
                    $doc1=new DOMDocument();
                    $doc1->loadXMl($xmlString);
                    $root=$doc1->documentElement;

                    $ultimo=$root->lastChild;

                    $nuovoUltimo=$doc1->createElement("stato");
                    $nuovoUltimo->setAttribute("timestamp",date("j-n-Y")."-".date("H-i-s"));
                    for($j=0;$j<$ultimo->childNodes->length;$j++){
                        $varOsservata=$doc1->createElement("varOsservata");
                        $varOsservata->setAttribute("nome",$ultimo->childNodes->item($j)->getAttribute("nome"));
                        $varValore=$doc1->createElement("valore");
                        $varValore->nodeValue=$ultimo->childNodes->item($j)->lastChild->nodeValue;
                        $varOsservata->appendChild($varValore);
                        $nuovoUltimo->appendChild($varOsservata);
                    }

                    $nuovoTag=$doc1->createElement("varOsservata");
                    $nuovoTag->setAttribute("nome",$_POST["nomeVariabile"]);

                    $nuovoTagValore=$doc1->createElement("valore");
                    $valoreCasuale=rand(0,$numVariabili-1);

                    $nuovoTagValore->nodeValue=$_POST[$valoreCasuale];
                    $nuovoTag->appendChild($nuovoTagValore);
                    $nuovoUltimo->appendChild($nuovoTag);
                    $root->appendChild($nuovoUltimo);
                    $doc1->save("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_status.xml");
                   header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);
                    }else{
                        header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);
                    }
            }else{
                header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);
            }
        }else{
            header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);
        }
    }else{
        header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);
    }

?>