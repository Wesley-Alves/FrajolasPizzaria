<?php
    require_once("model/sobre_nos.php");
    require_once("database/sobre_nos_dao.php");
    $sobreNosDao = new SobreNosDAO();
    $sobreNos = $sobreNosDao->getSobreNos(true);
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
            <h1 id="titulo_pagina">Sobre a Pizzaria</h1>
            <?php foreach ($sobreNos as $sobreNosItem) { ?>
                <div class="sobre_nos clearfix">
                    <div class="titulo"><?php echo $sobreNosItem->getTitulo(); ?></div>
                    <div class="conteudo clearfix">
                        <img src="imagens/sobre_nos/<?php echo $sobreNosItem->getImagem(); ?>">
                        <p><?php echo $sobreNosItem->getTexto(); ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php include "view/footer.php" ?>
    </body>
</html>