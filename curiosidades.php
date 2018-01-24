<?php
    require_once("model/curiosidade.php");
    require_once("database/curiosidade_dao.php");
    $curiosidadeDao = new CuriosidadeDAO();
    $curiosidades = $curiosidadeDao->getCuriosidades(true);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Frajola's Pizzaria</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" type="image/png" href="imagens/icones/favicon.png">
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/parallax.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body>
        <?php include "view/header.php" ?>
        <div id="main">
            <noscript>
                <p id="sem_javascript">O JavaScript não é suportado por seu navegador ou foi desativado. Para o funcionamento do site, é necessário que ative-o.</p>
            </noscript>
            <div id="redes_sociais" class="margem">
                <a href="http://www.facebook.com" target="_blank" class="rede_social facebook" title="Facebook"></a>
                <a href="http://www.instagram.com" target="_blank" class="rede_social instagram" title="Instagram"></a>
                <a href="http://www.twitter.com" target="_blank" class="rede_social twitter" title="Twitter"></a>
            </div>
            <?php
                $decada = "";
                foreach ($curiosidades as $curiosidade) {
                    if ($curiosidade->getDecada() != $decada) {
                        $decada = $curiosidade->getDecada();
                        echo "<h1 class=\"titulo-decada\">Anos $decada</h1>";
                    }
            ?>
                    <div class="curiosidade" data-parallax="scroll" data-image-src="imagens/curiosidades/<?php echo $curiosidade->getImagem(); ?>" data-z-index="1" data-mirror-container="#main">
                        <div class="texto">
                            <h1><?php echo $curiosidade->getTitulo(); ?></h1>
                            <p><?php echo $curiosidade->getTexto(); ?></p>
                        </div>
                    </div>
            <?php 
                }
            ?>
        </div>
        <?php include "view/footer.php" ?>
    </body>
</html>