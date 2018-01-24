<?php
    $texto = isset($_GET["texto"]) ? $_GET["texto"] : "";
    $titulo = isset($_GET["titulo"]) ? $_GET["titulo"] : "Informação";
    $tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : "";
    $acao = isset($_GET["acao"]) ? $_GET["acao"] : "";
?>

<div class="modal">
    <div class="body">
        <div class="header clearfix">
            <a href="#" class="fechar">×</a>
            <h1 class="titulo"><?= $titulo; ?></h1>
        </div>
        <div class="content">
            <p><?= $texto; ?></p>
        </div>
        <?php if ($tipo == "confirmação") { ?>
            <div class="footer clearfix">
                <a href="<?= $acao; ?>" class="confirmar">Confirmar</a>
                <a href="#" class="fechar">Cancelar</a>
            </div>
        <?php } else { ?>
            <div class="footer clearfix">
                <a href="#" class="fechar">Ok</a>
            </div>
        <?php } ?>
    </div>
</div>