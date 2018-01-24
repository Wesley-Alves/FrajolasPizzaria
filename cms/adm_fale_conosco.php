<?php
    require_once("../util/sessao.php");
    require_once("../controller/fale_conosco_controller.php");

    $usuario = $_SESSION["usuario"];
    if (!$usuario->getPermFaleConosco()) {
        header("location:index.php");
        exit();
    }

    $faleConoscoDao = new FaleConoscoDAO();
    $faleConosco = $faleConoscoDao->getFaleConosco(false);
    $faleConoscoController = new FaleConoscoController();
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
                <div id="tabela">
                    <div id="tabela_header">
                        <p class="coluna nome">NOME</p>
                        <p class="coluna email">EMAIL</p>
                        <p class="coluna celular">CELULAR</p>
                        <p class="coluna sugestao">SUGESTÃO/CRITICA</p>
                        <p class="coluna acoes">#</p>
                    </div>
                    <div id="tabela_body">
                        <?php
                            foreach ($faleConosco as $faleConoscoItem) {
                                $faleConoscoController->montarHtmlAdm($faleConoscoItem);
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php include "view/footer.php" ?>
        </div>
    </body>
</html>