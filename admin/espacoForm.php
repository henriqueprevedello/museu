<?php
require '../conecta.php';

$id_espaco = isset($_GET['id_espaco']) ? $_GET['id_espaco'] : null;

$countSql = "SELECT * FROM tb_espaco WHERE id_espaco=" . $id_espaco;
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$espaco = $qryCount->fetchObject();

$acervoSql = "SELECT * FROM tb_acervo";
$queryAcervo = $PDO->prepare($acervoSql);
$queryAcervo->execute();

$acervos = $queryAcervo->fetchAll(PDO::FETCH_ASSOC);

function acervoSelecionado($cd_acervo, $espaco)
{
  return $cd_acervo == $espaco->cd_acervo ?  "selected=selected" :  "";
}

if ($acervos == 0) {

  header('Location: acervo.php');

  exit;
}

include 'header.php';
?>

<header>
  <div class="row">
    <div class="col-sm-12" style="margin: 20px 0;">
      <?= ($id_espaco != null) ? '<h2 style="text-align: center; ">Editar Espaço</h2>' : '<h2 style="text-align: center; ">Novo Espaço</h2>' ?>
    </div>
  </div>
</header>

<form action="addEspaco.php" enctype="multipart/form-data" method="post">

  <?= ($id_espaco != null) ? '<input type="hidden" name="id_espaco" value="' . $espaco->id_espaco . '">' : "" ?>

  <div class="row">

    <div class="form-group col-md-12">
      <input type="text" class="form-control" placeholder="Descrição" name="tx_descricao" value="<?= ($id_espaco != null) ? $espaco->tx_descricao : "" ?>">
    </div>

  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <select class="form-control" name="cd_acervo">
        <option value=''>Selecione o acervo</option>
        <?php
        foreach ($acervos as &$acervo) {

          echo "<option value='" . $acervo['id_acervo'] . "' " . acervoSelecionado($acervo['id_acervo'], $espaco) . ">" . $acervo['tx_descricao'] . "</option>";
        }
        ?>
      </select>
    </div>

  </div>

  <div class="row">

    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-success">Salvar</button>
      <a href="espaco.php" class="btn btn-secondary">Cancelar</a>
    </div>

  </div>

</form>

<?php
include 'footer.php'
?>