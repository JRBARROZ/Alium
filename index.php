<?php require_once('init.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Alium</title>
</head>

<body>
  <?php if (isset($_SESSION['work'])) : ?>
    <div class="modal-index">
      <div class="modal-content">
        <div class="modal-header">
          <div></div>
          <p>Equipe Alium Alerta</p>
          <span id="close-modal" onclick="closeModal()">X</span>
        </div>
        <div class="modal-body">
          <h2>Erro</h2>
          <p>Ninguém está prestando o serviço : <span><?= $_SESSION['work'] ?><span></p>
        </div>
      </div>
    </div>
    <?php unset($_SESSION['work']) ?>
  <?php endif ?>
  <?php if (isset($_SESSION['feedback_sended'])) : ?>
    <div class="modal-index">
      <div class="modal-content">
        <div class="modal-header">
          <div></div>
          <p>Equipe Alium Alerta</p>
          <span id="close-modal" onclick="closeModal()">X</span>
        </div>
        <div class="modal-body">
          <h2>Sucesso</h2>
          <p>Sua mensagem foi enviada com sucesso. Agradecemos o seu feedback e daremos um retorno o quanto antes.<span></p>
        </div>
      </div>
    </div>
    <?php unset($_SESSION['feedback_sended']) ?>
  <?php endif ?>
  <?php if (isset($_SESSION['userNotFound'])) : ?>
    <div class="modal-index">
      <div class="modal-content">
        <div class="modal-header">
          <div></div>
          <p>Equipe Alium Alerta</p>
          <span id="close-modal" onclick="closeModal()">X</span>
        </div>
        <div class="modal-body">
          <h2>Erro</h2>
          <p>Não foi encontrado nenhum prestador chamado : <span><?= $_SESSION['userNotFound'] ?><span></p>
        </div>
      </div>
    </div>
    <?php unset($_SESSION['userNotFound']) ?>
  <?php endif ?>
  <header class="menu">
    <div class="overlay-content">
      <div class="menu-container">
        <a href="#" class="menu-logo"><img src="images/icons/logo.svg" alt=""></a>
        <nav class="menu-nav">
          <ul>
            <?php if (isset($_SESSION['user'])) : ?>
              <!-- <li><a>Bem-vindo(a), </a></li> -->
              <li><a href="profile.php"><?= $_SESSION['logged-user'] ?></a></li>
              <li><a href="logout.php" class="text-color-yellow">Sair</a></li>
            <?php else : ?>
              <li><a href="signup.php">Registrar-se</a></li>
              <li><a href="signin.php">Entrar</a></li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>
      <div class="menu-content-container">
        <p class='title'>ALIUM, Encontre o seu cliente <br>ou prestador de serviços.</p>
        <p class='subtitle'>Ser contratado/contratar nunca foi tão fácil.</p>
        <input type="checkbox" id="checkbox" onclick="showUsersForm()">
        <label class='subtitle' for="checkbox">Procurar prestadores de serviço</label><br>
        <form action="searching.php" id="formSearch" method="post">
          <input type="text" class="inputBox" name="search" autocomplete="off" placeholder="Procurar Trabalho..." oninput=procurar(this.value)>
          <button type="submit" class="inputButton">PROCURAR</button>
        </form>
        <ul class='listSearch'>
        </ul>
        <form action="worker_profile.php" id="searchUsers" method="post">
          <input type="text" class="userSearchBox" name="searchUser" autocomplete="off" placeholder="Procurar Profissional..." oninput=procurarUsuarios(this.value)>
          <input type="hidden" name="id" id="userSearchId" value="">
          <button type="submit" class="inputButton">PROCURAR</button>
        </form>
        <ul class='userListSearch'>
        </ul>
      </div>
    </div>
  </header>
  <div class="container">

    <section class="category">
      <h2 class="titleCategory">Mais Procurados</h1>
        <div class="category-icons">
          <ul>
            <li><a href="provider_list.php?work=marceneiro"><img src="images/icons/serrote.svg" alt=""></a></li>
            <li><a href="provider_list.php?work=mecânico"><img src="images/icons/mechanic.svg" alt=""> </a></li>
            <li><a href="provider_list.php?work=pintor"><img src="images/icons/pinter.svg" alt=""></a></li>
          </ul>
        </div>
    </section>
    <!-- <section class="info">
      <div class="info-container">
        <div class="info-item">
          <img src="images/backgrounds/slide_1.png" alt="" class="slide">
          <ul>
            <li>
              <img src="images/icons/active_people.svg" alt="">
              <p>8048 Pessoas Ativas</p>
            </li>
            <li>
              <img src="images/icons/finished_projects.svg" alt="">
              <p>2895 Projetos Concluídos</p>
            </li>
            <li>
              <img src="images/icons/launched_budgets.svg" alt="">
              <p>3625 Orçamentos lançados</p>
            </li>
            <li>
              <img src="images/icons/rating.svg" alt="">
              <p>5.0 / 5.0 Avaliações</p>
            </li>
          </ul>
        </div>
      </div>
    </section> -->
    <!-- <section class="feedback-container">
      <div class="feedback-title">
        <p>Feedbacks</p>
      </div>
      <div class="feedback-subtitle">
        <p>" Estou muito feliz com o resultado "</p>
      </div>
      <div class="feedback-username">
        <p>- Barry Allen</p>
      </div>
      <div class="feedback-rating">
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
      </div>
    </section> -->
    <section class="contact">
      <div class="contact-container">
        <div class="contact-form">
          <form action="contact_us.php" method="post">
            <label for="name">Nome:</label><br>
            <input type="text" id="name" name="name" value=""><br>
            <?php if (isLogged()): ?>
              <input type="hidden" name="email" value="<?= $_SESSION['user']['email'] ?>">
            <?php else: ?>
              <label for="email">E-mail:</label><br>
              <input type="text" id="email" name="email" value=""><br>
            <?php endif ?>
            <label for="assunto">Assunto:</label><br>
            <input type="text" id="assunto" name="assunto" value=""><br>
            <label for="message">Mensagem:</label><br>
            <textarea name="message" id="message" cols="30" rows="10"></textarea>
            <br>
            <input type="submit" value="Enviar">
          </form>
        </div>
        <div class="contact-information">
          <p>Dúvidas,elogios,reclamações,</p>
          <p>críticas ou sugestões, entre em</p>
          <p>contato conosco,gostaríamos de</p>
          <p>ouvir o que você tem a dizer. :)</p>
          <br>
          <p>- Atenciosamente,equipe ALIUM.</p>
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
    function procurar(value) {
      fetch('search.php', {
          method: 'POST',
          body: new URLSearchParams('search=' + value)
        })
        .then(res => res.json())
        .then(res => showFetchResults(res))
        .catch(e => console.error('Error:' + e))
    }

    function showFetchResults(value) {
      const dataContainer = document.querySelector('.listSearch');
      dataContainer.style.display = "block";
      dataContainer.innerHTML = "";
      for (let i = 0; i < value.length; i++) {
        const li = document.createElement("li");
        li.innerHTML = value[i]['service'];
        dataContainer.appendChild(li);
        li.onclick = function() {
          document.querySelector('.inputBox').value = this.innerHTML;
          document.querySelector('#formSearch').submit();
        }

      }

    }

    function procurarUsuarios(value) {
      fetch('search_users.php', {
          method: 'POST',
          body: new URLSearchParams('searchUser=' + value)
        })
        .then(res => res.json())
        .then(res => showUsers(res))
        .catch(e => console.error('Error:' + e))

    }

    function showUsers(value) {
      const userContainer = document.querySelector('.userListSearch');
      userContainer.style.display = "block";
      userContainer.innerHTML = "";
      for (let i = 0; i < value.length; i++) {
        const li = document.createElement("li");
        li.innerHTML = value[i]['name'];
        userContainer.appendChild(li);
        li.onclick = function() {
          document.querySelector('.userSearchBox').value = this.innerHTML;
          document.querySelector('#userSearchId').value = value[i]['id'];
          document.querySelector('#searchUsers').submit();
        }

      }

    }

    function showUsersForm() {
      const checkbox = document.querySelector('#checkbox');
      const searchUsersForm = document.querySelector('#searchUsers');
      const searchForm = document.querySelector('#formSearch');
      const dataContainer = document.querySelector('.listSearch');
      const userContainer = document.querySelector('.userListSearch');

      if (checkbox.checked == true) {
        searchUsersForm.style.display = "block";
        searchForm.style.display = "none";
        dataContainer.style.display = "none";
        searchUsersForm[0].value = searchForm[0].value;
      } else if (checkbox.checked == false) {
        searchForm.style.display = "block";
        searchUsersForm.style.display = "none";
        dataContainer.style.display = "block";
        userContainer.style.display = "none";
        searchForm[0].value = searchUsersForm[0].value;

      }
    }
    //Modal
    const body = document.querySelector("body");
    const modal = document.querySelector('.modal-index');
    if (modal == null) {
      body.style.overflowY = "scroll";
    } else {
      body.style.overflowY = "hidden";
    }
    // body.style.overflowY = "scroll";
    function closeModal() {
      // const body = document.querySelector("body");
      body.style.overflowY = "scroll";
      modal.style.display = "none";
      // console.log(element);
    }
  </script>
</body>

</html>