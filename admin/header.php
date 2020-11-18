<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Museu</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }

        body {
            padding-bottom: 20px;
        }

        .imgProduto {
            max-height: 32px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><strong>ADMIN MUSEU</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="objeto.php">Objetos</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="espaco.php">Espaços</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="categoria.php">Categorias</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="acervo.php">Acervo</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="instituicao.php">Instituição</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="visita.php">Visitas</a>
                </li>
            </ul>

            <a type="button" href="../index.php" class="btn btn-secondary ml-2">Área do vísitante</a>
        </div>
    </nav>

    <main class="container">