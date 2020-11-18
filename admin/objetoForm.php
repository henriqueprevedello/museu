<?php
require '../conecta.php';

$id_objeto = isset($_GET['id_objeto']) ? $_GET['id_objeto'] : null;
$cd_espaco = isset($_GET['cd_espaco']) ? $_GET['cd_espaco'] : null;
$countSql = "SELECT * FROM tb_objeto WHERE id_objeto=" . $id_objeto;
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$objeto = $qryCount->fetchObject();

$espacoSql = "SELECT * FROM tb_espaco WHERE id_espaco NOT IN (SELECT cd_espaco FROM tb_objeto)";
$queryEspaco = $PDO->prepare($espacoSql);
$queryEspaco->execute();

$espacos = $queryEspaco->fetchAll(PDO::FETCH_ASSOC);

$categoriaSql = "SELECT * FROM tb_categoria";
$queryCategoria = $PDO->prepare($categoriaSql);
$queryCategoria->execute();

$categorias = $queryCategoria->fetchAll(PDO::FETCH_ASSOC);

function espacoSelecionado($cd_espaco, $espaco)
{
  return $cd_espaco == $espaco['id_espaco'] ?  "selected=selected" :  "";
}

function categoriaSelecionada($cd_categoria, $categoria)
{
  return $cd_categoria == $categoria['id_categoria'] ?  "selected=selected" :  "";
}

function statusSelecionado($objeto, $status)
{
  if (empty($objeto) &&  $status == '') {
    return "selected=selected";
  }

  return empty($cd_status) || $cd_status == $status ?  "selected=selected" :  "";
}

function adquirirDataAtual()
{
  return date("Y-m-d");
}

if ($espacos == 0) {

  header('Location: espaco.php');

  exit;
}


if ($categorias == 0) {

  header('Location: categoria.php');

  exit;
}

include 'header.php';
?>

<header>
  <div class="row">
    <div class="col-sm-12" style="margin: 20px 0;">
      <?= ($id_objeto != null) ? '<h2 style="text-align: center; ">Editar objeto</h2>' : '<h2 style="text-align: center; ">Novo objeto</h2>' ?>
    </div>
  </div>
</header>

<form action="addObjeto.php" enctype="multipart/form-data" method="post">

  <?= ($id_objeto != null) ? '<input type="hidden" name="id_objeto" value="' . $objeto->id_objeto . '">' : "" ?>

  <div class="row">

    <div class="form-group col-md-12">
      <input type="text" class="form-control" placeholder="Nome" name="tx_nome" value="<?= ($id_objeto != null) ? $objeto->tx_nome : "" ?>">
    </div>

  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <input type="text" class="form-control" placeholder="Descrição" name="tx_descricao" value="<?= ($id_objeto != null) ? $objeto->tx_descricao : "" ?>">
    </div>

  </div>

  <div class="row">
    <label for="example-date-input" class="col-3 col-form-label">Data de fabricação do objeto:</label>
  </div>

  <div class="row">
    <div class="form-group col-12">
      <input type="date" class="form-control" name="dt_criacao" value="<?= ($id_objeto != null) ? $objeto->dt_criacao : adquirirDataAtual() ?>">
    </div>
  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <select class="form-control" name="cd_status">
        <option value='' <?php statusSelecionado($objeto, '') ?>>Selecione o status</option>
        <option value='1' <?php statusSelecionado($objeto, 1) ?>>Exposição</option>
        <option value='2' <?php statusSelecionado($objeto, 2) ?>>Manutenção</option>
      </select>
    </div>

  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <select class="form-control" name="cd_categoria">
        <option value=''>Selecione a categoria</option>
        <?php
        foreach ($categorias as &$categoria) {

          echo "<option value='" . $categoria['id_categoria'] . "' " . categoriaSelecionada($cd_categoria, $categoria) . ">" . $categoria['tx_nome'] . "</option>";
        }
        ?>
      </select>
    </div>

  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <select class="form-control" name="cd_espaco">
        <option value=''>Selecione o espaço</option>
        <?php
        foreach ($espacos as &$espaco) {

          echo "<option value='" . $espaco['id_espaco'] . "' " . espacoSelecionado($cd_espaco, $espaco) . ">" . $espaco['tx_descricao'] . "</option>";
        }
        ?>
      </select>
    </div>

  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <label for="exampleInputFile">File input</label>
      <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
      <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input.</small>
    </div>

  </div>

  <div class="row">

    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-success">Salvar</button>
      <a href="objeto.php" class="btn btn-secondary">Cancelar</a>
    </div>

  </div>

</form>

<?php
include 'footer.php'
?>