<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
<header>
<a href="index.php">Alium</a></header>

<h1>Já tem uma conta?</h1>
<h3>Que bom que você já faz parte do nosso time ;)</h3>
<form action="Conectar.php">
    <input type="submit" value="Conectar" />
</form>

<h2>Registrar</h2>
<label for="CPF/CNPJ">CPF/CNPJ:</label><br>
  <input type="text" id="CPF/CNPJ" name="CPF/CNPJ" value=""><br>
  <label for="Nome">Nome:</label><br>
  <input type="text" id="Nome" name="Nome" value=""><br>
  <label for="Email">Email:</label><br>
  <input type="text" id="Email" name="Email" value=""><br>
  <label for="Telefone">Telefone:</label><br>
  <input type="text" id="telefone" name="telefone" value=""><br>
  <label for="Senha">Senha:</label><br>
  <input type="password" id="Senha" name="Senha" value=""><br>
  <label for="RSenha">Repetir a Senha:</label><br>
  <input type="password" id="RSenha" name="RSenha" value=""><br>
  <label for="cep">CEP:</label><br>
  <input type="text" id="cep" name="cep" value=""><br>
  <input type="checkbox" id="servico" name="servico" value="">
  <label for="servico"> Prestador de Serviço</label><br>

  <br>
  <input type="submit" value="Cadastrar">

    <footer>Alium - todos os direitos reservados</footer>
</body>
</html>