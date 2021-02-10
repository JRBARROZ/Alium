<?php
require_once 'init.php';

$user_id = $_SESSION['user']['id_usuario'];

$query = "SELECT * FROM `usuario` WHERE `id_usuario` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="./css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="header">
        <div class="header-container">
            <header>
                <a href="index.php" class="menu-logo"><img src="images/icons/logo.svg" alt=""></a>
            </header>
        </div>
    </div>
    <div class="content-profile">
        <div class="perfil-provider">
            <div class="perfil-img">
                <div class="img">
                    <img src="./images/profile/perfilImage.jpg" alt="">
                </div>
                <br>
                <p><span class="name"><?= $user['nome'] ?></span><br><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $user['municipio'] ?>, <?= $user['estado'] ?>, <br>Pintor</p>
            </div>
            <div class="profile-nav">
                <div class="profile-item">
                    <h3>Sobre</h3>
                    <p>Id et consequat sit veniam exercitation eiusmod. d et consequat sit veniam exercitation eiusmod</p>
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
                        <li><i class="fa fa-whatsapp" aria-hidden="true"></i> <?= $user['telefone'] ?></li>
                        <li><i class="fa fa-instagram" aria-hidden="true"></i> @pamisley</li>
                        <li><i class="fa fa-twitter" aria-hidden="true"></i> @pam_painter</li>
                    </ul>
                </div>
            </div>
        </div>
        <section class="profile-edit">
            <div class="profile-form">
                <div class="profile-text-edit">
                    <h3 id="text" style="max-width: 500px;line-height:2em;">Olá, <?= $user['nome'] ?> seja bem vindo(a) ao Alium :)<br>Por favor, finalize seu cadastro abaixo.<br><a href="#" class="btn" onclick="showForm(this)">Atualizar Cadastro</a></h3>
                    <h3 id="edit" style="display: none;">Editar Perfil</h3>
                    <form action="update_profile.php" method="POST" id="form">
                        <br>
                        <label for="cpf_cnpj">CPF/CNPJ:</label><br>
                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" minlength="11" maxlength="14" value="<?= $user['cpf_cnpj'] ?>" required><br>
                        <label for="name">Nome:</label><br>
                        <input type="text" id="name" name="name" value="<?= $user['nome'] ?>" required><br>
                        <label for="email">E-mail:</label><br>
                        <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required><br>
                        <label for="phone">Telefone:</label><br>
                        <input type="text" id="phone" name="phone" value="<?= $user['telefone'] ?>" required><br>
                        <label for="cep">CEP:</label><br>
                        <input type="text" id="cep" name="cep" value="<?= $user['cep'] ?>" required><br>
                        <label for="address">Endereço:</label><br>
                        <input type="text" id="address" name="address" value="<?= $user['logradouro'] ?>" required><br>
                        <label for="address_number">Número:</label><br>
                        <input type="text" id="address_number" name="address_number" value="<?= $user['num_casa'] ?>" required><br>
                        <label for="neighborhood">Bairro:</label><br>
                        <input type="text" id="neighborhood" name="neighborhood" value="<?= $user['bairro'] ?>" required><br>
                        <label for="city">Cidade:</label><br>
                        <input type="text" id="city" name="city" value="<?= $user['municipio'] ?>" required><br>
                        <label for="state">Estado:</label><br>
                        <input type="text" id="state" name="state" value="<?= $user['estado'] ?>" required><br>
                        <input type="hidden" name="user_id" value="<?= $user['id_usuario'] ?>"><br>
                        <!-- <label for="sobre">Sobre:</label><br>
                        <input type="text" id="sobre" name="sobre" value="<?= $user['descricao'] ?>" required><br> -->
                        <label for="profession">Tipo de Serviço:</label><br>
                        <select id="profession" name="profession">
                            <option value="Pintor(a)">Pintor(a)</option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                        </select><br>
                        <label for="portfolio">Portfólio:</label><br>
                        <input type="file" id="portfolio" name="portfolio"><br>
                        <input type="submit" value="Atualizar"><br><br>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <section class="footer">
        <div class="footer-container">
            <div class="logo-footer">
                <img src="images/icons/logo-footer.svg" alt="">
            </div>
        </div>
    </section>
    <script>
        function showForm(e){
            e.style.display = "none";
            document.getElementById('text').style.display="none";
            document.getElementById('form').style.display="block";
            document.getElementById('edit').style.display="block";
        }
    </script>
</body>
</html>