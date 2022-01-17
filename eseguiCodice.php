<?php
    session_start();
    include_once "esecutore.php";

    $pathCodice=$_GET["path"];
    $fileStatoOggetto=$_GET["fileStato"];
    $xmlString = "";
    foreach ( file($pathCodice) as $node ) {
        $xmlString .= trim($node);
    }
    $doc1=new DOMDocument();
    $doc1->loadXMl($xmlString);
    $root=$doc1->documentElement;
    $elementi=$root->childNodes;
    $_SESSION["fileStatoOggetto"]=$fileStatoOggetto;
    echo eseguiCodice($elementi);
?>