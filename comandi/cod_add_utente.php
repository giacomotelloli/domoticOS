<?php
    session_start();
    $nome=$_POST["nome"];
    $cognome=$_POST["cognome"];
    $email=$_POST["email"];
    $livello_newUser=$_POST["livello"];
    $password=$_POST["password"];
    $flag_form=$_POST["flag"];
    if(($flag_form==NULL)){

        echo "<messaggio tipoMex=\"info\"><testo>";
        echo "&lt;div class=\"w3-left\" &gt;";
        echo "&lt;form method=\"POST\" class=\"login-form\" action=\"comandi/cod_add_utente.php\"  \" &gt;";
           
                echo "&lt;div &gt;";
                echo "&lt;label class=\"label\"&gt;";
                echo "&lt;input placeholder=\"nome\" class=\"text\" type=\"text\" name=\"nome\" id=\"nome\"  &gt;";
                echo "&lt;span &gt; Nome &lt;/span &gt; ";
                echo "&lt;/label&gt;";
                echo "&lt;/div&gt;";

                echo "&lt;div &gt;";
                echo "&lt;label &gt;";
                echo "&lt;input placeholder=\"cognome\" type=\"text\" class=\"text\" name=\"cognome\" id=\"cognome\"  &gt; ";
                echo "&lt;span &gt; Cognome &lt;/span &gt; ";
                echo "&lt;/label&gt;";
                echo "&lt;/div&gt;";

                echo "&lt;div &gt;";
                echo "&lt;label &gt;";
                echo "&lt;input placeholder=\"email\" type=\"text\" class=\"text\" name=\"email\" id=\"email\"  &gt;";
                echo "&lt;span &gt; Email &lt;/span &gt; ";
                echo "&lt;/label&gt;";
                echo "&lt;/div&gt;";

                echo "&lt;div &gt;";
                echo "&lt;label &gt;";
                echo "&lt;input placeholder=\"password\" type=\"text\" class=\"text\" name=\"password\" id=\"password\"  &gt; ";
                echo "&lt;span &gt; Password &lt;/span &gt; ";
                echo "&lt;/label&gt;";
                echo "&lt;/div&gt;";
                
                
                echo "&lt;div &gt;";
                echo "&lt;label &gt;";
                echo "&lt;input placeholder=\"livello accesso\" type=\"text\" class=\"text\" name=\"livello\" id=\"livello\" &gt; ";
                echo "&lt;span &gt; Livello &lt;/span &gt; ";
                echo "&lt;/label&gt;";
                echo "&lt;/div&gt;";

                echo  "&lt;input style=\"display:none\" name=\"flag\" value=\"1\"/&gt;";
                echo  "&lt;input type=\"submit\"  value=\"Aggiungi Utente\" /&gt;";
            echo  "&lt;/form&gt;";
            echo  "&lt;/div&gt;";
        echo "</testo></messaggio>";
    }else{
            if(($nome!=NULL)&&($cognome!=NULL)&&($email!=NULL)&&($livello_newUser!=NULL)&&($password!=NULL)){
                              
                require_once "../database.php";
                $connessione=new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
            
                if (mysqli_connect_errno($connessione)) {
                    echo "Connessione fallita: ". mysqli_connect_errno($connessione) . ".";
                    $connessione->close();
                    exit();
                }

                    $query="insert into utenti_casa (nome,cognome,email,password,livello_permesso) values ('".$nome."','".$cognome."','".$email."','".$password."',".$livello_newUser.");";
                    if (!$connessione->query($query)){
                        $_SESSION["messaggioRitorno"]=$connessione->error."<br/>";
                    }else{
                        $_SESSION["messaggioRitorno"]="Utente Inserito<br/>";
                    }
                    $connessione->close();

                    header("Location:../adminUtente.php");
                    exit;
            }
            else{
                $_SESSION["messaggioRitorno"]="Utente non inserito, Valorizza Tutti i campi !!!<br />";
                header("Location:../adminUtente.php");
                    exit;
            } 
        }        
?>