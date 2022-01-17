<?php
    $nomeVariabile=$_POST["nomeVariabile"];
    $path=$_POST["pathXml"];
    $valoreDaEliminare=$_POST["valoreDaEliminare"];

   
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
            $listaValori=$elementi->item($i)->childNodes;
            for($j=0;$j<$listaValori->length;$j++){
                if($listaValori->item($j)->nodeValue==$valoreDaEliminare){
                    $elementi->item($i)->removeChild($listaValori->item($j));
                    $flagTrovato=1;
                break;
                }
            }
        break;
        }
    }
    $doc->save($path);
    if($flagTrovato==1){

        echo "valore eliminato";
    }else{
        echo "non ho trovato il valore";
    }
?>