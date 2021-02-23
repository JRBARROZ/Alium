<?php 

require_once('init.php');
session_start();
$imgs = $_FILES['images']; 
$id = $_POST['id'];

$extensionsAccepted = ['jpg', 'png'];
$userFolder = "user_port_".$_SESSION['user']['id'];

foreach ($imgs['tmp_name'] as $key => $value) {
    $extToRename = explode(".", $imgs['name'][$key]);
    $imgName = $id.".".end($extToRename);
    $imgFileTmp= $imgs['tmp_name'][$key];
    $extVerify = pathinfo($imgName, PATHINFO_EXTENSION);
    if(!is_dir("./images/portfolio/".$userFolder)){
        mkdir("./images/portfolio/".$userFolder);
    }
    if(in_array($extVerify, $extensionsAccepted)){
        move_uploaded_file($imgFileTmp, './images/portfolio/'.$userFolder."/".$imgName); 
        // $query = "INSERT INTO users (`name`, `cpf_cnpj`, `email`, `phone`, `description`, `address`, `address_number`, `neighborhood`, `city`, `state`, `password`, `username`, `postal_code`, `role`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
    }else{
        echo "Error";
    }
}
?>