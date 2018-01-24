<?php
    require_once("database/imagem_slider_dao.php");
    require_once("database/categoria_dao.php");
    require_once("database/subcategoria_dao.php");
    require_once("database/produto_dao.php");
    require_once("model/imagem_slider.php");
    require_once("model/categoria.php");
    require_once("model/subcategoria.php");
    require_once("model/produto.php");
    require_once("controller/produto_controller.php");

    $imagemSliderDao = new ImagemSliderDAO();
    $imagens = $imagemSliderDao->getImagens(true);
    $categoriaDao = new CategoriaDAO();
    $categorias = $categoriaDao->getCategorias(true);
    $subcategoriaDao = new SubcategoriaDAO();
    $produtoController = new ProdutoController();
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
        <script type="text/javascript" src="js/responsiveslides.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body>
        <?php include "view/header.php" ?>
        <div id="main">
            <noscript>
                <p id="sem_javascript">O JavaScript não é suportado por seu navegador ou foi desativado. Para o funcionamento do site, é necessário que ative-o.</p>
            </noscript>
            <div id="container_slider" <?php echo empty($imagens) ? "style=\"display: none;\"" : ""; ?>>
                <ul id="slider">
                    <?php foreach ($imagens as $imagem) { ?>
                        <li>
                            <img src="imagens/slides/<?php echo $imagem->getImagem(); ?>" alt="<?php echo $imagem->getLegenda(); ?>">
                            <p class="legenda"><?php echo $imagem->getLegenda(); ?></p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div id="area_pizzas" class="clearfix">
                <div id="redes_sociais">
                    <a href="http://www.facebook.com" target="_blank" class="rede_social facebook" title="Facebook"></a>
                    <a href="http://www.instagram.com" target="_blank" class="rede_social instagram" title="Instagram"></a>
                    <a href="http://www.twitter.com" target="_blank" class="rede_social twitter" title="Twitter"></a>
                </div>
                <div id="titulo_pizzas_mobile" class="clearfix">
                    <h1>Nossas Pizzas</h1>
                    <div id="botao_categorias"></div>
                </div>
                <div id="lista_categorias">
                    <ul id="menu_categorias">
                        <?php
                            foreach ($categorias as $categoria) {
                                $subcategorias = $subcategoriaDao->getSubcategorias($categoria->getId(), true);
                        ?>
                                <li>
                                    <a href="#"><?= $categoria->getNome(); ?></a>
                                    <?php if (!empty($subcategorias)) { ?>
                                        <ul class="submenu_categorias">
                                            <?php foreach ($subcategorias as $subcategoria) { ?>
                                                <li><a href="#" data-id="<?= $subcategoria->getId(); ?>"><?= $subcategoria->getNome(); ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                        <?php } ?>
                    </ul>
                </div>
                <div id="area_principal">
                    <h1 id="titulo_pizzas">Nossas Pizzas</h1>
                    <div id="caixa_pesquisa">
                        <form action="#" id="form_pesquisa">
                            <input type="text" name="texto">
                            <input type="submit" value="">
                        </form>
                    </div>
                    <div id="pizzas" class="clearfix">
                        <?php
                            $produtoController->mostrarProdutos();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include "view/footer.php" ?>
    </body>
</html>