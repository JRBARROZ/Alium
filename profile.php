<?php
require_once 'init.php';
if (!isLogged()) {
    redirect('signin.php');
    exit();
}

$user_id = $_SESSION['user']['id'];
$description = $_SESSION['user']['description'];
$phone = $_SESSION['user']['phone'];
if ($_SESSION['user']['social_media'] == '') {
    $insta = 'Não Informado';
    $twitter = 'Não Informado';
} else {
    list($insta, $twitter) = explode(';', $_SESSION['user']['social_media']) ?? '';
    $insta = $insta[0] == '@' ? $insta : "@" . $insta;
    $twitter = $twitter[0] == '@' ? $twitter : "@" . $twitter;
}

$query = "SELECT * FROM `users` WHERE `id` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$query = "SELECT * FROM `images` WHERE `name` NOT LIKE ? AND `user_id` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute(['perfil%',$user_id]);
$portfolio_images = $stmt->fetchAll();

$query = "SELECT * FROM `services`";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute();
$services = $stmt->fetchAll();

$query = "SELECT * FROM `images` WHERE `name` LIKE ? AND `user_id` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute(['perfil%',$user_id]);
$perfil_img = $stmt->fetch();

$query = "SELECT * FROM `users_has_services` WHERE `user_id` = ? ORDER BY `id` DESC";
$stmt = $GLOBALS["pdo"]->prepare($query);
$stmt->execute([$user_id]);
$usr_services = $stmt->fetchAll();
$services_ids = [];
if (sizeof($usr_services) > 0) {
    foreach ($usr_services as $image) {
        array_push($services_ids, $image['service_id']);
    }
}

$query = "SELECT `evaluation` FROM `feedbacks` WHERE `worker_id` = ? ";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute([$user['id']]);
$evaluations = $stmt->fetchAll();
$row = $stmt->rowCount();
$rate = 0;
if ($row > 0) {
    $sum = 0;
    foreach ($evaluations as $evaluation) {
        $sum += $evaluation['evaluation'];
    }
    $rate = round($sum / $row, 1);
    $rate_size = strlen((string)$rate);
    if ($rate_size == 1) {
        $rate = '' . $rate . '.0';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="view" content="width=device-width, initial-scale=1.0">
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
                    <?php if (isset($_SESSION['user'])) : ?>
                        <!-- <li><a>Bem-vindo(a),</a></li> -->
                        <li><a href="profile.php"><?= $_SESSION['logged-user'] ?></a></li>
                        <li><a href="logout.php" class="text-color-yellow">Sair</a></li>
                    <?php else : ?>
                        <li><a href="signup.php">Registrar-se</a></li>
                        <li><a href="signin.php">Entrar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <div class="content-profile">
        <div class="perfil-provider">
            <div class="success-message" id="perfil-feed" style="display:none;">Imagem Enviada com sucesso!!</div>
            <div class="perfil-img port">
                <div class="img">
                    <!-- <img src="./images/profile/perfilImage.jpg" alt=""> -->
                    <form method="POST" enctype="multipart/form-data" action="uploadImgs.php">
                        <?php if($perfil_img) :?>
                            <div class="send-profile-img" style="background-image: url('images/portfolio/user_port_<?= $user_id ?>/<?= "perfil" ?>/<?=$perfil_img['name']?> ') !important">
                                <input type="file" onchange="displayImg(this)" id="perfil">
                            </div>
                        <?php else : ?>
                            <div class="send-profile-img" style="background-image: url('./images/profile/profile.png') !important">
                                <input type="file" onchange="displayImg(this)" id="perfil">
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
                <br>
                <p style="max-width: 250px;"><span class="name"><?= $user['name'] ?></span><br><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $user['city'] ?>, <?= $user['state'] ?>, <br>
                    <?php
                    foreach ($services_ids as $i => $id) :
                        $serv = getServiceById($id);
                        if ($i == sizeof($services_ids) - 1 || $i == 2) :
                    ?>
                            <a href='provider_list.php?work=<?= $serv['service'] ?>'><?= $serv['service'] ?></a>
                        <?php
                        else :
                        ?>
                            <a href='provider_list.php?work=<?= $serv['service'] ?>'><?= $serv['service'] ?></a> -
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
                <div class="profile-item star-size">
                    <?php if ($rate == 0) : ?>
                        <h3>Sem avaliações</h3>
                    <?php else : ?>
                        <h3>Avaliação</h3>
                        <p><?= $rate ?>/5.0</p>
                        <?php
                        $rate = (string)$rate;
                        $eval = explode('.', $rate);
                        $int_rate = (int)$eval[0];
                        $dec_rate = (int)$eval[1];
                        for ($i = 0; $i < 5; $i++) :
                        ?>
                            <?php if ($i <= $int_rate - 1) : ?>
                                <span class="fa fa-star checked"></span>
                            <?php elseif ($i == $int_rate && $dec_rate >= 3) : ?>
                                <span class="fa fa-star-half-o checked"></span>
                            <?php else : ?>
                                <span class="fa fa-star empty-star"></span>
                            <?php endif ?>
                        <?php endfor ?>
                    <?php endif ?>
                </div>
                <div class="profile-item">
                    <h3>Contatos
                        <a href="#" id="edit-contacts-button" onclick="showContactsForm()"><i class="fa fa-pencil fa-1" aria-hidden="true"></i></a>
                        <a href="#" id="hide-contacts-form" onclick="hideContactsForm()"><i class="fa fa-times fa-1" aria-hidden="true"></i></a>
                    </h3>
                    <form id="contacts-form" action="update_profile.php" method="POST">
                        <div>
                            <i class="fa fa-whatsapp" aria-hidden="true" id="icon"></i><input type="text" name="phone" value="<?= $phone ?>">
                        </div>
                        <div>
                            <i class="fa fa-instagram" aria-hidden="true" id="icon"></i><input type="text" name="insta" value="<?= $insta ?>">
                        </div>
                        <div>
                            <i class="fa fa-twitter" aria-hidden="true" id="icon"></i><input type="text" name="twitter" value="<?= $twitter ?>">
                        </div>
                        <input type="submit" value="Salvar">
                    </form>
                    <ul id="contacts-content">
                        <li><i class="fa fa-whatsapp" aria-hidden="true"></i> <?= $phone ?></li>
                        <li><a href="https://www.instagram.com/<?= str_replace('@', '', $insta) ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> <?= $insta ?></a></li>
                        <li><a href="https://twitter.com/<?= str_replace('@', '', $twitter) ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i> <?= $twitter ?></a></li>
                    </ul>
                </div>
                <div class="profile-item port">
                    <h3>Portfólio</h3>
                    <br>
                    <form method="POST" enctype="multipart/form-data" action="uploadImgs.php">
                        <?php
                        for ($i = 0; $i < 6; $i++) :
                            if (isset($portfolio_images[$i])) :
                        ?>
                            <div class="send-img" style="background-image: url('images/portfolio/user_port_<?= $user_id ?>/<?= $portfolio_images[$i]['name'] ?>') !important">
                                <input type="file" onchange="displayImg(this)" id="<?= $i ?>">
                            </div>
                            <?php else : ?>
                                <div class="send-img">
                                    <input type="file" onchange="displayImg(this)" id="<?= $i ?>">
                                </div>
                            <?php endif ?>
                        <?php endfor ?>
                        <!-- <button type='submit'>Enviar Imagens</button> -->
                    </form>
                    <button class="btn" onclick="previewShow(this)">Ver Portfólio</button>
                    <br>
                </div>
            </div>
        </div>
        <section class="profile-edit">
            <div id='profile-preview' style='display:none'>
                <div class="profile-title">
                    <h2>Pré-visualização</h2>
                </div>
                <div class="profile-preview">
                    <?php //for ($i = 0; $i < sizeof($portfolio_images); $i++) : ?>
                        <!-- style="background-image: url('images/portfolio/user_port_<?php //$user_id ?>/<?php //$portfolio_images[$i]['name'] ?>') !important" -->
                    <?php // endfor; ?>
                </div>
            </div>
            <div class="profile-form">
                <div class="profile-text-edit">
                    <h3 id="text" style="max-width: 500px;line-height:2em;">Olá, <?= $_SESSION['logged-user'] ?>, seja bem-vindo(a) ao Alium :)<br>Por favor, finalize seu cadastro abaixo.<br><a href="#" class="btn" onclick="showForm(this)">Atualizar Cadastro</a></h3>
                    <h3 id="edit" style="display: none;">Editar Perfil</h3>
                    <div class="error-message-form">
                        <h4>Erros encontrados:</h4>
                        <ul id="error-form"></ul>
                    </div>
                    <form action="update_profile.php" method="POST" id="form" class="form">
                        <br>
                        <label for="name">Nome:</label><br>
                        <input type="text" id="name" name="name" value="<?= $user['name'] ?>" required><br>
                        <label for="cpf_cnpj">CPF/CNPJ:</label><br>
                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" onfocus="removeMask(this);" onblur="addCpfCnpjMask(this);" minlength="11" maxlength="14" value="<?= $user['cpf_cnpj'] ?>" required><br>
                        <label for="email">E-mail:</label><br>
                        <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required><br>
                        <label for="phone">Telefone:</label><br>
                        <input type="text" id="phone" name="phone" onfocus="removeMask(this);" onblur="addPhoneMask(this);" minlength="10" maxlength="11" value="<?= $user['phone'] ?>" required><br>
                        <label for="cep">CEP: <span id="text">(Não sabe o CEP? <a href="https://buscacepinter.correios.com.br/app/endereco/index.php?t" target="_blank">Clique aqui</a>) </span></label><br>
                        <input type="text" id="cep" name="cep" size="10" maxlength="9" onblur="searchPostalCode(this);" value="<?= $user['postal_code'] ?>" required><br>
                        <div class="form-group">
                            <div class="form-side">
                                <label for="address">Rua:</label>
                                <input type="text" id="address" name="address" value="<?= $user['address'] ?>" required>
                            </div>
                            <div class="form-side">
                                <label for="address_number">Número:</label>
                                <input type="text" id="address_number" name="address_number" value="<?= $user['address_number'] ?>" required>
                            </div>
                            <div class="form-side">
                                <label for="address_complement">Complemento:</label>
                                <input type="text" id="address_complement" name="address_complement" value="<?= $user['address_complement'] ?>" required>
                            </div>
                            <div class="form-side">
                                <label for="neighborhood">Bairro:</label>
                                <input type="text" id="neighborhood" name="neighborhood" value="<?= $user['neighborhood'] ?>" required>
                            </div>
                            <div class="form-side">
                                <label for="city">Cidade:</label>
                                <input type="text" id="city" name="city" value="<?= $user['city'] ?>" required>
                            </div>
                            <div class="form-side">
                                <label for="state">Estado:</label>
                                <input type="text" id="state" name="state" value="<?= $user['state'] ?>" required>
                            </div>
                        </div>
                        <!-- <label for="profession">Tipo de Serviço:</label><br> -->
                        <?php if ($user['role'] === 'worker') : ?>
                            <label for="">Serviços:</label><br>
                            <div class="service-content">
                                <?php foreach ($services as $i => $service) : ?>
                                    <div>
                                        <?php if (sizeof($services_ids) > 0 && in_array($service['id'], $services_ids)) : ?>
                                            <input id=<?= $service['service'] ?> type="checkbox" name="<?= $service['service'] ?>" value="<?= $service['service'] ?>" checked>
                                        <?php else : ?>
                                            <input id=<?= $service['service'] ?> type="checkbox" name="<?= $service['service'] ?>" value="<?= $service['service'] ?>">
                                        <?php endif ?>
                                        <label for=<?= $service['service'] ?>><?= $service['service'] ?> </label><br>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        <br>
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <input type="submit" value="Atualizar">
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
</body>
<script src="js/profile.js"></script>
<script src="js/masks.js"></script>
<script src="js/cep.js"></script>
<script src="js/validate_form.js"></script>
</html>