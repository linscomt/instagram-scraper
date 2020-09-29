<?php
require __DIR__ . '/vendor/autoload.php';
require './objetos.php';
session_start();

if (!isset($_POST["insta"])) {
    header('Location: ./');
}

$username = str_replace("@", "", $_POST["insta"]);
//$qtdPosts = $_POST["qtdPosts"];
$qtdPosts = 450;

// If account is public you can query Instagram without auth
$instagram = new \InstagramScraper\Instagram();
$medias = $instagram->getMedias($username, $qtdPosts);

$ultimaData = new DateTime();
$ultimaData->setTimestamp($medias[count($medias) - 1]->getCreatedTime());

$dataInicio = new DateTime();
$dataInicio->setTimestamp(1583020800);

$dataFim = new DateTime();
$dataFim->setTimestamp(1598832000);

if ($dataInicio < $ultimaData) {
    $qtdPosts = $qtdPosts + 100;
    $instagram = new \InstagramScraper\Instagram();
    $medias = $instagram->getMedias($username, $qtdPosts);
}

// If account private you should be subscribed and after auth it will be available
//$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', 'path/to/cache/folder');
//$instagram->login();
//$medias = $instagram->getMedias('private_account', 100);

function get_hashtags($string, $str = 1) {
    preg_match_all('/#(\w+)/', $string, $matches);
    $keywords = "";
    $i = 0;
    if ($str) {
        foreach ($matches[1] as $match) {
            $count = count($matches[1]);
            $keywords .= "$match";
            $i++;
            if ($count > $i)
                $keywords .= ", ";
        }
    } else {
        foreach ($matches[1] as $match) {
            $keyword[] = $match;
        }
        $keywords = $keyword;
    }
    return $keywords;
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../../../favicon.ico">

        <title>Resultado da extração de postagens do Instagram</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- Custom styles for this template -->
        <link href="media/grid.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">

            <h1>Resultado da extração de postagens do Instagram</h1>
            <p class="lead">Extração de postagens da conta <strong>@<?= $username ?></strong> </p>
            <a href="./exportarCSV.php">Exportar para CSV</a>

            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Preview</th>
                                <th scope="col">Mídia</th>
                                <th scope="col">Data</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Curtidas</th>
                                <th scope="col">Comentários</th>
                                <th scope="col">Hashtags</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $listaPosts = array();
                            $username = '"' . $username . '"';
                            $contPost = 0;
                            for ($i = 0; $i < count($medias); $i++) {
                                $date = new DateTime();
                                $date->setTimestamp($medias[$i]->getCreatedTime());

                                $dataInicio = new DateTime();
                                $dataInicio->setTimestamp(1583020800);

                                $dataFim = new DateTime();
                                $dataFim->setTimestamp(1598832000);

                                if ($dataInicio <= $date) {
                                    if ($dataFim >= $date) {
                                        ?>

                                        <tr>
                                            <th scope="row"><?= $contPost = $contPost + 1 ?></th>
                                            <td> <a href="<?= $medias[$i]->getLink() ?>"><img src="<?= $medias[$i]->getImageHighResolutionUrl() ?>" width="100" height="100"></a></td>
                                            <td><?= $medias[$i]->getType() ?></td>
                                            <td><?= date('d/m/Y', $medias[$i]->getCreatedTime()) ?></td>
                                            <td><?= $medias[$i]->getCaption() ?></td>
                                            <td><?= $medias[$i]->getLikesCount() ?></td>
                                            <td><?= $medias[$i]->getCommentsCount() ?></td>
                                            <td><?= get_hashtags($medias[$i]->getCaption()) ?></td>
                                        </tr>
                                        <?php
                                        $descricao = $medias[$i]->getCaption();
                                        $descricao = str_replace("\n", "", $descricao);
                                        $descricao = str_replace("\r", "", $descricao);
                                        $descricao = str_replace("'", "", $descricao);
                                        $descricao = utf8_decode($descricao);
                                        $hastags = get_hashtags($medias[$i]->getCaption());
                                        $data = date('d/m/Y', $medias[$i]->getCreatedTime());

                                        $postagem = array($username, $descricao, $hastags, $data, $medias[$i]->getLikesCount());

                                        array_push($listaPosts, $postagem);
                                    }
                                }
                            }


                            $_SESSION["postagens"] = $listaPosts;
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div> <!-- /container -->
    </body>
</html>
