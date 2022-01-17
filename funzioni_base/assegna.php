<?php

function rand_float($min, $max, $decimals = 0) {
    $scale = pow(10, $decimals);
    return mt_rand($min * $scale, $max * $scale) / $scale;
    }
     
function assegna(){

    if(isset($_SESSION["var0"])&&isset($_SESSION["var1"])){

        $fileStatoObj=$_SESSION["fileStatoOggetto"];
        $fileVariabiliObj=$_SESSION["fileVariabiliOggetto"];
        $nomeVariabile=$_SESSION["var0"];

        $tipoVariabile="";
       
        $xmlString = "";
        foreach ( file($fileVariabiliObj) as $node ) {
            $xmlString .= trim($node);
        }
        $doc1=new DOMDocument();
        $doc1->loadXMl($xmlString);
        $root=$doc1->documentElement;
        $elementi=$root->childNodes;
        for($i=0;$i<$elementi->length;$i++){
            if($nomeVariabile==$elementi->item($i)->getAttribute("nome")){
                if($elementi->item($i)->hasAttribute("valoreMax")){
                    $tipoVariabile="numerica";
                }else{
                    $tipoVariabile="letterale";
                }
            break;
            }
        }

        if($tipoVariabile=="numerica"){

        $p=rand_float(0,1,1);
        $i=mt_rand(0,1);
        $probBer=pow($p,$i)*pow((1-$p),(1-$i));
        if($probBer>=0.5){

            $nuovoNumero=$_SESSION["var1"];
            for($i=0;$i<$_SESSION["numeroVariabili"];$i++){
                $nuovoNumero=str_replace($_SESSION["arrayNomiVariabili"][$i],$_SESSION[$_SESSION["arrayNomiVariabili"][$i]],$nuovoNumero);
            }
            try{
                eval("\$nuovoNumero=".$nuovoNumero.";");
    
            }catch(Exception $e){
                echo "c'&egrave; stato un errore";
                return 1;
            }
            
            

            $doc1=new DOMDocument();
            $xmlString = "";
                foreach ( file($_SESSION["fileStatoOggetto"]) as $node ) {
                    $xmlString .= trim($node);
                }
            $doc1->loadXMl($xmlString);
            $root=$doc1->documentElement;
            $ultimoNodo=$root->lastChild;
            $varOsservate=$ultimoNodo->childNodes;

            $nuovoStato=$doc1->createElement("stato");
            $nuovoStato->setAttribute("timestamp",date("j-n-Y")."-".date("H-i-s"));

            for($i=0;$i<$varOsservate->length;$i++){
                
                if($varOsservate->item($i)->getAttribute("nome")==$_SESSION["var0"]){

                    $nuovaVar=$doc1->createElement("varOsservata");
                    $nuovaVar=$doc1->createElement("varOsservata");
                    $nuovaVar->setAttribute("nome",$varOsservate->item($i)->getAttribute("nome"));

                    $nuovoVal=$doc1->createElement("valore");
                    $nuovoVal->nodeValue=$nuovoNumero;
                    $nuovaVar->appendChild($nuovoVal);

                    $nuovoStato->appendChild($nuovaVar);
                    $root->appendChild($nuovoStato);
                    $doc1->save($_SESSION["fileStatoOggetto"]);
                }else{

                    $nuovaVar=$doc1->createElement("varOsservata");
                    $nuovaVar->setAttribute("nome",$varOsservate->item($i)->getAttribute("nome"));

                    $nuovoVal=$doc1->createElement("valore");
                    $nuovoVal->nodeValue=$varOsservate->item($i)->childNodes->item(0)->nodeValue;
                    $nuovaVar->appendChild($nuovoVal);

                    $nuovoStato->appendChild($nuovaVar);
                    $root->appendChild($nuovoStato);
                    $doc1->save($_SESSION["fileStatoOggetto"]);
                }
                $_SESSION[$_SESSION["var0"]]=$nuovoNumero;
            }
        }else{

            $doc1=new DOMDocument();
            $xmlString = "";
                foreach ( file($_SESSION["fileStatoOggetto"]) as $node ) {
                    $xmlString .= trim($node);
                }
            $doc1->loadXMl($xmlString);
            $root=$doc1->documentElement;
            $ultimoNodo=$root->lastChild;
            $varOsservate=$ultimoNodo->childNodes;

            $nodoNuovo=$ultimoNodo->cloneNode(true);   
            $nodoNuovo->setAttribute("timestamp",date("j-n-Y")."-".date("H-i-s"));
            $root->appendChild($nodoNuovo);
            $doc1->save($_SESSION["fileStatoOggetto"]);
            echo "<p><h4 style=\"color:black;\">";
            echo "Non ho potuto assegnare il valore a ".$_SESSION["var0"].", la prob era ".$probBer;
            echo "</h4></p>";
        }
        }else if($tipoVariabile=="letterale"){

        $probabilitaEvento=rand(0,100);
        $soglia=rand(51,100);
        if($probabilitaEvento>=$soglia){
            
            
            $doc1=new DOMDocument();
            $xmlString = "";
                foreach ( file($_SESSION["fileStatoOggetto"]) as $node ) {
                    $xmlString .= trim($node);
                }
            $doc1->loadXMl($xmlString);
            $root=$doc1->documentElement;
            $ultimoNodo=$root->lastChild;
            $varOsservate=$ultimoNodo->childNodes;

            $nuovoStato=$doc1->createElement("stato");
            $nuovoStato->setAttribute("timestamp",date("j-n-Y")."-".date("H-i-s"));

            for($i=0;$i<$varOsservate->length;$i++){
                
                if($varOsservate->item($i)->getAttribute("nome")==$_SESSION["var0"]){

                    $nuovaVar=$doc1->createElement("varOsservata");
                    $nuovaVar=$doc1->createElement("varOsservata");
                    $nuovaVar->setAttribute("nome",$varOsservate->item($i)->getAttribute("nome"));

                    $nuovoVal=$doc1->createElement("valore");
                    $nuovoVal->nodeValue=$_SESSION["var1"];
                    $nuovaVar->appendChild($nuovoVal);

                    $nuovoStato->appendChild($nuovaVar);
                    $root->appendChild($nuovoStato);
                    $doc1->save($_SESSION["fileStatoOggetto"]);
                }else{

                    $nuovaVar=$doc1->createElement("varOsservata");
                    $nuovaVar->setAttribute("nome",$varOsservate->item($i)->getAttribute("nome"));

                    $nuovoVal=$doc1->createElement("valore");
                    $nuovoVal->nodeValue=$varOsservate->item($i)->childNodes->item(0)->nodeValue;
                    $nuovaVar->appendChild($nuovoVal);

                    $nuovoStato->appendChild($nuovaVar);
                    $root->appendChild($nuovoStato);
                    $doc1->save($_SESSION["fileStatoOggetto"]);
                }
            }

            $_SESSION[$_SESSION["var0"]]=$_SESSION["var1"];
            
        }else{

            $doc1=new DOMDocument();
            $xmlString = "";
            foreach ( file($_SESSION["fileStatoOggetto"]) as $node ) {
                $xmlString .= trim($node);
            }
            $doc1->loadXMl($xmlString);
            $root=$doc1->documentElement;
            $ultimoNodo=$root->lastChild;
            $varOsservate=$ultimoNodo->childNodes;

            $nodoNuovo=$ultimoNodo->cloneNode(true);   
            $nodoNuovo->setAttribute("timestamp",date("j-n-Y")."-".date("H-i-s"));
            $root->appendChild($nodoNuovo);
            $doc1->save($_SESSION["fileStatoOggetto"]);
            echo "<p><h4 style=\"color:black;\">";
            echo "Non ho potuto assegnare il valore a".$_SESSION["var0"].", la prob era ".$probBer;
            echo "</h4></p>";
        }
        }

       
        return 0;
    }else{
        return 1;
    }
}
        return assegna();
?>