<?php require '../conecta.php';

$id_objeto = isset($_GET['id_objeto']) ? $_GET['id_objeto'] : null;

$queryObjeto = $PDO->prepare("SELECT * FROM tb_objeto WHERE id_objeto=" . $id_objeto);
$queryObjeto->execute();
$objeto = $queryObjeto->fetchObject();

$queryEspaco = $PDO->prepare("SELECT * FROM tb_espaco");
$queryEspaco->execute();
$espacos = $queryEspaco->fetchAll(PDO::FETCH_ASSOC);

$queryCategoria = $PDO->prepare("SELECT * FROM tb_categoria");
$queryCategoria->execute();
$categorias = $queryCategoria->fetchAll(PDO::FETCH_ASSOC);

$anexoSql = "SELECT * FROM tb_anexo WHERE cd_objeto =" . $id_objeto;
$queryAnexo = $PDO->prepare($anexoSql);
$queryAnexo->execute();

$anexos = $queryAnexo->fetchAll(PDO::FETCH_ASSOC);

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
  if (empty($objeto->cd_status)) {
    if(  $status == ''){
      return "selected=selected";

    }
    return "";
  }

  return ( $objeto->cd_status == $status) ?  "selected=selected" :  "";
}

function adquirirDataAtual()
{
  return date("Y-m-d");
}

function adquirirExtensaoArquivo($nomeArquivo)
{

  return end(explode(".", $nomeArquivo));
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
    <label for="example-date-input" class="col-12 col-form-label">Data de fabricação do objeto:</label>
  </div>

  <div class="row">
    <div class="form-group col-12">
      <input type="date" class="form-control" name="dt_criacao" value="<?= ($id_objeto != null) ? $objeto->dt_criacao : adquirirDataAtual() ?>">
    </div>
  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <select class="form-control" name="cd_status">
        <option value='' <?php echo statusSelecionado($objeto, '') ?>>Selecione o status</option>
        <option value='1' <?php echo statusSelecionado($objeto, 1) ?>>Exposição</option>
        <option value='2' <?php echo statusSelecionado($objeto, 2) ?>>Manutenção</option>
        <option value='3' <?php echo statusSelecionado($objeto, 3) ?>>Repouso</option>
      </select>
    </div>

  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <select class="form-control" name="cd_categoria">
        <option value=''>Selecione a categoria</option>
        <?php
        foreach ($categorias as &$categoria) {

          echo "<option value='" . $categoria['id_categoria'] . "' " . categoriaSelecionada($objeto->cd_categoria, $categoria) . ">" . $categoria['tx_nome'] . "</option>";
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

          echo "<option value='" . $espaco['id_espaco'] . "' " . espacoSelecionado($objeto->cd_espaco, $espaco) . ">" . $espaco['tx_descricao'] . "</option>";
        }
        ?>
      </select>
    </div>

  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <label for="exampleInputFile">Adicione arquivos</label>
      <input multiple type="file" name="inputArquivos[]" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
    </div>

  </div>

  <div class="row">

    <?php
    foreach ($anexos as &$anexo) {
      echo '<div class="card" style="justify-content: center;">';
      if (strpos(strtolower($anexo['tx_nome']), ".jpg") || strpos(strtolower($anexo['tx_nome']), ".jpeg") || strpos(strtolower($anexo['tx_nome']), ".png")) {
        echo '<img class="card-img-top" src="../uploadFiles/' . $anexo['tx_nome'] . '" style="width: 18rem;">';
      } else if (strpos(strtolower($anexo['tx_nome']), ".mp4")) {
        echo '<video width="320" height="240" controls style="width: 18rem;">
                <source src="../uploadFiles/' . $anexo['tx_nome'] . '" type="video/mp4">
              </video>';
      } else if (strpos(strtolower($anexo['tx_nome']), ".mp3")) {
        echo '<audio controls>
                <source src="../uploadFiles/' . $anexo['tx_nome'] . '" type="audio/mp3">
              </audio>';
      } else {
        echo '<div class="card-body">
                
                <object data="../uploadFiles/"' . $anexo['tx_nome'] . ' type="application/';
        echo adquirirExtensaoArquivo($anexo['tx_nome']);
        echo '" width="300" height="200">
                        <a href="../uploadFiles/' . $anexo['tx_nome'] . '">' . $anexo['tx_nome'] . '</a>
                      </object>
                    </div>
        ';
      }
      echo "</div>";
    }
    ?>

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