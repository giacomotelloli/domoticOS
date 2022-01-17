<?php
    session_start();
    if(isset($_SESSION["pathComandi"])&&isset($_SESSION["pathCodice"])){
        
    $pathCom=$_SESSION["pathComandi"];
    $pathCodice=$_SESSION["pathCodice"];
    $nomeCom=$_POST["comando"];
    $doc1=new DOMDocument();
    $xmlString = "";
    foreach ( file($pathCom) as $node ) {
        $xmlString .= trim($node);
    }   
    $doc1->loadXMl($xmlString);
    $root=$doc1->documentElement;
    $elements=$root->childNodes;
    $flagRimosso=0;
    for($i=0;$i<$elements->length;$i++){
        if($elements->item($i)->childNodes->item(1)->nodeValue==$nomeCom){
            $root->removeChild($elements->item($i));
            $flagRimosso=1;
        break;
        }
    }
    $doc1->save($pathCom);
if($flagRimosso==1){
    
    unlink($pathCodice);

    unset($_SESSION["pathComandi"]);
    unset($_SESSION["pathCodice"]);
    echo "<p><h4 style=\"color:black;\">";
    echo "Il comando &egrave; stato eliminato";
    echo "</h4></p>";

}else{
    echo "<p><h4 style=\"color:black;\">";
    echo "Il comando non &egrave; stato eliminato";
    echo "</h4></p>";
    
}
    }else{
        echo "<p><h4 style=\"color:black;\">";
    echo "Il comando non &egrave; stato eliminato devi selezionarne uno prima";
    echo "</h4></p>";
        
    }
?>