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
<title><?php echo $_GET["stanza"]; ?></title>
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
    <a href="indexUtente.php" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>

    <a href="logout.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Logout</a>
  </div>

 
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
  
    <a href="logout.php" class="w3-bar-item w3-button w3-padding-large">Logout</a>
  </div>
</div>

<header class="w3-container w3-highway-blue w3-center" style="padding:128px 16px">
  <h1 class="w3-margin w3-jumbo">Sei in : <?php echo $_GET["stanza"];?> !
               </h1>
 </header>

<div class="w3-row-padding  w3-padding-64 w3-safety-red ">
    <p><h2 style="color:white;">Ecco gli oggetti presenti:</h2></p>
    <div style="padding:3%;">
        <?php
          include_once "database.php";
          $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);

          if (mysqli_connect_errno($conn)) {
              echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
              exit();
          }

          $queryOggetti="select * from oggetti,luoghi where((luoghi.nome_luogo='".$_GET["stanza"]."')AND(luoghi.id=oggetti.id_luogo));";
          $i=0;
          $cont=0;
          $result=$conn->query($queryOggetti);
          if($result->num_rows > 0){ 
            while($row=$result->fetch_assoc()){
                $arrayOggetti[$i]["0"]=$row["nome"];
                $arrayOggetti[$i]["1"]=$row["id"];
                $cont=$cont+1;
                $i=$i+1;
            }
          }
          $conn->close();
          for($j=0;$j<$cont;$j++){
            echo "<div style=\"float:left; padding:3%;\">";
              echo "<a class=\"w3-button w3-padding-large w3-teal\" href=\"paginaOggetto.php?oggetto=".$arrayOggetti[$j]["0"]."&stanza=".$_GET["stanza"]."\">".strtoupper($arrayOggetti[$j]["0"])."</a>";
            echo "</div>";
          }

        ?>
    </div>
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
