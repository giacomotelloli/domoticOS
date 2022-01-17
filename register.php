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

   
    <div class="session">
      
      <div class="left">
      </div>

      <form class="formLog log-in" action="insert.php"  method="POST"> 
        <h4><span>Domotic OS</span></h4>
        <p>Registrati</p>
        
        <div class="floating-label">
          <input placeholder="Nome" type="text" name="nome" id="nome" value="<?php if(isset($_SESSION["name"])){echo $_SESSION["name"];}?>">
          <label for="nome">Nome</label>
        </div>
        
        <div class="floating-label">
          <input placeholder="Cognome" type="text" name="cognome" id="cognome" value="<?php if(isset($_SESSION["surname"])){echo $_SESSION["surname"];}?>">
          <label for="cognome">Cognome</label>
        </div>

        <div class="floating-label">
          <input placeholder="Email" type="text" name="email" id="email" value="<?php if(isset($_SESSION["Email"])){echo $_SESSION["Email"];}?>" >
          <label for="email">Email</label>
        </div>
        <div class="floating-label">
          <input placeholder="Password" type="text" name="password" id="password" value="<?php if(isset($_SESSION["pass1"])){echo $_SESSION["pass1"];}?>">
          <label for="password">Password:</label>
        </div>
        <button type="submit">Invia Dati</button>
        <span><?php 
            if(isset($_SESSION["error"])){
              if($_SESSION["error"]==1){
                echo "H.A.L. :Attenzione valorizza tutti i campi";
                $_SESSION["error"]=0;
              }
              if($_SESSION["error"]==2){
                echo "H.A.L. :Attenzione email non valida";
                $_SESSION["error"]=0;
              }
            }
        ?></span>
      </form>
      
    </div>
    
    
  </body>
  </html>