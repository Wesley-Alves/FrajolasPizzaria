<nav id="menu">
    <a href="<?php echo $usuario->getPermConteudo() ? "index.php" : "#"; ?>">
        <img src="imagens/menu/adm_conteudo.png" alt="Adm. Conteúdo">
        <p>Adm. Conteúdo</p>
    </a>
    <a href="<?php echo $usuario->getPermFaleConosco() ? "adm_fale_conosco.php" : "#"; ?>">
        <img src="imagens/menu/adm_fale_conosco.png" alt="Adm. Fale Conosco">
        <p>Adm. Fale Conosco</p>
    </a>
    <a href="<?php echo $usuario->getPermProdutos() ? "index_produtos.php" : "#"; ?>">
        <img src="imagens/menu/adm_produtos.png" alt="Adm. Produtos">
        <p>Adm. Produtos</p>
    </a>
    <a href="<?php echo $usuario->getPermUsuarios() ? "adm_usuarios.php" : "#"; ?>">
        <img src="imagens/menu/adm_usuarios.png" alt="Adm. Usuários">
        <p>Adm. Usuários</p>
    </a>
    <?php $nome = explode(" ", $usuario->getNome()); ?>
    <div id="painel_usuario">
        <p>
            <span>Bem-vindo</span>
            <span id="nome"><?php echo count($nome) <= 2 ? $usuario->getNome() : ($nome[0] . " " . $nome[1]); ?></span>
            <a href="logout.php" id="sair">Logout</a>
        </p>
    </div>
</nav>