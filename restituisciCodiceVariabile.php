<?php
    $nomeVariabile=$_POST["nomeVariabile"];
    $pathXml=$_POST["pathXml"];

    $xmlString = "";
    foreach ( file($pathXml) as $node ) {
        $xmlString .= trim($node);
    }
    $doc=new DOMDocument();
    $doc->loadXMl($xmlString);
    $root=$doc->documentElement;
    $elementi=$root->childNodes;
    for($i=0;$i<$elementi->length;$i++){
        if($elementi->item($i)->getAttribute("nome")==$nomeVariabile){
            $nodoDesignato=$elementi->item($i);
        break;
        }
    }
    if(isset($nodoDesignato)){
        if($nodoDesignato->hasAttribute("valoreMax")){

           
          
             
            

            echo "<label class=\"label text\">";
            echo "<span>Unit&agrave; di misura</span>"; 
            echo "</label>";
            echo "<input type=\"text\" id=\"unitaMisura\" name=\"unitaMisura\" value=\"".$nodoDesignato->childNodes->item(0)->nodeValue."\">";
           

            echo "<label class=\"label text\">";
            echo "<span>Valore Massimo</span>"; 
            echo "</label>";
            echo "<input type=\"number\" id=\"valoreMax\" name=\"valoreMax\" value=\"".$nodoDesignato->getAttribute("valoreMax")."\">";
           
            
            echo "<label class=\"label text\">";
            echo "<span>Valore Minimo</span>"; 
            echo "</label>";
            echo "<input type=\"number\" id=\"valoreMin\" name=\"valoreMin\" value=\"".$nodoDesignato->getAttribute("valoreMin")."\">";
           
            echo "<br/><button onclick=salvaModifiche(\"".$nodoDesignato->getAttribute("nome")."\",\"".$pathXml."\") >Salva Modifiche </button>"; 
            
            
        }else {

           
            echo "<label class=\"label text\">";
            echo "<span>Lista Valori</span>";
            echo "</label>";
            echo "<select id=\"listaValori\" name=\"listaValori\" size=\"".$nodoDesignato->childNodes->length."\">";
                   
                    for($j=0;$j<$nodoDesignato->childNodes->length;$j++){
                        echo "<option>";
                        echo $nodoDesignato->childNodes->item($j)->nodeValue;
                        echo "</option>";
                    }
            echo "</select><br/>";
            
            echo "<button onclick=eliminaValoreVariabile(\"".$nodoDesignato->getAttribute("nome")."\",\"".$pathXml."\") >Elimina selezionato</button>"; 
           
            echo "<br/><br/>";
            echo "<label class=\"label text\">";
            echo "<span>Nuovo Valore</span>"; 
            echo "</label>";
            echo "<input type=\"text\" id=\"testoNuovoNome\" name=\"testoValore\" value=\"\">";
            echo "<button onclick=aggiungiValoreVariabile(\"".$nodoDesignato->getAttribute("nome")."\",\"".$pathXml."\") >Aggiungi Valore </button>"; 
           
            
        }

    }
?>