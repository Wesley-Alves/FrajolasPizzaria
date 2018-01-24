<?php
    require_once("../util/sessao.php");
    $usuario = $_SESSION["usuario"];
    if (!$usuario->getPermConteudo()) {
        if ($usuario->getPermFaleConosco()) {
            header("location:adm_fale_conosco.php");
        } else if ($usuario->getPermProdutos()) {
            header("location:index_produtos.php");
        } else if ($usuario->getPermUsuarios()) {
            header("location:adm_usuarios.php");
        }
        
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
                    <ul>
                        <li>
                            <a href="adm_curiosidade.php">
                                <img src="imagens/adm_conteudo/curiosidades.png" alt="Curiosidades">
                                <p>Curiosidades</p>
                            </a>
                        </li>
                        <li>
                            <a href="adm_sobre_a_pizzaria.php">
                                <img src="imagens/adm_conteudo/sobre_a_pizzaria.png" alt="Sobre a Pizzaria">
                                <p>Sobre a Pizzaria</p>
                            </a>
                        </li>
                        <li>
                            <a href="adm_promocao.php">
                                <img src="imagens/adm_conteudo/promocoes.png" alt="Promoções">
                                <p>Promoções</p>
                            </a>
                        </li>
                        <li>
                            <a href="adm_ambientes.php">
                                <img src="imagens/adm_conteudo/ambientes.png" alt="Ambientes">
                                <p>Ambientes</p>
                            </a>
                        </li>
                        <li>
                            <a href="adm_pizza_do_mes.php">
                                <img src="imagens/adm_conteudo/pizza_do_mes.png" alt="Pizza do Mês">
                                <p>Pizza do Mês</p>
                            </a>
                        </li>
                        <li>
                            <a href="adm_slider.php">
                                <img src="imagens/adm_conteudo/inicio.png" alt="Slider">
                                <p>Slider</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php include "view/footer.php" ?>
        </div>
    </body>
</html>