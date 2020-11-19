<?php require './conecta.php';

function acervoSelecionado($cd_acervo, $acervo)
{
  return $cd_acervo == $acervo['id_acervo'] ?  "selected=selected" :  "";
}

$queryAcervo = $PDO->prepare("SELECT * FROM tb_acervo");
$queryAcervo->execute();
$acervos = $queryAcervo->fetchAll(PDO::FETCH_ASSOC);

if ($acervos == 0) {

  echo "Não há acervos cadastrados para visita!";

  exit;
}

include 'header.php';
?>

<header>
  <div class="row">
    <div class="col-sm-12" style="margin: 50px 0;">
      <h2 style="text-align: center; ">Check-in de visitante</h2>
    </div>
  </div>
</header>

<form action="addCheckin.php" enctype="multipart/form-data" method="post">

  <div class="row">

    <div class="form-group col-md-12">
      <input type="text" class="form-control" placeholder="Nome" name="tx_nome">
    </div>

  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <input type="number" class="form-control" placeholder="Idade" name="nr_idade">
    </div>

  </div>

  <div class="row">

    <div class="form-group col-md-12">
      <select class="form-control" name="cd_acervo">
        <option value=''>Selecione o acervo</option>
        <?php foreach ($acervos as &$acervo) {
          echo "<option value='" . $acervo['id_acervo'] . "' " . acervoSelecionado($cd_acervo, $acervo) . ">" . $acervo['tx_descricao'] . "</option>";
        } ?>
      </select>
    </div>

  </div>

  <div class="row">
    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-success">Registrar visita</button>
    </div>
  </div>

</form>

<?php include 'footer.php' ?>