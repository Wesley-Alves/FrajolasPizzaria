<!DOCTYPE html>
<html>
    <head>
        <title>Frajola's Pizzaria</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" type="image/png" href="imagens/icones/favicon.png">
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.inputmask.bundle.min.js"></script>
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
            <div id="fale_conosco">
                <div id="titulo">Preencha seus dados</div>
                <div id="conteudo" class="clearfix">
                    <form action="#" id="form_fale_conosco">
                        <div class="grupo duas_colunas">
                            <label for="nome">Nome<span class="required">*</span></label>
                            <input type="text" name="nome" maxlength="100" required>
                        </div>
                        <div class="grupo duas_colunas">
                            <label for="email">Email<span class="required">*</span></label>
                            <input type="email" name="email" maxlength="100" required>
                        </div>
                        <div class="grupo quatro_colunas">
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" maxlength="15" placeholder="(XX) XXXX-XXXX">
                        </div>
                        <div class="grupo quatro_colunas">
                            <label for="celular">Celular<span class="required">*</span></label>
                            <input type="text" name="celular" maxlength="15" placeholder="(XX) XXXXX-XXXX" required>
                        </div>
                        <div class="grupo quatro_colunas">
                            <label for="profissao">Profissão<span class="required">*</span></label>
                            <input type="text" name="profissao" maxlength="80" required>
                        </div>
                        <div class="grupo quatro_colunas">
                            <label for="sexo">Sexo<span class="required">*</span></label>
                            <select name="sexo">
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                        </div>
                        <div class="grupo tres_colunas">
                            <label for="home_page">Home Page</label>
                            <input type="text" name="home_page" maxlength="150">
                        </div>
                        <div class="grupo tres_colunas">
                            <label for="facebook">Facebook</label>
                            <input type="text" name="facebook" maxlength="150">
                        </div>
                        <div class="grupo tres_colunas">
                            <label for="produtos">Informações de Produtos</label>
                            <input type="text" name="produtos" maxlength="150">
                        </div>
                        <div class="grupo">
                            <label for="comentarios">Sugestões / Críticas</label>
                            <textarea name="comentarios"></textarea>
                        </div>
                        <p id="aviso"><span class="required">*</span> Campo obrigatório</p>
                        <input type="submit" value="Enviar">
                    </form>
                </div>
            </div>
        </div>
        <?php include "view/footer.php" ?>
    </body>
</html>