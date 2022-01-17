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

?>
<!DOCTYPE html>
<html lang="en">
<title>Interfaccia Amministrazione</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">  
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-safety.css">
<link rel="stylesheet" type="text/css" href="userN.css" />
<link rel="stylesheet" type="text/css" href="user.css" /> 
<script  src="script/funzioni.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}
</style>
<body>

<div class="w3-top">
  <div class="w3-bar w3-highway-blue w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-highway-blue" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="indexUtente.php" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>
  
    <?php
              include_once "database.php";
              $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
              if (mysqli_connect_errno($conn)) {
                  echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
                  exit();
              }
              $queryPiani="select * from piani;";
              $i=0;
              $cont=0;
              $result=$conn->query($queryPiani);
              if($result->num_rows > 0){ 
                while($row=$result->fetch_assoc()){
                    $arrayPiani[$i]["0"]=$row["nome_piano"];
                    $arrayPiani[$i]["1"]=$row["id"];
                    $cont=$cont+1;
                    $i=$i+1;
                }
              }

              
              for($i=0;$i<$cont;$i++){
                  
                  echo "<button onclick=getStanze(\"".$arrayPiani[$i]["0"]."\") class=\"w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white\">".$arrayPiani[$i]["0"]."</button>";
                  
              }
              $conn->close();
          ?>
    
    <a href="logout.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Logout</a>
  </div>

  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
  <?php
  for($i=0;$i<$cont;$i++){
    
    echo "<button onclick=getStanze(\"".$arrayPiani[$i]["0"]."\") class=\"w3-bar-item w3-button w3-padding-large\">".$arrayPiani[$i]["0"]."</button>";
                  
}
  ?>
    <a href="logout.php" class="w3-bar-item w3-button w3-padding-large">Logout</a>
  </div>
</div>


<div class="w3-row-padding  w3-padding-64 w3-safety-red ">
  
    <div class="w3-left">
    <div class="rigaPrompt ">
                    <div class="panelContPrompt">

                            <div class="intestazionePrompt"> H.A.L. 9001 (Home Assistant Language)</div>
                            <div class="conversazione" id="conversazione"><?php if(isset($_SESSION["messaggioRitorno"])){echo $_SESSION["messaggioRitorno"]; unset($_SESSION["messaggioRitorno"]);}?></div>
                            <div class="rigaComandi">
                                    <span style="float:left;">Digita i comandi qui >_</span> 
                                    <input class="testoComando" name="comando" id="comando" type="text"  />
                                    <button style="float:left;" type="submit" onclick="sendCommand()">invia</button>
                                
                            </div> 
                    </div>
    </div>
    </div>
    <div id="listaStanze" class="w3-left pan_risposte" >
        <div>
          <h3>Qui saranno visualizzate le stanze di un piano selezionato</h3>
        </div>
    </div>
</div>

<div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">
      <div id="risultati" class="rigaRisultati"></div>
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
</script>

</body>
</html>
