<?php
session_start();
if(isset($_SESSION["LOGUS"])){
    if($_SESSION["LOGUS"]==0){
        header("Location:home_access.php");
    }
}else{
    $_SESSION["LOGUS"]=0;
    header("Location:home_access.php");
}
$_SESSION["fileVariabiliOggetto"]="xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_variables.xml";
?>
<!DOCTYPE html>
<html lang="en">
<title><?php echo $_GET["oggetto"]; ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">  
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-safety.css">

<link rel="stylesheet" type="text/css" href="objN.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script  src="script/funzioni.js" type="text/javascript"></script>
<style>
  * {
    box-sizing:border-box;
  }

  body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
  .w3-bar,h1,button {font-family: "Montserrat", sans-serif}
  .fa-anchor,.fa-coffee {font-size:200px}
  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
  }


  li {
    float: left;
  }

  .topnav {
    overflow: hidden;
    background-color: #333;
  }

  .topnav a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
  }

  .active {
    background-color: #4CAF50;
    color: white;
  }

  .topnav .icon {
    display: none;
  }

  .dropdown {
    float: left;
    overflow: hidden;
  }

  .dropdown .dropbtn {
    font-size: 17px;    
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }

  .dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
  }

  .topnav a:hover, .dropdown:hover .dropbtn {
    background-color: #555;
    color: white;
  }

  .dropdown-content a:hover {
    background-color: #ddd;
    color: black;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }
  .col-1 {width: 8.33%;}
  .col-2 {width: 16.66%;}
  .col-3 {width: 25%;}
  .col-4 {width: 33.33%;}
  .col-5 {width: 41.66%;}
  .col-6 {width: 50%;}
 .riquadroComandi{
  margin-top:1%;
  margin-left:2%;
  float:left;
  padding:3%;
 }
  @media only screen and (max-width: 600px) {
    [class*="col-"] {
  width: 100%;
  margin-right:2%;
 }
  
    .topnav a:not(:first-child), .dropdown .dropbtn {
      display: none;
    }
    .topnav a.icon {
      float: right;
      display: block;
    }

    .topnav.responsive {position: relative;}
    .topnav.responsive .icon {
      position: absolute;
      right: 0;
      top: 0;
    }
    .topnav.responsive a {
      float: none;
      display: block;
      text-align: left;
    }
    .topnav.responsive .dropdown {float: none;}
    .topnav.responsive .dropdown-content {position: relative;}
    .topnav.responsive .dropdown .dropbtn {
      display: block;
      width: 100%;
      text-align: left;
    }
  }
  .barra{
    position: relative;
    overflow: hidden;
  }

  .barra span{
    
  
    display:block;
    height: 100%;
  }

  .progress{
    animation-name: carica;
    animation-duration:3s;
  }

  @keyframes carica{
    from{ width:0; }
    to{width:100%;}
  }

</style>
 <?php echo "<body onload=checkComandi(\"".$_GET["oggetto"]."\",\"".$_GET["stanza"]."\") >";
?> 

<div class="w3-top">
  <div class="w3-bar w3-highway-blue w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-highway-blue" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="indexUtente.php" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>

    <a href="logout.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Logout</a>
  </div>

  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
  
    <a href="logout.php" class="w3-bar-item w3-button w3-padding-large">Logout</a>
  </div>
</div>

<header class="w3-container w3-highway-blue w3-center" style="padding:80px 16px">
  <h1 class="w3-margin w3-jumbo"> Controllo: <?php echo $_GET["oggetto"];?> !
               </h1>
 </header>

<div class="w3-row-padding  w3-padding-64 w3-safety-red ">
    <div class="riquadroComandi col-5" style="background-color:white; ">
        <p><h2 style="color:black;">Ecco lo stato attuale:</h2></p>
        <div  style="padding:3%;  overflow:scroll; height:200px; color:black;">
          <?php
              $xmlString = "";
              foreach ( file("xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_variables.xml") as $node ) {
                  $xmlString .= trim($node);
              }
              $doc=new DOMDocument();
              $doc->loadXMl($xmlString);
              $root=$doc->documentElement;
              $elementi=$root->childNodes;

              $ind=0;
              for($i=0;$i<$elementi->length;$i++){
                  if($elementi->item($i)->getAttribute("valoreMax")!=NULL){
                      $variabiliNumeriche[$ind]["nome"]=$elementi->item($i)->getAttribute("nome");
                      $variabiliNumeriche[$ind]["max"]=$elementi->item($i)->getAttribute("valoreMax");
                      $variabiliNumeriche[$ind]["min"]=$elementi->item($i)->getAttribute("valoreMin");
                      $variabiliNumeriche[$ind]["misura"]=$elementi->item($i)->firstChild->nodeValue;
                      $ind++;
                  }
              }

              $xmlString = "";
              foreach ( file("xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_status.xml") as $node ) {
                  $xmlString .= trim($node);
              }
              $doc=new DOMDocument();
              $doc->loadXMl($xmlString);
              $root=$doc->documentElement;
              $elemento=$root->lastChild;
              if($elemento!=NULL){

                $timeStamp=$elemento->getAttribute("timestamp");
                $variabili=$elemento->childNodes;
                echo $timeStamp."<br />";
                for($i=0;$i<$variabili->length;$i++){
                    $trovato=0;
                    for($k=0;$k<$ind;$k++){   
                        if($variabili->item($i)->getAttribute("nome")==$variabiliNumeriche[$k]["nome"]){
                            $trovato=1;

                            echo  "<span >".$variabili->item($i)->getAttribute("nome")."</span>";
                            echo  "<div class=\"barra\">";
                          
                            $valoreBarra=$variabili->item($i)->firstChild->nodeValue/sqrt((pow($variabiliNumeriche[$k]["max"],2)-pow($variabiliNumeriche[$k]["min"],2)))*100;
                            echo "<span  style=\"width:".$valoreBarra."%;\"><span class=\"w3-round w3-blue progress\"><span style=\"color:black;\">".$variabili->item($i)->firstChild->nodeValue."".$variabiliNumeriche[$k]["misura"]."</span></span></span>";
                          
                            echo "</div><br/>"; 
                            
                        break;
                        }
                    }
                    if($trovato==0){
                        echo  "<span >".$variabili->item($i)->getAttribute("nome")."</span>";
                        echo  "<div class=\"w3-light-grey w3-round\">";
                        echo "<div class=\"w3-container w3-round w3-blue\"><span style=\"color:black\">".$variabili->item($i)->firstChild->nodeValue."</span></div>";
                        
                        echo "</div><br/>";
                      
                    }
                } 
              }
          ?>
        </div>
    </div>
   
          <?php
            if($_SESSION["livello_utente"]>=2){
              echo "<div class=\"riquadroComandi col-3\" style=\" background-color:white;  color:black;\">";
              echo "<p><h3>Lista Comandi Eseguibili:</h3></p>";
              echo "<div style=\" height:170px; overflow:scroll;\">";
              $xmlString = "";
              foreach ( file("xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_commands.xml") as $node ) {
                  $xmlString .= trim($node);
              }
              $doc1=new DOMDocument();
              $doc1->loadXMl($xmlString);
              $root=$doc1->documentElement;
              $elementi=$root->childNodes;
              $arrayComandi=array();
              for($i=0;$i<$elementi->length;$i++){
                $nodoComando=$elementi->item($i);
                $arrayComandi[$i]["livello"]=$nodoComando->childNodes->item(0)->nodeValue;
                $arrayComandi[$i]["nome"]=$nodoComando->childNodes->item(1)->nodeValue;
                $arrayComandi[$i]["fileCodice"]=$nodoComando->childNodes->item(2)->nodeValue;
               
              }
              for($k=0;$k<count($arrayComandi);$k++){
                if($_SESSION["livello_utente"]>=$arrayComandi[$k]["livello"]){
                  echo "<div style=\"margin:3%;\">";
                    echo "<a style=\"display:block;\"class=\"w3-button w3-padding-large w3-blue-grey\" onclick=eseguiCodice(\"path=xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$arrayComandi[$k]["fileCodice"]."&fileStato="."xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_status.xml\")>";
                    echo $arrayComandi[$k]["nome"];
                    echo "</a>";
                  echo "</div>";
                }
            }
            }
            echo " </div>";
            echo "</div>";
          ?>
   
   
          <?php
            if($_SESSION["livello_utente"]>=3){
              echo "<div class=\"riquadroComandi col-3\" style=\" padding-bottom:4%; background-color:white;  color:black;\">";
              echo "<p><h3>Aggiungi una Variabile:</h3></p>";

                
               echo  "<div class=\"w3-left\" >"; 
              echo  "<form method=\"POST\" action=\"aggiungiVariabile.php?\" id=\"login-form\" class=\"login-form\" >";
              echo "<div>";
              echo "<label class=\"label text\">";
              echo "<input type=\"text\" class=\"text\" name=\"nomeVariabile\"  placeholder=\"nome variabile\" tabindex=\"1\" />";
              echo "<span>Nome Variabile</span>";
              echo "</label>";

              echo "<div>";
              echo "<label class=\"text\">";
              echo "<span>Valore Variabile</span>";
              echo "</label>";
              echo "<input type=\"text\"  name=\"stanza\"  value=\"".$_GET["stanza"]."\" style=\"display:none;\" />";
              echo "<input type=\"text\"  name=\"oggetto\"  value=\"".$_GET["oggetto"]."\" style=\"display:none;\" />";
              echo "<input type=\"text\" id=\"numMaxValori\" name=\"numMaxValori\"  value=\"1\" style=\"display:none;\" />";
            
              echo "<input type=\"radio\" id=\"number\" name=\"tipoVal\" onclick=aggiungiPezzo(\"numero\") value=\"Numerico\" tabindex=\"2\" />";
              echo "<label class=\"radio\" for=\"number\"><span>Numerico</span></label><br/>";
            
             
              echo "<input type=\"radio\" id=\"letter\"  name=\"tipoVal\" value=\"Letterale\" onclick=aggiungiPezzo(\"parole\") tabindex=\"3\" />";
              echo "<label class=\"radio\" for=\"letter\"><span>Letterale</span></label><br/>";
              echo "</div>";
              echo "<div id=\"contenutoValori\"></div>";
              echo "</div>";
              echo  "<input type=\"submit\" value=\"Aggiungi Variabile\" />";
              echo "</form>";
              echo "</div>";
              
            }
            echo "</div>";
          ?>
    
   
          <?php
            if($_SESSION["livello_utente"]>=3){
              echo "<div class=\"riquadroComandi\" style=\"padding:3%; margin-left:5%; background-color:white; float:left; color:black;\">";
              echo "<p><h3>Elimina una Variabile:</h3></p>";
                
               echo  "<div class=\"w3-left\">"; 
              echo  "<form method=\"POST\" action=\"eliminaVariabile.php?\" id=\"login-form\" class=\"login-form\" >";
              echo "<div>";
              echo "<label class=\"label text\">";
              echo "<span>Nome Variabile</span>"; 
              echo "<select class=\"text\" name=\"nomeVariabile\"  placeholder=\"nome variabile\" tabindex=\"1\" />";
             
              $xmlString = "";
              foreach ( file("xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_variables.xml") as $node ) {
                   $xmlString .= trim($node);
              }
              $doc=new DOMDocument();
              $doc->loadXMl($xmlString);
              $root=$doc->documentElement;
              $elementi=$root->childNodes;
              
              for($i=0;$i<$elementi->length;$i++){
                echo "<option value=\"".$elementi->item($i)->getAttribute("nome")."\">";
                echo $elementi->item($i)->getAttribute("nome");
                echo "</option>";
              }
              echo "</select>";
             
              echo "</label>";
              echo "<input type=\"text\"  name=\"stanza\"  value=\"".$_GET["stanza"]."\" style=\"display:none;\" />";
              echo "<input type=\"text\"  name=\"oggetto\"  value=\"".$_GET["oggetto"]."\" style=\"display:none;\" />";
            
              echo "</div>";
              echo  "<input type=\"submit\" value=\"Elimina Variabile\" />";
              echo "</form>";
              echo "</div>";
              
            }
            echo "</div>";
          ?>
   
    
          <?php
            if($_SESSION["livello_utente"]>=3){
              echo "<div class=\"riquadroComandi\" style=\"padding:3%;  margin-left:5%; background-color:white; float:left; color:black;\">";
              echo "<p><h3>Modifica una Variabile:</h3></p>";
                
               echo  "<div class=\"w3-left\">"; 
              echo "<div>";
              echo "<label class=\"label text\">";
              echo "<span>Seleziona Variabile</span>"; 
              echo "<select class=\"text\" name=\"nomeVariabile\"  placeholder=\"nome variabile\" tabindex=\"1\" />";
             
              $xmlString = "";
              foreach ( file("xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_variables.xml") as $node ) {
                   $xmlString .= trim($node);
              }
              $doc=new DOMDocument();
              $doc->loadXMl($xmlString);
              $root=$doc->documentElement;
              $elementi=$root->childNodes;
              
              for($i=0;$i<$elementi->length;$i++){

                echo "<option onclick=modificaAspetto(\"".$elementi->item($i)->getAttribute("nome")."\",\"xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_variables.xml\") value=\"".$elementi->item($i)->getAttribute("nome")."\">";
                echo $elementi->item($i)->getAttribute("nome");
                echo "</option>";
              }
              echo "</select>";
             
              echo "</label>";
              echo "<input type=\"text\"  name=\"stanza\"  value=\"".$_GET["stanza"]."\" style=\"display:none;\" />";
              echo "<input type=\"text\"  name=\"oggetto\"  value=\"".$_GET["oggetto"]."\" style=\"display:none;\" />";
            echo "<div id=\"contenitoreModifiche\" >";
            
            echo "</div >";
              echo "</div>";
              
              echo "</div>";
              
            }
            echo "</div>";
          ?>
    
    
          <?php
            if($_SESSION["livello_utente"]>=2){
              echo "<div class=\"riquadroComandi\" style=\"padding:3%; margin-left:5%; background-color:white; float:left; color:black;\">";
              echo "<p><h3>Programma esecuzione comando :</h3></p>";
               
               echo  "<div class=\"w3-left\">"; 
              echo  "<form method=\"POST\" action=\"aggiungiMemo.php?\" id=\"login-form\" class=\"login-form\" >";
              
              echo "<label class=\"label text\">";
              echo "<span>Seleziona Comando</span>"; 
              echo "<select class=\"text\" name=\"nomeComando\"  placeholder=\"nome variabile\" tabindex=\"1\" />";
              
              $xmlString = "";
              foreach ( file("xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_commands.xml") as $node ) {
                   $xmlString .= trim($node);
              }
              $doc=new DOMDocument();
              $doc->loadXMl($xmlString);
              $root=$doc->documentElement;
              $elementi=$root->childNodes;
              
              for($i=0;$i<$elementi->length;$i++){
                if($elementi->item($i)->childNodes->item(0)->nodeValue<=$_SESSION["livello_utente"]){
                  
                echo "<option  value=\"".$elementi->item($i)->childNodes->item(1)->nodeValue."\">";
                echo $elementi->item($i)->childNodes->item(1)->nodeValue;
                echo "</option>";
                }
              }
              echo "</select>";
              echo "</label>";
              
              echo "<label class=\"label text\">";
              echo "<input type=\"date\" class=\"text\" name=\"data\" tabindex=\"2\" />";
              echo "<input type=\"time\" class=\"text\" name=\"ora\" tabindex=\"2\" />";
              echo "<span>Giorno e Ora</span>";
              echo "</label>";
              echo "<input type=\"text\"  name=\"stanza\"  value=\"".$_GET["stanza"]."\" style=\"display:none;\" />";
              echo "<input type=\"text\"  name=\"oggetto\"  value=\"".$_GET["oggetto"]."\" style=\"display:none;\" />";
              
              echo  "<input type=\"submit\" value=\"Aggiungi Memo \" />";
              echo "</form>";
              if(isset($_SESSION["erroreMemo"])){
                echo $_SESSION["erroreMemo"];
                unset($_SESSION["erroreMemo"]);
              }
              echo "</div> ";
              
            }
            echo  "</div>";
          ?>
   
   
          <?php
            if($_SESSION["livello_utente"]>=2){
              echo "<div  class=\"riquadroComandi\" style=\"padding:3%;  margin-left:5%; background-color:white; float:left; color:black;\">";
              echo "<p><h3>Lista comandi programmati:</h3></p>";
                
                echo  "<form method=\"POST\"  id=\"login-form\" class=\"login-form\" >";
               echo  "<div id=\"listaPromemoria\" style=\"overflow:scroll; height:200px;\" class=\"w3-left\">"; 
             
              echo "</div>";
              echo "</form>";
            }
            echo "</div>";
          ?>
    
</div>
<div class="w3-row-padding  w3-padding-64 w3-safety-red ">

 <?php
    if($_SESSION["livello_utente"]>=2){
      echo "<div style=\" margin-bottom:3%; padding:3%; margin-top:2%;  background-color:white;\">";

     echo "<span><h2 style=\"color:black; display:inline;\">Messaggio da ".$_GET["oggetto"].":</h2></span>";
     echo "<div  id=\"contenitoreRisposta\"></div>";
      
      echo "</div><br/><br />";
    }

    if($_SESSION["livello_utente"]>=3){
     
    echo  "<br/><div style=\" padding:3%; background-color:white;\">";
     echo  "<p><h2 style=\"color:black; text-align:center;\">Mini IDE per scrivere il codice dei comandi</h2></p>";
     echo "<div style=\"margin:1.5%; border-style:groove; border-width:3px; border-color:black;\">";
      

     echo "<div class=\"topnav\" id=\"myTopnav\">";

  echo "<a href=\"#myTopnav\" onclick=eseguiCodiceIDE(\"fileStato="."xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_status.xml\") class=\"active\">Esegui</a>";
  echo "<a href=\"#myTopnav\" onclick=salvaCodice(\"xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_commands.xml\",\"xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/comandi/\") >Salva</a>";
  echo "<a href=\"#myTopnav\" onclick=verificaCodice() >Verifica</a>";
 

  echo "<div class=\"dropdown\">";
  echo "<button class=\"dropbtn\">Funzioni di Sistema"; 
  echo "<i class=\"fa fa-caret-down\"></i>";
  echo "</button>";
  echo "<div class=\"dropdown-content\">";
  $directory="funzioni_base";
  if ($handle = opendir("./" . $directory))
  {
    while ($file = readdir($handle))
    {
      if (is_dir("./{$directory}/{$file}"))
      {
        
      }
      else
      {
        echo "<span style=\"color:black;\">".explode(".",$file)[0]."</span><br/>";
      }
    }
  }
  echo "</div>";
  echo "</div>"; 

  echo "<div class=\"dropdown\">";
  echo "<button class=\"dropbtn\">Lista Comandi"; 
  echo "<i class=\"fa fa-caret-down\"></i>";
  echo "</button>";

  echo "<div class=\"dropdown-content\">";
  $xmlString = "";
  foreach ( file("xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_commands.xml") as $node ) {
      $xmlString .= trim($node);
  }
  $doc1=new DOMDocument();
  $doc1->loadXMl($xmlString);
  $root=$doc1->documentElement;
  $elementi=$root->childNodes;

  for($i=0;$i<$elementi->length;$i++){
    $pathFile="xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/comandi/".$elementi->item($i)->childNodes->item(1)->nodeValue.".xml";
    $pathCom="xml/".$_GET["stanza"]."/".$_GET["oggetto"]."/".$_GET["oggetto"]."_commands.xml";
    $livelloComando=$elementi->item($i)->childNodes->item(0)->nodeValue;
    $nomeComando=$elementi->item($i)->childNodes->item(1)->nodeValue;
    
    echo  "<a id=\"".$nomeComando."\" onclick=riempiCodice(\"".$pathFile."\",\"".$pathCom."\",\"".$nomeComando."\",".$livelloComando.")>".$elementi->item($i)->childNodes->item(1)->nodeValue."</a>"; 
    
  }
  
  
  echo "</div>";
  echo "</div>"; 

  echo "<a href=\"javascript:void(0);\" style=\"font-size:15px;\" class=\"icon\" onclick=\"myFunction2()\">&#9776;</a>";
  echo "</div>";
      
  echo "<div id=\"areaInfo\" class=\"w3-blue-gray\">";
  echo "<input style=\"margin:2.23%;\" type=\"text\" id=\"nomeFile\" name=\"nomeFile\" placeholder=\"nome del comando\">";
  echo "<input style=\"margin:2.23%;\" type=\"number\" min=\"1\" max=\"".$_SESSION["livello_utente"]."\" id=\"livCom\" name=\"livCom\" placeholder=\"livello del comando\">";
  echo "<button style=\"background-color:red;\" id=\"pulsanteElimina\" >ELIMINA</button>";
   
  echo "</div>";
  echo "<textarea id=\"areaTestoCodice\" rows=\"20\" style=\"z-index:-1; width:100%;\">";
  echo " <?xml version=\"1.0\" encoding=\"UTF-8\"?> 
    <codice xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../../grammatica.xsd\"> \n  <listaVariabili> \n  </listaVariabili> \n  </codice>";
    echo "</textarea>";
      echo  "</div>";
      echo  "</div>";
      }
  ?>
  
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Developed by: RobCo Ind.</h1>
</div>


<script>
function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}

function myFunction1() {
  var x = document.getElementById("navDev");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}

function myFunction2() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>

</body>
</html>