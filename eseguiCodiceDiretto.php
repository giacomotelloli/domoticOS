<?php
include_once "esecutore.php";
    $codice=$_POST["codice"];
    $codice=str_replace("piu","+",$codice);
    $xmlString="";
    $xmlString .= trim($codice);

    $doc2=new DOMDocument();
    $doc2->loadXMl($xmlString);
    $root=$doc2->documentElement;
    $elementi=$root->childNodes;

    $fileStatoOggetto=$_POST["fileStato"];
    $_SESSION["fileStatoOggetto"]=$fileStatoOggetto;
    echo eseguiCodice($elementi);
?>