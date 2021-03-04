<?php 
require_once 'init.php';
$user_id = $_SESSION['user']['id'];
try{
    $query = "SELECT * FROM `images` WHERE `name` NOT LIKE ? AND `user_id` = ?";
    $stmt = $GLOBALS['pdo']->prepare($query);
    $stmt->execute(['perfil%',$user_id]);
    $perfil_img = $stmt->fetchAll();
    echo json_encode($perfil_img);

}catch(PDOException $e){
    print "deu ruim" . $e->getMessage();
}

?>