<?php
require 'init.php';

$queries = ["INSERT INTO `services` (`service`) VALUES ('Marceneiro')", "INSERT INTO `services` (`service`) VALUES ('Pintor')", "INSERT INTO `services` (`service`) VALUES ('Pedreiro')", "INSERT INTO `services` (`service`) VALUES ('Eletricista')", "INSERT INTO `services` (`service`) VALUES ('Mecânico')", "INSERT INTO `services` (`service`) VALUES ('Encanador')"];

foreach ($queries as $query) {
  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute();
}
?>
<a href="index.php">Voltar</a>