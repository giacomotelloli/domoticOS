<?php
       $nomeVariabile=$_POST["nomeVariabile"];
       $path=$_POST["pathXml"];
       $valoreDaAggiungere=$_POST["valoreDaAggiungere"];
   
      
       $xmlString = "";
       foreach ( file($path) as $node ) {
           $xmlString .= trim($node);
       }
       $doc=new DOMDocument();
       $doc->loadXMl($xmlString);
       $root=$doc->documentElement;
       $elementi=$root->childNodes;
       $flagTrovato=0;
       for($i=0;$i<$elementi->length;$i++){
           if($elementi->item($i)->getAttribute("nome")==$nomeVariabile){
               $flagTrovato=1;
               $nuovoElem=$doc->createElement("valoreStato");
               $nuovoElem->nodeValue=$valoreDaAggiungere;
               $elementi->item($i)->appendChild($nuovoElem);
           break;
           }
       }
       $doc->save($path);
       if($flagTrovato==1){
   
           echo "valore aggiunto";
       }else{
           echo "non ho trovato il valore";
       }
?>