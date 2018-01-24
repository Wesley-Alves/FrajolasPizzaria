<?php
    require_once("../util/sessao.php");
    require_once("../database/produto_dao.php");

    $usuario = $_SESSION["usuario"];
    if (!$usuario->getPermProdutos()) {
        header("location:index.php");
        exit();
    }

    $produtoDao = new ProdutoDAO();
    $estatisticas = $produtoDao->getEstatisticas();
    $produtos = $produtoDao->getProdutosGrafico();
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
                <h1 id="titulo_estatisticas">Estatistícas de Acesso</h1>
                <div id="grafico">
                    <div id="legenda_esquerda">
                        <p id="total" title="Total de cliques"><?= $estatisticas["total"]; ?></p>
                        <p id="inicio">0</p>
                    </div>
                    <div id="colunas">
                        <?php foreach ($produtos as $produto) { ?>
                            <div class="produto" style="height: <?= 320 * $produto["porcentagem"] / 100; ?>px; margin-top: <?= 320 - (320 * $produto["porcentagem"] / 100); ?>px;" title="<?= $produto["titulo"]; ?> - <?= $produto["porcentagem"]; ?>%">
                                <span class="valor"><?= $produto["cliques"]; ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="legenda_baixo">
                        <p id="media" title="Média de cliques por produto"><?= $estatisticas["media"]; ?></p>
                        <?php foreach ($produtos as $produto) { ?>
                            <p class="legenda_produto"><?= $produto["titulo"]; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php include "view/footer.php" ?>
        </div>
    </body>
</html>