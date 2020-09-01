<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Obter postagens Instagram</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="style.css" rel="stylesheet">
    </head>

    <body class="text-center">
        <form class="form-signin" method="POST" action="obter-postagens.php">
            <img class="mb-4" src="media/icon-download.svg" alt="" width="200" height="160">
            <h1 class="h3 mb-3 font-weight-normal">Obter postagens do Instagram</h1>
            
            <input type="text" id="insta" name="insta" class="form-control" placeholder="Nome do usuário" required autofocus>
            <input type="number" id="qtdPosts" name="qtdPosts" class="form-control" placeholder="Quantidade de postagens" required>

            <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Obter posts</button>
        </form>
    </body>
</html>
