<?php
    require_once("../util/sessao.php");
    require_once("../controller/pizza_do_mes_controller.php");

    $usuario = $_SESSION["usuario"];
    if (!$usuario->getPermConteudo()) {
        header("location:index.php");
        exit();
    }

    $pizzaDoMesDao = new PizzaDoMesDAO();
    $pizzaDoMes = $pizzaDoMesDao->getPizzaDoMes(false);
    $pizzaDoMesController = new PizzaDoMesController();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>CMS | Frajola's Pizzaria</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style_cms.css">
        <link rel="shortcut icon" type="image/png" href="../imagens/icones/favicon.png">
        <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body>
        <div id="main">
            <?php include "view/header.php" ?>
            <?php include "view/menu.php" ?>
            <div id="content">
                <a href="../controller/router.php?tipo=pizza_do_mes&modo=adicionar" id="adicionar" class="botao">Adicionar</a>
                <div id="tabela">
                    <div id="tabela_header">
                        <p class="coluna imagem">IMAGEM</p>
                        <p class="coluna titulo">TÍTULO</p>
                        <p class="coluna texto">TEXTO</p>
                        <p class="coluna ativo">ATIVO</p>
                        <p class="coluna acoes">#</p>
                    </div>
                    <div id="tabela_body">
                        <?php
                            foreach ($pizzaDoMes as $pizzaDoMesItem) {
                                $pizzaDoMesController->montarHtmlAdm($pizzaDoMesItem);
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php include "view/footer.php" ?>
        </div>
    </body>
</html>