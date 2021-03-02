<?php
require 'init.php';

$searchUsers = $_POST['searchUser'];

if($_POST['searchUser'] == ''){
    $data = false;
    echo json_encode($data);
}else{
    try{
        $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM `users` WHERE `name` LIKE ?");
        $stmt->execute([$searchUsers."%"]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    
    }catch(PDOException $e){
        print "deu ruim" . $e->getMessage();
    }
}

?>

