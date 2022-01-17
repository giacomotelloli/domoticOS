<?php
    $variabileDaEliminare=$_POST["nomeVariabile"];
    $stanza=$_POST["stanza"];
    $oggetto=$_POST["oggetto"];
//eliminare la variabile dal file xml delle variabili
    $xmlString = "";
              foreach ( file("xml/".$stanza."/".$oggetto."/".$oggetto."_variables.xml") as $node ) {
                   $xmlString .= trim($node);
              }
              $doc=new DOMDocument();
              $doc->loadXMl($xmlString);
              $root=$doc->documentElement;
              $elementi=$root->childNodes;
              for($i=0;$i<$elementi->length;$i++){
                  if($elementi->item($i)->getAttribute("nome")==$variabileDaEliminare){
                      $root->removeChild($elementi->item($i));
                  }
              }
              $doc->save("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_variables.xml");
//aggiungere un nuovo stato senza la variabile
        $xmlString = "";
        foreach ( file("xml/".$stanza."/".$oggetto."/".$oggetto."_status.xml") as $node ) {
            $xmlString .= trim($node);
        }
        $doc=new DOMDocument();
        $doc->loadXMl($xmlString);
        $root=$doc->documentElement;
        $ultimoElemento=$root->lastChild;
        //scorro le variabili osservate
        $listaVar=$ultimoElemento->childNodes;
        for($i=0;$i<$listaVar->length;$i++){
            if($listaVar->item($i)->getAttribute("nome")==$variabileDaEliminare){
                $ultimoElemento->removeChild($listaVar->item($i));
            }
        }
        $statoClone=$ultimoElemento->cloneNode(true);
        $statoClone->setAttribute("timestamp",date("j-n-Y")."-".date("H-i-s"));
        $root->appendChild($statoClone);
        $doc->save("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_status.xml");
//tornare alla pagina dell'oggetto
header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);
?>