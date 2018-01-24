<?php
    require_once("../util/sessao.php");
    require_once("../controller/categoria_controller.php");
    require_once("../controller/subcategoria_controller.php");

    $usuario = $_SESSION["usuario"];
    if (!$usuario->getPermProdutos()) {
        header("location:index.php");
        exit();
    }

    $categoriaDao = new CategoriaDAO();
    $categorias = $categoriaDao->getCategorias(false);
    $categoriaController = new CategoriaController();
    $subcategoriaController = new SubcategoriaController();
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
                <div id="categorias">
                    <div class="header">
                        <p>Categorias</p>
                        <a href="../controller/router.php?tipo=categoria&modo=adicionar" id="adicionar_categoria" class="botao">Adicionar</a>
                    </div>
                    <div class="body">
                        <?php 
                            foreach ($categorias as $categoria) {
                                $categoriaController->montarHtmlCategoria($categoria);
                            }
                        ?>
                    </div>
                </div>
                <div id="subcategorias">
                    <?php $subcategoriaController->selecionarSubcategorias(); ?>
                </div>
            </div>
            <?php include "view/footer.php" ?>
        </div>
    </body>
</html>