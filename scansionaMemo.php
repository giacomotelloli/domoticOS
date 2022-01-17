<?php
include_once "esecutore.php";
session_start();
$arrayValoriMemo=array();

    
    $doc1=new DOMDocument();
    $doc1->load("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_memo.xml");
    $root=$doc1->documentElement;
    $elementi=$root->childNodes;
    for($k=0;$k<$elementi->length;$k++){
       
  
        $dataAttuale=strtotime(date("j-n-Y"));
        $dataOraMemo=$elementi->item($k)->getAttribute("tempoAttivazione");
        $dataMemo=strtotime(explode("-",$dataOraMemo)[0]."-".explode("-",$dataOraMemo)[1]."-".explode("-",$dataOraMemo)[2]);
        $oraMemo=explode("-",$dataOraMemo)[3].explode("-",$dataOraMemo)[4];
        $nomeComando=$elementi->item($k)->childNodes->item(0)->nodeValue;
        $oraAttuale=str_replace(":","",date("H:i"));

        if($dataAttuale>$dataMemo){
                   
                    $root->removeChild($elementi->item($k));
            
           
            $xmlString = "";
            foreach ( file("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/comandi/".$nomeComando.".xml") as $node ) {
                $xmlString .= trim($node);
            }
            $doc2=new DOMDocument();
            $doc2->loadXMl($xmlString);
            $root1=$doc2->documentElement;
            $nodi=$root1->childNodes;
            $_SESSION["fileStatoOggetto"]="xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_status.xml";
            $risultato=eseguiCodice($nodi);

        }
        else if($dataAttuale==$dataMemo){
           
            if($oraAttuale>=$oraMemo){ 
              
                 $root->removeChild($elementi->item($k));
            
                $xmlString = "";
                foreach ( file("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/comandi/".$nomeComando.".xml") as $node ) {
                    $xmlString .= trim($node);
                }
                $doc3=new DOMDocument();
                $doc3->loadXMl($xmlString);
                $root2=$doc3->documentElement;
                $nodi2=$root2->childNodes;
                $_SESSION["fileStatoOggetto"]="xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_status.xml";
                $risultato1=eseguiCodice($nodi2);
          }
        }
    }

    $doc1->save("xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_memo.xml");
      
?>