<?xml version = "1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Home_Access</title>
    <link rel="stylesheet" type="text/css" href="home.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
  session_start();
?>
<body>
<div name="container">
   <div class="panel_enter">
    <div class="session">
      
      <div class="left">
      </div>

      <form class="formLog" action="login_home.php" class="log-in"  method="POST"> 
        <h4><span>Domotic OS</span></h4>
        <p>Entra in casa</p>
        <div class="floating-label">
          <input placeholder="Email" type="text" name="email" id="email" >
          <label for="email">Email</label>
        </div>
        <div class="floating-label">
          <input placeholder="Password" type="password" name="password" id="password" >
          <label for="password">Password:</label>
        </div>
        <button type="submit" >Log in</button>
        <a href="register.php"  >Registrati</a>
        <span><?php 
            if(isset($_SESSION["error"])){
              if($_SESSION["error"]==1){
                echo "H.A.L. :Attenzione valorizza email e password";
                $_SESSION["error"]=0;
              }
              if($_SESSION["error"]==2){
                echo "H.A.L. :Attenzione email o password errati <br /> Temo che non posso farti entrare";
                $_SESSION["error"]=0;
              }
            }
        ?></span>
      </form>
      
    </div>
    </div>
    <div class="panel_show">
      <div class="tooltip">
        <span class="tooltiptext"> 
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

              $queryLuoghi="select * from luoghi;";
              $i=0;
              $contL=0;
              $result1=$conn->query($queryLuoghi);
              if($result1->num_rows > 0){ 
                while($row2=$result1->fetch_assoc()){
                    $arrayLuoghi[$i]["0"]=$row2["nome_luogo"];
                    $arrayLuoghi[$i]["1"]=$row2["id_piano"];
                    $contL=$contL+1;
                    $i=$i+1;
                }
              }
              
              for($i=0;$i<$cont;$i++){
                echo $arrayPiani[$i]["0"].":";
                      echo "<ul>";
                
                  for($j=0;$j<$contL;$j++){
                      if($arrayPiani[$i]["1"]==$arrayLuoghi[$j]["1"]){
                        echo "<li>".$arrayLuoghi[$j]["0"]."</li>";
                      }
                  } 

                  echo "</ul>";
                  
              }
              $conn->close();
          ?>
        </span>
      </div>
    
    </div>
 </div>   
  </body>
  </html>