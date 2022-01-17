<?php
    session_start();
    
    $pathCodice=$_GET["pathCod"];
    $pathComandi=$_GET["pathCom"];
    $_SESSION["pathCodice"]=$pathCodice;
    $_SESSION["pathComandi"]=$pathComandi;
    $stringCod="";
    foreach(file($pathCodice) as $node){
        $stringCod.=$node;
    }
echo $stringCod;

?>