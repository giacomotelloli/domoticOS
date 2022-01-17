<?php
    if(isset($_GET["piano"])){
        include_once "database.php";
        $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);

        if (mysqli_connect_errno($conn)) {
            echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
            exit();
        }
        $queryLuoghi="select * from luoghi,piani where((nome_piano='".$_GET["piano"]."')AND(piani.id=luoghi.id_piano));";
        $i=0;
       
        $result1=$conn->query($queryLuoghi);
        if($result1->num_rows > 0){ 
          while($row2=$result1->fetch_assoc()){
             echo "<a href=\"paginaStanza.php?stanza=".$row2["nome_luogo"]."\" class=\"w3-button w3-padding-large w3-teal\">".$row2["nome_luogo"]."</a>";
             
              $i=$i+1;
          }
        }
    }else{
        exit;
    }

?>