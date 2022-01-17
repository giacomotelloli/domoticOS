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
<title>Interfaccia Utente</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">  
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-safety.css">
<link rel="stylesheet" type="text/css" href="userN.css" />
<script  src="script/funzioni.js" type="text/javascript"></script>
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}
</style>
<body>

<div class="w3-top">
  <div class="w3-bar w3-highway-blue w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-highway-blue" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="#" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>
    
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

<header class="w3-container w3-highway-blue w3-center" style="padding:128px 16px">
  <h1 class="w3-margin w3-jumbo">Che piacere rivederti <?php echo $_SESSION["nome"]?> !
               </h1>
 </header>

<div class="w3-row-padding w3-center w3-padding-64 w3-safety-red ">
  
    <div class="w3-left"> 
    <form method="POST" action="updateUserVal.php" id="login-form" class="login-form" >
      
        <div>
          <label class="label">
            <input type="text" class="text" name="nomeUtente" value="<?php echo $_SESSION["nome"];?>" placeholder="nome" tabindex="1" />
            <span>Nome</span>
          </label>
        </div>
        
        <div>
          <label class="label">
            <input type="text" class="text" name="cognomeUtente" value="<?php echo $_SESSION["cognome"]; ?>" placeholder="cognome" tabindex="2" />
            <span >Cognome</span>
          </label>
        </div>

        <div>
          <label class="label">
            <input type="text" class="text" name="emailUtente" value="<?php echo $_SESSION["email"]; ?>" placeholder="email" tabindex="3" />
            <span >Email</span>
          </label>
        </div>

        <div>
          <label class="label">
            <input type="text" class="text" name="livello" value="<?php 
                  
                    if($_SESSION["livello_utente"]==1){
                      echo "utente registrato";
                    } else if($_SESSION["livello_utente"]==2){
                      echo "utente utilizzatore";
                    }else if($_SESSION["livello_utente"]==3){
                      echo "utente gestore";
                    }else if ($_SESSION["livello_utente"]==4){
                      echo "utente amministratore";
                    }
            
            ?>"placeholder="livello" tabindex="4" readonly />
            <span >Livello</span>
          </label>
        </div>
      
        <input type="submit" value="Aggiorna Dati" />
       
       
      </form>
  
    </div>
    <div id="listaStanze" class="w3-left pan_risposte" >
        <div>
          <h3>Qui saranno visualizzate le stanze di un piano selezionato</h3>
        </div>
    </div>
</div>

<?php
    if($_SESSION["livello_utente"]>=3){
      echo "<div class=\"w3-row-padding w3-light-grey w3-padding-64 w3-container\">";
        echo "<div class=\"w3-content\">";
          echo "<div class=\"w3-twothird\">";
          echo "<h1>Vedo che sei un tipo importante</h1>";
          echo "<p class=\"w3-text-grey\"><h5 class=\"w3-padding-32\" >Forse gi&agrave; lo sai ma te lo ripeto nuovamente<br /> Se clicchi sul pulsante qui sotto puoi accedere all'esclusiva area di controllo </h5></p>";
          echo "</div>";
          echo "<div class=\"w3-twothird\">";
            echo "<a href=adminUtente.php class=\"w3-button w3-xlarge w3-black\">Admin Area</a>";
          echo "</div>";
          
        echo "</div>";
      echo "</div>";
    }
?>

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
