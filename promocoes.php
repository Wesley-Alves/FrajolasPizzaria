<?php
    require_once("model/promocao.php");
    require_once("database/promocao_dao.php");
    $promocaoDao = new PromocaoDAO();
    $promocoes = $promocaoDao->getPromocoes(true);
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
            <h1 id="titulo_pagina">Nossas Promoções</h1>
            <div id="promocoes">
                <?php foreach ($promocoes as $promocao) { ?>
                    <div class="promocao">
                        <p class="titulo"><?php echo $promocao->getTitulo(); ?></p>
                        <div class="conteudo">
                            <img src="imagens/promocoes/<?php echo $promocao->getImagem(); ?>" alt="<?php echo $promocao->getTitulo(); ?>">
                            <p><?php echo $promocao->getTexto(); ?></p>
                        </div>
                        <div class="rodape">
                            <div class="preco">
                                <span class="sem_desconto">R$ <?php echo number_format($promocao->getPrecoAntigo(), 2, ",", ""); ?></span>
                                <span class="com_desconto">R$ <?php echo number_format($promocao->getNovoPreco(), 2, ",", ""); ?></span>
                            </div>
                            <span class="desconto">
                                <?php echo $promocao->getPrecoAntigo() == 0 || $promocao->getNovoPreco() > $promocao->getPrecoAntigo() ? 0 : round(($promocao->getPrecoAntigo() - $promocao->getNovoPreco()) / $promocao->getPrecoAntigo() * 100); ?>%
                            </span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php include "view/footer.php" ?>
    </body>
</html>