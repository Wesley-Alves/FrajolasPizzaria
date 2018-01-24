<?php
    require_once("../util/sessao.php");
    require_once("../controller/usuario_controller.php");

    $usuario = $_SESSION["usuario"];
    if (!$usuario->getPermUsuarios()) {
        header("location:index.php");
        exit();
    }

    $usuarioDao = new UsuarioDAO();
    $usuarios = $usuarioDao->getUsuarios(false);
    $usuarioController = new UsuarioController();
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
                <a href="../controller/router.php?tipo=usuario&modo=adicionar" id="adicionar" class="botao">Adicionar</a>
                <div id="tabela">
                    <div id="tabela_header">
                        <p class="coluna imagem_medio">IMAGEM</p>
                        <p class="coluna nome">NOME</p>
                        <p class="coluna email_grande">EMAIL</p>
                        <p class="coluna privilegio">PRIVILÉGIO</p>>
                        <p class="coluna ativo">ATIVO</p>
                        <p class="coluna acoes">#</p>
                    </div>
                    <div id="tabela_body">
                        <?php
                            foreach ($usuarios as $usuario) {
                                $usuarioController->montarHtmlAdm($usuario);
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php include "view/footer.php" ?>
        </div>
    </body>
</html>