<?php
    $nomeVariabile=$_POST["nomeVariabile"];
    $path=$_POST["pathXml"];
    $nomeCambiato=$_POST["nomeCambiato"];
    $nuovaUnita=$_POST["nuovaUnita"];
    $nuovoMax=$_POST["nuovoMax"];
    $nuovoMin=$_POST["nuovoMin"];


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
            if($elementi->item($i)->getAttribute("nome")!=$nomeCambiato){
                $elementi->item($i)->setAttribute("nome",$nomeCambiato);
            }
            if($elementi->item($i)->getAttribute("valoreMax")!=$nuovoMax){
                $elementi->item($i)->setAttribute("valoreMax",$nuovoMax);
            }
            if($elementi->item($i)->getAttribute("valoreMin")!=$nuovoMin){
                $elementi->item($i)->setAttribute("valorein",$nuovoMin);
            }
            if($elementi->item($i)->childNodes->item(0)->nodeValue!=$nuovaUnita){
                $elementi->item($i)->childNodes->item(0)->nodeValue=$nuovaUnita;
            }
            $flagTrovato=1;
        break;
        }
    }
    $doc->save($path);
    if($flagTrovato==1){

        echo "Modifiche effettuate con succcesso";
    }else{
        echo "non ho trovato il valore";
    }
?>
