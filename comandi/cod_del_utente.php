<?php
    session_start();
    $email=$_POST["email"];
    
    $flag_form=$_POST["flag"];
    if(($flag_form==NULL)){

        echo "<messaggio tipoMex=\"info\"><testo>";
      
        echo "&lt;div class=\"w3-left\"&gt;";
        echo "&lt;form method=\"POST\" class=\"login-form\" action=\"comandi/cod_del_utente.php\" &gt;";
         
                
               
                echo "&lt;div &gt;";
                echo "&lt;label &gt;";
                echo "&lt;input placeholder=\"email\" type=\"text\" class=\"text\" name=\"email\" id=\"email\"  &gt;";
                echo "&lt;span &gt; Email &lt;/span &gt; ";
                echo "&lt;/label&gt;";
                echo "&lt;/div&gt;";

                echo  "&lt;input style=\"display:none\" name=\"flag\" value=\"1\"/&gt;";
                echo  "&lt;input type=\"submit\"  value=\"Elimina Utente\" /&gt;";
          
        echo "&lt;/form&gt;";
        echo "&lt;/div&gt;";
        echo "</testo></messaggio>";
    }else{
            if($email!=NULL){
                              
                require_once "../database.php";
                $connessione=new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
            
                if (mysqli_connect_errno($connessione)) {
                    echo "Connessione fallita: ". mysqli_connect_errno($connessione) . ".";
                    $connessione->close();
                    exit();
                }

                    $query="delete from utenti_casa where (email='".$email."');";
                    
                    if (!$connessione->query($query)) {
                        
                        $_SESSION["messaggioRitorno"]=$connessione->error."<br/>";
                    }else{
                        $_SESSION["messaggioRitorno"]="Utente Eliminato<br/>";
                    }
                    $connessione->close();
                   
                    header("Location:../adminUtente.php");
                    exit;
            }
            else{
                $_SESSION["messaggioRitorno"]="Utente non eliminato, Valorizza l'email !!!<br />";
                header("Location:../adminUtente.php");
                    exit;
            } 
        }        
?>