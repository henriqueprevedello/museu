<?php

$cd_funcionario = isset($_POST['cd_funcionario']) ? $_POST['cd_funcionario'] : null;
$tx_senha = isset($_POST['tx_senha']) ? $_POST['tx_senha'] : null;

require_once './header_login.php';

if (empty($cd_funcionario) || empty($tx_senha)) {
?>

	<br><br><br><br><br>
	<h2 style="text-align: center; color: red;">Preencha todos os campos</h2>
	<br>
	<div class="row">
		<a type="button" href="./index.php" class="btn large btn-danger" style="width: 100%">Tentar novamente</a>
	</div>
<?php
	exit;
}

if ($tx_senha == "12345") {
	header('Location: objeto.php');
} else {
?>
	<br><br><br><br><br>
	<h1 style="text-align: center; color: red;">Senha incorreta</h1>
	<br>
	<div class="row">
		<a type="button" href="./index.php" class="btn large btn-danger" style="width: 100%">Tentar novamente</a>
	</div>

<?php
	exit;
}
