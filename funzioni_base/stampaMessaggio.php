<?php
    function stampaMessaggio(){
        
    if(isset($_SESSION["var0"])){
        echo "<p><h4 style=\"color:black;\">";
        echo $_SESSION["var0"]."<br />";
        echo "</h4></p>";
        return 0;
    }else{
        echo "<p><h4 style=\"color:black;\">";
        echo "errore_nella_stampa";
        echo "</h4></p>";
        return 1;
    }
}
return stampaMessaggio();
?>