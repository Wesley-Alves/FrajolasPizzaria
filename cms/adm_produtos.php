<?php
    require_once("../util/sessao.php");
    require_once("../controller/produto_controller.php");

    $usuario = $_SESSION["usuario"];
    if (!$usuario->getPermProdutos()) {
        header("location:index.php");
        exit();
    }

    $produtoDao = new ProdutoDAO();
    $produtos = $produtoDao->getProdutos();
    $produtoController = new ProdutoController();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>CMS | Frajola's Pizzaria</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style_cms.css">
        <link rel="shortcut icon" type="image/png" href="../imagens/icones/favicon.png">
        <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery.inputmask.bundle.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body>
        <div id="main">
            <?php include "view/header.php" ?>
            <?php include "view/menu.php" ?>
            <div id="content">
                <a href="../controller/router.php?tipo=produto&modo=adicionar" id="adicionar" class="botao">Adicionar</a>
                <div id="tabela">
                    <div id="tabela_header">
                        <p class="coluna imagem">IMAGEM</p>
                        <p class="coluna titulo">TÍTULO</p>
                        <p class="coluna texto">DESCRIÇÃO</p>
                        <p class="coluna ativo">ATIVO</p>
                        <p class="coluna acoes">#</p>
                    </div>
                    <div id="tabela_body">
                        <?php
                            foreach ($produtos as $produto) {
                                $produtoController->montarHtmlAdm($produto);
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php include "view/footer.php" ?>
        </div>
    </body>
</html>