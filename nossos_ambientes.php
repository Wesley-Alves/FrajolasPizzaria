<?php
    require_once("model/ambiente.php");
    require_once("database/ambiente_dao.php");
    $ambienteDao = new AmbienteDAO();
    $ambientes = $ambienteDao->getAmbientes(true);
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
            <h1 id="titulo_pagina">Nossos Ambientes</h1>
            <div id="ambientes">
                <?php foreach ($ambientes as $ambiente) { ?>
                    <div class="ambiente">    
                        <p class="titulo"><?php echo $ambiente->getCidade(); ?> - <?php echo $ambiente->getUf(); ?></p>
                        <div class="conteudo">
                            <img src="imagens/ambientes/<?php echo $ambiente->getImagem(); ?>" alt="<?php echo $ambiente->getCidade(); ?>">
                            <p><?php echo $ambiente->getLogradouro(); ?> nº <?php echo $ambiente->getNumero(); ?></p>
                            <p>CEP <?php echo $ambiente->getCep(); ?> - <?php echo $ambiente->getBairro(); ?></p>
                            <p class="cidade_estado"><?php echo $ambiente->getCidade(); ?> - <?php echo $ambiente->getEstado(); ?></p>
                            <p class="telefone"><?php echo $ambiente->getTelefone(); ?> <?php echo $ambiente->getOperadora() == "N/A" ? "" : "(" . $ambiente->getOperadora() . ")"; ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php include "view/footer.php" ?>
    </body>
</html>