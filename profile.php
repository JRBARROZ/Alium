<?php
require_once 'init.php';

if(!isLogged()) {
    redirect('signin.php');
    exit();
}

$user_id = $_SESSION['user']['id'];

$description = $_SESSION['user']['description'];

$query = "SELECT * FROM `users` WHERE `id` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$query = "SELECT * FROM `services`";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute();
$services = $stmt->fetchAll();

$query= "SELECT * FROM `images` WHERE `user_id` = ? ORDER BY `id` DESC";
$stmt= $GLOBALS["pdo"]->prepare($query);
$stmt-> execute([$_SESSION["user"]["id"]]);
$images = $stmt->fetchAll();
$images_ids = [];
if (sizeof($images) > 0) {
    foreach ($images as $image) {
        array_push($images_ids, $image['service_id']);
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/profile.css">
</head>
<body>
    <div class="header">
        <div class="menu-container">
            <a href="index.php" class="menu-logo"><img src="images/icons/logo.svg" alt=""></a>
            <nav class="menu-nav">
                <ul>
                    <?php if(isset($_SESSION['user'])):?>
                        <!-- <li><a>Bem-vindo(a),</a></li> -->
                        <li><a href="profile.php"><?= $_SESSION['logged-user']?></a></li>
                        <li><a href="logout.php" class="text-color-yellow">Sair</a></li>
                    <?php else :?>
                        <li><a href="signup.php">Registrar-se</a></li>
                        <li><a href="signin.php">Entrar</a></li>
                    <?php endif;?>
                </ul>
            </nav>
        </div>
    </div>
    <div class="content-profile">
        <div class="perfil-provider">
            <div class="perfil-img">
                <div class="img">
                    <img src="./images/profile/perfilImage.jpg" alt="">
                </div>
                <br>
                <p style="max-width: 250px;"><span class="name"><?= $user['name'] ?></span><br><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $user['city'] ?>, <?= $user['state'] ?>, <br>
                <?php
                foreach ($images_ids as $i => $id):
                    $serv = getServiceById($id);
                    if ($i == sizeof($images_ids) - 1 || $i == 2):
                    ?>
                        <a href='provider_list.php?work=<?=$serv['service']?>'><?= $serv['service'] ?></a>
                    <?php
                    else:
                    ?>
                        <a href='provider_list.php?work=<?=$serv['service']?>'><?= $serv['service'] ?></a> - 
                    <?php
                    endif;
                    if ($i == 2) :
                        break;
                    endif;
                endforeach;
                ?>
            </p>
            </div>
            <div class="profile-nav">
                <div class="profile-item">
                    <h3>Sobre
                        <a href="#" id="edit-button" onclick="showAboutForm()"><i class="fa fa-pencil fa-1" aria-hidden="true"></i></a>
                        <a href="#" id="hide-about-form" onclick="hideAboutForm()"><i class="fa fa-times fa-1" aria-hidden="true"></i></a>
                    </h3>
                    <p id="about-content"><?= $description ?></p>
                    <form id="about-form" action="update_profile.php" method="POST">
                        <textarea name="about" cols="5" rows="6"><?= $description ?></textarea>
                        <input type="submit" value="Salvar">
                    </form>
                </div>
                <div class="profile-item">
                    <h3>Avaliação</h3>
                    <p>4.5 / 5.0 - Ótimo</p>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star-half-o checked"></span>
                </div>
                <div class="profile-item">
                    <h3>Contatos</h3>
                    <ul>
                        <li><i class="fa fa-whatsapp" aria-hidden="true"></i> <?= $user['phone'] ?></li>
                        <li><i class="fa fa-instagram" aria-hidden="true"></i> @pamisley</li>
                        <li><i class="fa fa-twitter" aria-hidden="true"></i> @pam_painter</li>
                    </ul>
                </div>
                <div class="profile-item port">
                    <h3>Portifólio</h3>
                    <br>
                    <form  method="POST" enctype="multipart/form-data" action="uploadImgs.php" >
                        <!-- <div class="send-img">
                            <input type="file" name="images[]" onchange="displayImg(this)">
                        </div> -->
                        <div class="send-img">
                            <input type="file" onchange="displayImg(this)" id='0'>
                        </div>
                        <div class="send-img">
                            <input type="file" onchange="displayImg(this)" id='1'>
                        </div>
                        <div class="send-img">
                            <input type="file" onchange="displayImg(this)" id='2'>
                        </div>
                        <div class="send-img">
                            <input type="file" onchange="displayImg(this)" id='3'>
                        </div>
                        <div class="send-img">
                            <input type="file" onchange="displayImg(this)" id='4'>
                        </div>
                        <div class="send-img">
                            <input type="file" onchange="displayImg(this)" id='5'>
                        </div>
                        <!-- <button type='submit'>Enviar Imagens</button> -->
                    </form>
                    <button class="btn" onclick="previewShow(this)">Preview</button>
                    <br>
                </div>
            </div>
        </div>
        <section class="profile-edit" >
            <div id='profile-preview' style='display:none'>
                <div class="profile-title">
                    <h2 style="">Pré-visualização</h2>
                </div>
                <div class="profile-preview">
                    <div class="profile-preview-item"></div>
                </div>
            </div>
            <div class="profile-form" style="">
                <div class="profile-text-edit">
                    <h3 id="text" style="max-width: 500px;line-height:2em;">Olá, <?= $_SESSION['logged-user'] ?>, seja bem-vindo(a) ao Alium :)<br>Por favor, finalize seu cadastro abaixo.<br><a href="#" class="btn" onclick="showForm(this)">Atualizar Cadastro</a></h3>
                    <h3 id="edit" style="display: none;">Editar Perfil</h3>
                    <form action="update_profile.php" method="POST" id="form">
                        <br>
                        <label for="cpf_cnpj">CPF/CNPJ:</label><br>
                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" onfocus="removeMask(this);" onblur="addCpfCnpjMask(this);" value="<?= $user['cpf_cnpj'] ?>" required><br>
                        <label for="name">Nome:</label><br>
                        <input type="text" id="name" name="name" value="<?= $user['name'] ?>" required><br>
                        <label for="email">E-mail:</label><br>
                        <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required><br>
                        <label for="phone">Telefone:</label><br>
                        <input type="text" id="phone" name="phone" onfocus="removeMask(this);" onblur="addPhoneMask(this);" value="<?= $user['phone'] ?>" required><br>
                        <label for="cep">CEP:</label><br>
                        <input type="text" id="cep" name="cep" value="<?= $user['postal_code'] ?>"  size="10" maxlength="9" onblur="pesquisacep(this.value);" required><br>
                        <label for="address">Endereço:</label><br>
                        <input type="text" id="address" name="address" value="<?= $user['address'] ?>" required><br>
                        <label for="address_number">Número:</label><br>
                        <input type="text" id="address_number" name="address_number" value="<?= $user['address_number'] ?>" required><br>
                        <label for="neighborhood">Bairro:</label><br>
                        <input type="text" id="neighborhood" name="neighborhood" value="<?= $user['neighborhood'] ?>" required><br>
                        <label for="city">Cidade:</label><br>
                        <input type="text" id="city" name="city" value="<?= $user['city'] ?>" required><br>
                        <label for="state">Estado:</label><br>
                        <input type="text" id="state" name="state" value="<?= $user['state'] ?>" required><br>
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>"><br>
                        <!-- <label for="profession">Tipo de Serviço:</label><br> -->
                        <?php if ($user['role'] === 'worker'): ?>
                            <?php foreach ($services as $i => $service): ?>
                                <?php if (sizeof($images_ids) > 0 && in_array($service['id'], $images_ids)): ?>
                                    <input id=<?=$i?> type="checkbox" name="<?= $service['service'] ?>" value="<?=$service['service']?>" checked>
                                <?php else: ?>
                                    <input id=<?=$i?> type="checkbox" name="<?= $service['service'] ?>" value="<?=$service['service']?>">
                                <?php endif ?>
                                <label for=<?=$i?>><?= $service['service'] ?></label><br>
                            <?php endforeach ?>
                        <?php endif ?>
                        <!-- <label for="other">Outro:</label><br>
                        <input type="text" id="other" name="other_service"> -->
                        <br>
                        <input type="submit" value="Atualizar"><br><br>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <img src="" alt="" id="displayImg">
    <section class="footer">
        <div class="footer-container">
            <div class="logo-footer">
                <img src="images/icons/logo-footer.svg" alt="">
            </div>
        </div>
    </section>
    <script>
        let imgsArray = [];
        let clicks = 0;
        function showForm(e){
            e.style.display = "none";
            document.querySelector('#text').style.display="none";
            document.querySelector('#form').style.display="block";
            document.querySelector('#edit').style.display="block";
        }
        function showAboutForm() {
            document.querySelector('#about-form').style.display = "block";
            document.querySelector('#hide-about-form').style.display = "block";
            document.querySelector('#edit-button').style.display = "none";
            document.querySelector('#about-content').style.display = "none";
        }
        function hideAboutForm() {
            document.querySelector('#about-form').style.display = "none";
            document.querySelector('#hide-about-form').style.display = "none";
            document.querySelector('#edit-button').style.display = "block";
            document.querySelector('#about-content').style.display = "block";
        }

        //Imgs
        function displayImg(e){
            // e.parentElement.style.backgroundImage = "";
            let file = e;
            let teste = URL.createObjectURL(file.files[0]);
            console.log(teste);
            e.parentElement.style.backgroundImage = "url("+teste+")";
            
            imgsArray.push(teste);
            // console.table(imgsArray);
            insertImg(e);
            // previewShowImgs();
        }
        function insertImg(e){
            const endPoint = 'uploadImgs.php';
            const formData = new FormData();
            formData.append('images[]', e.files[0]);
            formData.append('id', e.id);            
            fetch(endPoint, {
                method: 'post',
                body: formData
            }).catch(console.error);
        }

        function previewShow(e){
            const profileForm = document.querySelector('.profile-form');
            const profilePreview = document.querySelector('#profile-preview');
            // console.log(profileForm);
            // console.log(clicks);
            if(clicks == 0){
                e.innerHTML = 'Cancelar Preview';
                profileForm.style.display = "none";
                profilePreview.style.display = "block";
                clicks++;
                previewShowImgs();
            }else{
                e.innerHTML = 'Preview';    
                clicks = 0;
                profileForm.style.display = "flex";
                profilePreview.style.display = "none";
            }
        }
        function previewShowImgs(){
            // const previewData = document.querySelector('.profile-preview');
            // previewData.innerHTML = "";
            // for(let i = 0; i < imgsArray.length; i ++){
            //     const div = document.createElement('div');
            //     div.classList.add("profile-preview-item");
            //     div.style.backgroundImage = "url("+imgsArray[i]+")";
            //     previewData.appendChild(div);
            // }
            // console.table(imgsArray);
        }
    </script>
</body>
<script src="js/cep.js"></script>
<script src="js/masks.js"></script>
</html>