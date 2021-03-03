<?php 

require_once('init.php');
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
    }else{
        $allUserImgs = scandir("./images/portfolio/".$userFolder);
        $fileToVerify = "./images/portfolio/".$userFolder."/".$imgName;
        for($i = 2;$i < sizeof($allUserImgs); $i++){
            $firstCharacter = substr($allUserImgs[$i], 0, 1);
            if($firstCharacter == $id){
                unlink('./images/portfolio/'.$userFolder."/".$allUserImgs[$i]);
                break;
            }
        }
    }
    if(in_array($extVerify, $extensionsAccepted)){
        move_uploaded_file($imgFileTmp, './images/portfolio/'.$userFolder."/".$imgName); 
        $queryVerifyIfExists = "SELECT * FROM `images` WHERE `name` LIKE ? AND `user_id` = ?";
        $stmt = $GLOBALS['pdo']->prepare($queryVerifyIfExists);
        $stmt->execute([$id."%", $_SESSION['user']['id']]);
        $data = $stmt->fetch();
        $row = $stmt->rowCount();
        if($row == 1){
            $queryUpdate = "UPDATE `images` SET `name` = ? WHERE `id` = ? AND `user_id`= ?"; 
            $stmt = $GLOBALS['pdo']->prepare($queryUpdate);
            $stmt->execute([$imgName, $data['id'], $_SESSION['user']['id']]);
        }else{
            $queryInsert = "INSERT INTO `images` (`name`, `user_id`) VALUES (?, ?)"; 
            $stmt = $GLOBALS['pdo']->prepare($queryInsert);
            $stmt->execute([$imgName, $_SESSION['user']['id']]);
        }
    }else{
        echo "Error";
    }
}
?>