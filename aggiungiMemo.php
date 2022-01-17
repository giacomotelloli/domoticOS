<?php
    session_start();
    if(($_POST["nomeComando"]!="")&&($_POST["data"]!=NULL)&&($_POST["ora"]!=NULL)){

        $nomeComando=$_POST["nomeComando"];
        $idUtente=$_SESSION["id"];
        $newDate = date("j-n-Y", strtotime($_POST["data"]));
        $data=str_replace("/","-",$newDate);
        $ora=str_replace(":","-",$_POST["ora"]);
        $dataOra=$data."-".$ora;
        $percorso="xml/".$_POST["stanza"]."/".$_POST["oggetto"]."/".$_POST["oggetto"]."_memo.xml";
        $xmlString="";
        foreach ( file($percorso) as $node ) {
            $xmlString .= trim($node);
        }
        $doc1=new DOMDocument();
        $doc1->loadXMl($xmlString);
        $root=$doc1->documentElement;
        $elementi=$root->childNodes;
        $flagMemoTrovato=0;
        for($i=0;$i<$elementi->length;$i++){
            if(($elementi->item($i)->getAttribute("tempoAttivazione")==$dataOra)&&($nomeComando==$elementi->item($i)->childNodes->item(0)->nodeValue)){
                $flagMemoTrovato=1;
            break;
            }
        }
        if($flagMemoTrovato==0){
            $nuovoMemo=$doc1->createElement("memo");
            $nuovoMemo->setAttribute("idUtente",$_SESSION["id"]);
            $nuovoMemo->setAttribute("tempoAttivazione",$dataOra);

            $nuovoComando=$doc1->createElement("comando");
            $nuovoComando->nodeValue=$nomeComando;
            $nuovoMemo->appendChild($nuovoComando);
            $root->appendChild($nuovoMemo);
            $doc1->save($percorso);
            header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);
        }else{
            $_SESSION["erroreMemo"]="<span style=\"color:red;\">E' gi&agrave; stato programmato questo comando alla stessa ora</span>";
        header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);
        }
    }else{
        $_SESSION["erroreMemo"]="<span style=\"color:red;\">Devi valorizzare tutti i campi</span>";
        header("Location:paginaOggetto.php?oggetto=".$_POST["oggetto"]."&stanza=".$_POST["stanza"]);
    }
   
?>