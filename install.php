<?php
    $nomeDb="domotic_os";
    $nomeUtente="root";
    $passwd="";
    $indirizzoServer="localhost";
    
    $conn= new mysqli($indirizzoServer,$nomeUtente,$passwd,$nomeDb);
   
    // verifica su eventuali errori di connessione
    if (mysqli_connect_errno($conn)) {
        echo "Connessione fallita: ". mysqli_connect_errno($conn) . ".";
        exit();
    }
    $queryCreaLuoghi="
    CREATE TABLE `luoghi` (
      `id` int(11) NOT NULL,
      `nome_luogo` varchar(30) DEFAULT NULL,
      `id_piano` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    ";

    $conn->query($queryCreaLuoghi);

    $queryDumpLughi="
    INSERT INTO `luoghi` (`id`, `nome_luogo`, `id_piano`) VALUES
    (1, 'giardino', 1),
    (2, 'cucina', 1),
    (3, 'cameretta', 2),
    (4, 'garage', 1);
    ";
    $conn->query($queryDumpLuoghi);


    $queryCreaOggetti="
    CREATE TABLE `oggetti` (
      `id` int(11) NOT NULL,
      `nome` varchar(30) NOT NULL,
      `id_luogo` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $conn->query($queryCreaOggetti);

    $queryDumpOggetti="
    INSERT INTO `oggetti` (`id`, `nome`, `id_luogo`) VALUES
    (2, 'serra', 1),
    (3, 'macchina', 4),
    (17, 'frigorifero', 2),
    (18, 'macchinetta_caffe', 2),
    (26, 'computer', 3);";
    $conn->query($queryDumpOggetti);

    
    $queryCreaPiani="
CREATE TABLE `piani` (
    `id` int(11) NOT NULL,
    `nome_piano` varchar(30) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $conn->query($queryCreaPiani);

    $queryDumpPiani="
INSERT INTO `piani` (`id`, `nome_piano`) VALUES
(1, 'piano_terra'),
(2, 'primo_piano');";

$conn->query($queryDumpPiani);

$queryCreaUtenti="
CREATE TABLE `utenti_casa` (
    `id` int(11) NOT NULL,
    `nome` varchar(30) NOT NULL,
    `cognome` varchar(30) NOT NULL,
    `email` varchar(30) NOT NULL,
    `password` varchar(30) NOT NULL,
    `livello_permesso` int(11) NOT NULL,
    `logged` int(11) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $conn->query($queryCreaUtenti);

    $queryDumpUtenti="
    INSERT INTO `utenti_casa` (`id`, `nome`, `cognome`, `email`, `password`, `livello_permesso`, `logged`) VALUES
    (1, 'Giacomo', 'Telloli', 'tell.giacomo@gmail.com', 'giacomo', 4, 1),
    (2, 'lucia', 'pelle', 'lucia.pelle@gmail.com', 'lucia', 3, 0),
    (3, 'Gigi', 'Latrottola', 'gigi@gmail.com', 'gigi', 1, 0);";

$conn->query($queryDumpUtenti);


$queryAlterLuoghi="
  ALTER TABLE `luoghi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_luogo` (`nome_luogo`);";


$queryAlterOggetti="
ALTER TABLE `oggetti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);"



$queryAlterPiani="
ALTER TABLE `piani`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_piano` (`nome_piano`);";

 
$queryAlterUtenti="
ALTER TABLE `utenti_casa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);";

  $conn->query($queryAlterLuoghi);
  $conn->query($queryAlterOggetti);
  $conn->query($queryAlterPiani);
  $conn->query($queryAlterUtenti);



$queryIncLuoghi="
ALTER TABLE `luoghi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;";


$queryIncOggetti="
ALTER TABLE `oggetti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;";


$queryIncPiani="
ALTER TABLE `piani`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;";


$queryIncUtenti="
ALTER TABLE `utenti_casa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;";
 
  $conn->query($queryIncLuoghi);
  $conn->query($queryIncOggetti);
  $conn->query($queryIncPiani);
  $conn->query($queryIncUtenti);
echo "<br/> database popolato";

  function copia_tutto($src,$dest) {

    if ($handle = opendir($src))
    {
      while ($file = readdir($handle))
      {
        if (is_dir("./{$src}/{$file}"))
        {
          if ($file != "." & $file != ".."){
            mkdir($dest . "/" . $file);
            copia_tutto($src."/".$file, $dest."/".$file);
          } 
        } else if ( ($file!=".") && ($file!="..")){
        
            copy($src."/".$file, $dest."/".$file);
          } 
      }
    }

  }
  
copia_tutto("xml_popolato","xml");
echo "<br/>cartella xml copiata"; 

 


?>