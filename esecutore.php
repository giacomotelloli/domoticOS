<?php
   $_SESSION["errore"]="";
   $_SESSION["messaggi"]="";
   function eseguiCodice($elementiCodice){
        $risultato=0;
        
        if($elementiCodice->item(0)->nodeName=="listaVariabili"){
                $fileStatoOggetto=$_SESSION["fileStatoOggetto"];
                $listaVariabili=$elementiCodice->item(0)->childNodes;
                $xmlString = "";
                foreach ( file($fileStatoOggetto) as $node ) {
                    $xmlString .= trim($node);
                }
                $doc1=new DOMDocument();
                $doc1->loadXMl($xmlString);
                $root=$doc1->documentElement;
                $ultimoStato=$root->lastChild;
                $ultimeVariabili=$ultimoStato->childNodes;
                
                $l=0;
                for($j=0;$j<$listaVariabili->length;$j++){
                    $nomeVariabile=$listaVariabili->item($j)->nodeValue;
                    for($k=0;$k<$ultimeVariabili->length;$k++){
                        if($ultimeVariabili->item($k)->getAttribute("nome")==$nomeVariabile){
                            $_SESSION[$nomeVariabile]=$ultimeVariabili->item($k)->firstChild->nodeValue;    
                            $_SESSION["arrayNomiVariabili"][$l]=$nomeVariabile;
                            $l++;   
                        }
                    }
                }
                $_SESSION["numeroVariabili"]=$l;
            for($i=1;$i<$elementiCodice->length;$i++){
                $nodo=$elementiCodice->item($i);
                $risultato=valutaNodo($nodo);
                if($risultato!=0){
                    break;
                }
            }
        }else{
            for($i=0;$i<$elementiCodice->length;$i++){
                $nodo=$elementiCodice->item($i);
                $risultato=valutaNodo($nodo);
                if($risultato!=0){
                    break;
                }
            }
        }
  return $risultato;
    }

    function valutaNodo($nodoDaValutare){
        $nomeNodo=$nodoDaValutare->nodeName;
        $figli=$nodoDaValutare->childNodes;
        switch($nomeNodo){
            case "cicloPre":
                    $condizioneFiglio=$figli->item(0);
                    if(valutaCondizione($condizioneFiglio)){

                       if(eseguiCodice($figli->item(1)->childNodes)==0){
                            return valutaNodo($nodoDaValutare);                         
                       }else{
                           return 1;
                       }    
                    }else{
                        return 0;
                    }
            break;

            case "cicloPost":
                     if(eseguiCodice($figli->item(0)->childNodes)==0){
                        if(valutaCondizione($figli->item(1))){
                            return valutaNodo($nodoDaValutare);
                        }else{
                            return 1;
                        }
                   }else{
                       return 1;
                   }
            break;

            case "se":
                    if($figli->length==3){    
                        $figlioCondizione=$figli->item(0);
                        $figlioVera=$figli->item(1);
                        $figlioAltrimenti=$figli->item(2);
                        if($figlioCondizione->nodeName=="condizione"){
                            if(valutaCondizione($figlioCondizione)){
                                return eseguiCodice($figlioVera->childNodes); 
                            }else{
                                return eseguiCodice($figlioAltrimenti->childNodes);
                            }
                        }else{
                           
                            return 1;
                        }
                    }else{
                        return 1;
                    }
            break;

            case "vera":
                return eseguiCodice($figli);
            break;

            case "altrimenti":
                return eseguiCodice($figli);
            break;

            case "bloccoIstruzioni":
                return eseguiCodice($figli);
            break;

            case "chiamaFunzione":
                $nomeFunzione=$nodoDaValutare->getAttribute("nome");
                if($figli->length>0){
                    $fileDaIncludere=$nomeFunzione.".php";
                    for($j=0;$j<$figli->length;$j++){
                        
                        $_SESSION["var".$j]=$figli->item($j)->nodeValue;
                        
                    }
                   
                    include_once "./funzioni_base/".$fileDaIncludere;
                }else{
                    include_once "./funzioni_base/".$fileDaIncludere;
                }

            break;

            default:
                return 0;
            
        }
            
        
    }

    function valutaCondizione($nodoCondizione){
        $figliCondizioni=$nodoCondizione->childNodes;
        
        for($k=0;$k<$figliCondizioni->length;$k++){
            if($figliCondizioni->item($k)->nodeName=="operatore"){
                $nodoFiglioCond=$figliCondizioni->item($k);
                if(($nodoFiglioCond->previousSibling->nodeName=="condizione")&&($nodoFiglioCond->nexSibling->nodeName=="condizione")){
                    if($nodoFiglioCond->nodeValue=="and"){
                        return (valutaCondizione($nodoFiglioCond->previousSibling)&&valutaCondizione($nodoFiglioCond->nexSibling));
                    }else if($nodoFiglioCond->nodeValue=="or"){
                        return (valutaCondizione($nodoFiglioCond->previousSibling)||valutaCondizione($nodoFiglioCond->nexSibling));
                    }else{
                        return false;
                    }
                }else if(($nodoFiglioCond->previousSibling==NULL)&&($nodoFiglioCond->nextSibling->nodeName=="condizione")&&($nodoFiglioCond->nodeValue=="not")){
                    return !(valutaCondizione($nodoFiglioCond->nextSibling));
                }else if(($nodoFiglioCond->previousSibling->nodeName=="termine1")&&($nodoFiglioCond->nextSibling->nodeName=="termine2")){
                    $valore1="";
                   $valore2="";
                    if(isset($_SESSION[$nodoFiglioCond->previousSibling->nodeValue])){
                        $valore1=$_SESSION[$nodoFiglioCond->previousSibling->nodeValue];
                    }else{
                        $valore1=$nodoFiglioCond->previousSibling->nodeValue;
                    }
                    if(isset($_SESSION[$nodoFiglioCond->nextSibling->nodeValue])){
                        $valore2=$_SESSION[$nodoFiglioCond->nextSibling->nodeValue];
                    }else{
                        $valore2=$nodoFiglioCond->nextSibling->nodeValue;
                       
                    }
                    switch($nodoFiglioCond->nodeValue){
                        case "=":
                            return ($valore1==$valore2);
                        break;

                        case ">=":
                            return ($valore1>=$valore2);
                        break;

                        case "<=":
                            return ($valore1<=$valore2);
                        break;

                        case ">":
                            return ($valore1>$valore2);
                        break;

                        case "<":
                            return ($valore1<$valore2);
                        break;
                        default:
                            return false;
                    }
                }

            }
            else if($figliCondizioni->item($k)->nodeName=="condizione"){
              return valutaCondizione($figliCondizioni->item($k));
            }
        }
        return true;
    }
?>