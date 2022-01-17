<?php
   
    session_start();
     $livello=$_SESSION["livello_utente"];
    $idUtente=$_SESSION["id"];
    $comando=$_GET["comando"];
    $_SESSION["comandoDaPassare"]="";
    $arrayParole=explode(' ',$comando);
    $dimensioneArray=count($arrayParole);
    $verbo=$arrayParole[0];
    $oggetto="";
    $luogo="";
    $tempo="";
    $comandoHalTrovato=0;
    $contTagInfoGenerati=0;
    header("Content-type:text/xml");
   
   echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
  echo " <messaggi xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"mex.xsd\"> ";
  
   foreach ( file("hal_commands.xml") as $node ) {
        $xmlString .= trim($node);
   }
   $doc=new DOMDocument();
   $doc->loadXMl($xmlString);
   $root=$doc->documentElement;
   $elementi=$root->childNodes;

   for($i=0;$i<$elementi->length;$i++){
    $elemento=$elementi->item($i);
    $livCom=$elemento->childNodes->item(0)->textContent;
    
    if($livCom<=$livello){
       
        $parametri=$elemento->childNodes;
        $com=$parametri->item(1)->textContent;
       
        $fileDaChiamare=$parametri->item(2)->textContent;
        if($com==$arrayParole[0]){
            $comandoHalTrovato=1;
                if($dimensioneArray > 1){
                    $_SESSION["comandoDaPassare"]=$comando;
                }
                include_once $fileDaChiamare;

            break;
        }
        
    }
}


if($comandoHalTrovato==0){
    
    if($dimensioneArray==4){
            $oggetto=$arrayParole[1];
            $luogo=$arrayParole[3];

    }else if($dimensioneArray==6){
        $oggetto=$arrayParole[1];
        $luogo=$arrayParole[3];
        $tempo=$arrayParole[5];
    
    }else{
        echo "<messaggio tipoMex=\"errore\"><testo> &lt;span&gt; H.A.L. : La sintassi del comando non è corretta, digita aiuto per iniziare,oppure aiuto (nome_oggetto) per sapere quali comandi,puoi lanciare &lt;br/&gt; &lt;/span&gt; </testo></messaggio>";
    }
}
           
    echo "</messaggi>";

    $file ="xml/macchina/macchina_status.xml";
    
   
?>