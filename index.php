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
  <header class="menu">
    <div class="overlay-content">
      <div class="menu-container">
        <a href="#" class="menu-logo"><img src="images/icons/logo.svg" alt=""></a>
        <nav class="menu-nav">
          <ul>
            <?php if(isset($_SESSION['user'])):?>
              <!-- <li><a>Bem-vindo(a), </a></li> -->
              <li><a href="profile.php"><?= $_SESSION['logged-user']?></a></li>
              <li><a href="logout.php" class="text-color-yellow">Sair</a></li>
            <?php else :?>
              <li><a href="signup.php">Registrar-se</a></li>
              <li><a href="signin.php">Entrar</a></li>
            <?php endif;?>
          </ul>
        </nav>
      </div>
      <div class="menu-content-container">
        <p class='title'>ALIUM, Encontre o seu cliente <br>ou prestador de serviços.</p>
        <p class='subtitle'>Ser contratado/contratar nunca foi tão fácil.</p>
        <form action="searching.php" id="formSearch" method="post">
          <input type="text" class="inputBox" name="search" placeholder="Procurar Profissional ou trabalho..."  oninput=procurar(this.value)>
          <button type="submit"  class="inputButton">PROCURAR</button>
        </form>
        <ul class='listSearch'>
         
        </ul>
      </div>
    </div>
  </header>
  <div class="container">

    <section class="category">
      <p class="titleCategory">Mais Procurados</p>
      <div class="category-icons">
        <ul>
          <li><a href="provider_list.php?work=marceneiro"><img src="images/icons/serrote.svg" alt=""></a></li>
          <li><a href="provider_list.php?work=mecânico"><img src="images/icons/mechanic.svg" alt=""> </a></li>
          <li><a href="provider_list.php?work=pintor"><img src="images/icons/pinter.svg" alt=""></a></li>
        </ul>
      </div>
    </section>
    <section class="info">
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
    </section>
    <section class="feedback-container">
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
    </section>
    <section class="contact">
      <div class="contact-container">
        <div class="contact-form">
          <form>
            <label for="Nome">Nome:</label><br>
            <input type="text" id="Nome" name="Nome" value=""><br>
            <label for="Email">Email:</label><br>
            <input type="text" id="Email" name="Email" value=""><br><br>
            <label for="message">Mensagem:</label><br>
            <textarea name="" id="message" cols="30" rows="10"></textarea>
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
    fetch('search.php',{
      method:   'POST',
      body: new URLSearchParams('search='+value)
    })
      .then(res=> res.json())
      .then(res=>showFetchResults(res))
      .catch(e => console.error('Error:'+ e))
  }function showFetchResults(value){
    const dataContainer = document.querySelector('.listSearch');
    dataContainer.style.display="block";
    dataContainer.innerHTML = "";
    for(let i = 0; i <value.length;i++){
      const li = document.createElement("li");
      li.innerHTML = value[i]['service'];
      dataContainer.appendChild(li);
      li.onclick = function (){
        document.querySelector('.inputBox').value = this.innerHTML;
        document.querySelector('#formSearch').submit();
      }

    }
    
  }
  </script>
</body>

</html>