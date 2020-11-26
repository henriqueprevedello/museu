<?php
require_once '../conecta.php';

$queryFuncionario = $PDO->prepare("SELECT * FROM tb_funcionario");
$queryFuncionario->execute();
$funcionarios = $queryFuncionario->fetchAll(PDO::FETCH_ASSOC);

include 'header_login.php' ?>

<header>
    <div class="row">
        <div class="col-sm-12" style="margin: 20px 0;">
            <h2 style="text-align: center; ">ADMINISTRADOR MUSEU</h2>
            <h3 style="text-align: center; ">Login</h3>
        </div>
    </div>
</header>

<form action="validaLogin.php" enctype="multipart/form-data" method="post">

    <div class="row">

        <div class="form-group col-md-12">
            <select class="form-control" name="cd_funcionario">
                <option value=''>Selecione o funcionário</option>
                <?php
                foreach ($funcionarios as &$funcionario) {

                    echo "<option value='" . $funcionario['id_funcionario'] . "' >" . $funcionario['tx_nome'] . "</option>";
                }
                ?>
            </select>
        </div>

    </div>

    <div class="row">

        <div class="form-group col-md-12">
            <input type="password" class="form-control" placeholder="Senha instituição" name="tx_senha">
        </div>

    </div>

    <div class="row">

        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-success">Login</button>
        </div>

    </div>

</form>


<?php include 'footer.php' ?>