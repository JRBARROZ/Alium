<?php
require_once 'init.php';

if (!isLogged() || !isset($_POST['name'])) {
  redirect('index.php');
}

// $query = "SELECT * FROM `tipo_servico`";
// $stmt = $GLOBALS['pdo']->prepare($query);
// $stmt->execute();
// $services = $stmt->fetchAll();


// foreach ($services as $key => $service) {
  
//   if(isset(filter_input_array(INPUT_POST)[$service["tipo_servico"]])){
      
//     $query= "INSERT INTO `servico_has_usuario` (`id_servico`, `id_usuario`) VALUES (?, ?)";
//     $stmt= $GLOBALS["pdo"]->prepare($query);
//     $stmt-> execute([$service["id_tp_servico"], $_SESSION["user"]["id_usuario"]]);
//     echo $_SESSION["user"]["id_usuario"];
//     exit();

//   }
  
// }


$data = [];

$data[] = addslashes(trim($_POST['name']));
$data[] = addslashes(trim($_POST['cpf_cnpj']));
$data[] = addslashes(trim($_POST['email']));
$data[] = addslashes(trim($_POST['phone']));
$data[] = addslashes(trim($_POST['address']));
$data[] = addslashes(trim($_POST['address_number']));
$data[] = addslashes(trim($_POST['neighborhood']));
$data[] = addslashes(trim($_POST['city']));
$data[] = addslashes(trim($_POST['state']));
$data[] = addslashes(trim($_POST['cep']));
$data[] = addslashes(trim($_POST['user_id']));

$query = "UPDATE `usuario` SET `nome` = ?, `cpf_cnpj` = ?, `email` = ?, `telefone` = ?, `logradouro` = ?, `num_casa` = ?, `bairro` = ?, `municipio` = ?, `estado` = ?, `cep` = ? WHERE `id_usuario` = ?";

$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute($data);
redirect('profile.php');
?>