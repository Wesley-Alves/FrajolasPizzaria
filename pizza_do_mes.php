<?php
    require_once("model/pizza_do_mes.php");
    require_once("database/pizza_do_mes_dao.php");
    $pizzaDoMesDao = new PizzaDoMesDAO();
    $pizzaDoMes = $pizzaDoMesDao->getPizzaDoMes(true);
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
            <h1 id="titulo_pagina">Pizza do Mês</h1>
            <div id="container_pizza_do_mes">
                <?php foreach ($pizzaDoMes as $pizzaDoMesItem) { ?>
                    <div class="pizza_do_mes">
                        <p class="titulo"><?php echo $pizzaDoMesItem->getTitulo(); ?></p>
                        <div class="conteudo">
                            <div class="galeria clearfix">
                                <?php if (!empty($pizzaDoMesItem->getImagem2()) || !empty($pizzaDoMesItem->getImagem3())) { ?>
                                    <img class="imagem" src="imagens/pizza_do_mes/<?php echo $pizzaDoMesItem->getImagemPrincipal(); ?>">
                                    <div class="thumbnail">
                                        <a href="#" class="ativo"><img src="imagens/pizza_do_mes/<?php echo $pizzaDoMesItem->getImagemPrincipal(); ?>"></a>
                                        <?php if (!empty($pizzaDoMesItem->getImagem2())) { ?>
                                            <a href="#"><img src="imagens/pizza_do_mes/<?php echo $pizzaDoMesItem->getImagem2(); ?>"></a>
                                        <?php } ?>
                                        <?php if (!empty($pizzaDoMesItem->getImagem3())) { ?>
                                            <a href="#"><img src="imagens/pizza_do_mes/<?php echo $pizzaDoMesItem->getImagem3(); ?>"></a>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <img class="imagem nothumbnail" src="imagens/pizza_do_mes/<?php echo $pizzaDoMesItem->getImagemPrincipal(); ?>">
                                <?php } ?>
                            </div>
                            <p><?php echo $pizzaDoMesItem->getTexto(); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php include "view/footer.php" ?>
    </body>
</html>