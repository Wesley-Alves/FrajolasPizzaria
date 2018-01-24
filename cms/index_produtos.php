<?php
    require_once("../util/sessao.php");
    $usuario = $_SESSION["usuario"];
    if (!$usuario->getPermProdutos()) {
        header("location:index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>CMS | Frajola's Pizzaria</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style_cms.css">
        <link rel="shortcut icon" type="image/png" href="../imagens/icones/favicon.png">
    </head>
    <body>
        <div id="main">
            <?php include "view/header.php" ?>
            <?php include "view/menu.php" ?>
            <div id="content">
                <div id="adm_conteudo">
                    <ul class="nocolumn">
                        <li>
                            <a href="adm_produtos.php">
                                <img src="imagens/produtos/adm_produtos.png" alt="Produtos">
                                <p>Produtos</p>
                            </a>
                        </li>
                        <li>
                            <a href="adm_categorias.php">
                                <img src="imagens/produtos/adm_categorias.png" alt="Categorias e Subcategorias">
                                <p>Categorias e Subcategorias</p>
                            </a>
                        </li>
                        <li>
                            <a href="adm_estatisticas.php">
                                <img src="imagens/produtos/adm_estatisticas.png" alt="Estatistícas de Acesso">
                                <p>Estatistícas de Acesso</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php include "view/footer.php" ?>
        </div>
    </body>
</html>