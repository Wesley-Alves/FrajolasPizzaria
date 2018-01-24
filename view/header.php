<header>
    <div id="cabecalho">
        <a href="index.php"><img src="imagens/geral/logo.png" id="logo" alt="Logo"></a>
        <div id="botao_menu"></div>
        <div id="logo_mobile"><a href="index.php">Frajola's Pizzaria</a></div>
        <div id="botao_login"></div>
        <div id="menu" class="caixa_flex">
            <div id="menu_itens">
                <div id="botao_fechar_menu"></div>
                <a href="promocoes.php">Promoções</a>
                <a href="pizza_do_mes.php">Pizza do Mês</a>
                <a href="nossos_ambientes.php">Nossos Ambientes</a>
                <a href="curiosidades.php">Curiosidades</a>
                <a href="sobre_nos.php">Sobre Nós</a>
                <a href="fale_conosco.php">Fale Conosco</a>
            </div>
        </div>
        <div id="login" class="caixa_flex">
            <form id="form_login" action="#" method="POST">
                <div class="login_grupo">
                    <label for="nome_usuario">Usuário:</label>
                    <input type="text" id="nome_usuario" name="nome_usuario">
                </div>
                <div class="login_grupo">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha">
                    <input type="submit" value="Ok">
                </div>
            </form>
        </div>
    </div>
</header>