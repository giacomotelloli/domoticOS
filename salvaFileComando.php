<?php
    $pathFileComandi=$_POST["pathFileComandi"];
    $pathCartella=$_POST["pathCartella"];
    $nomeFile=$_POST["nomeFile"];
    $livelloComando=$_POST["livelloComando"];
   
    $codice=$_POST["codice"];

   $codice=str_replace("piu","+",$codice);
    if(($nomeFile!=NULL)&&($nomeFile!="")){
        
    $file=fopen($pathCartella.$nomeFile,"w");
    fwrite($file,$codice);
    fclose($file);
    }else{
        echo "<p><h4 style=\"color:black;\">";
                echo "Errore inserisci il nome del comando";
                echo "</h4></p>";
    }

    if(isset($livelloComando)){
                 $doc1=new DOMDocument();
                $xmlString = "";
                foreach ( file($pathFileComandi) as $node ) {
                    $xmlString .= trim($node);
                }   
                $doc1->loadXMl($xmlString);
                $root=$doc1->documentElement;
                $listaComandi=$root->childNodes;
                
                $flagStessoNome=0;
                $flagStessoLivello=0;
                for($i=0;$i<$listaComandi->length;$i++){
                    if($listaComandi->item($i)->childNodes->item(2)->nodeValue=="comandi/".$nomeFile){
                        $flagStessoNome=1;    
                        if($listaComandi->item($i)->childNodes->item(0)->nodeValue==$livelloComando){
                            $flagStessoLivello=1;
                        }
                        if($flagStessoLivello==0){
                            $listaComandi->item($i)->childNodes->item(0)->nodeValue=$livelloComando;
                        }
                    break;
                    }
                }
               
                if($flagStessoNome==0){
                    
                $nuovoCom=$doc1->createElement("comando");
                $nodoLivello=$doc1->createElement("livelloPermesso");
                $nodoCodice=$doc1->createElement("codiceComando");
                $nodoVerbo=$doc1->createElement("verboComando");

                $nodoCodice->nodeValue="comandi/".$nomeFile;
                $nodoVerbo->nodeValue=explode(".",$nomeFile)[0];
                $nodoLivello->nodeValue=$livelloComando;

                $nuovoCom->appendChild($nodoLivello);
                $nuovoCom->appendChild($nodoVerbo);
                $nuovoCom->appendChild($nodoCodice);

                $root->appendChild($nuovoCom);
  
                }             
                $doc1->save($pathFileComandi);
                
                echo "<p><h4 style=\"color:black;\">";
                echo "Il comando è stato salvato";
                echo "</h4></p>";
                
    }else{
        echo "<p><h4 style=\"color:black;\">";
        echo "Errore inserisci il livello comando";
        echo "</h4></p>";
    }
?>