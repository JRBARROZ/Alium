<?php
require 'init.php';

$search = $_POST['search'];

if($_POST['search'] == ''){
    $data = false;
    echo json_encode($data);
}else{
    try{
        $stmt = $pdo->prepare("Select * FROM tipo_servico WHERE tipo_servico LIKE ?");
        $stmt->execute([$search."%"]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    
    }catch(PDOException $e){
        print "deu ruim" . $e->getMessage();
    }
}


?>