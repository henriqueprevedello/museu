<?php
require '../conecta.php';

$id_acervo = isset($_GET['id_acervo']) ? $_GET['id_acervo'] : null;
$countSql = "SELECT * FROM tb_acervo WHERE id_acervo=" . $id_acervo;
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$acervo = $qryCount->fetchObject();

include 'header.php';
?>

<header>
  <div class="row">
    <div class="col-sm-12" style="margin: 20px 0;">
      <?= ($id_acervo != null) ? '<h2 style="text-align: center; ">Editar Acervo</h2>' : '<h2 style="text-align: center; ">Novo Acervo</h2>' ?>
    </div>
  </div>
</header>

<form action="addAcervo.php" enctype="multipart/form-data" method="post">
  <?= ($id_acervo != null) ? '<input type="hidden" name="id_acervo" value="' . $acervo->id_acervo . '">' : "" ?>
  <div class="row">
    <div class="form-group col-md-12">
      <input type="text" class="form-control" placeholder="Descrição" name="tx_descricao" value="<?= ($id_acervo != null) ? $acervo->tx_descricao : "" ?>">
    </div>
    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-success">Salvar</button>
      <a href="acervo.php" class="btn btn-secondary">Cancelar</a>
    </div>
  </div>
</form>
<?php
include 'footer.php'
?>