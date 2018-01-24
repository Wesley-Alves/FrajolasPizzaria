<?php
    @include_once("../database/produto_dao.php");
    @include_once("../database/categoria_dao.php");
    @include_once("../database/subcategoria_dao.php");
    @include_once("../model/produto.php");
    @include_once("../model/categoria.php");
    @include_once("../model/subcategoria.php");

    class ProdutoController {
        public function montarHtmlAdm($produto) {
            ?>
            <div class="linha" data-id="<?php echo $produto->getId(); ?>">
                <div class="coluna imagem">
                    <img src="../imagens/produtos/<?php echo $produto->getImagem(); ?>" alt="<?php echo $produto->getTitulo(); ?>">
                </div>
                <div class="coluna titulo">
                    <span><?php echo $produto->getTitulo(); ?></span>
                </div>
                <div class="coluna texto">
                    <p><?php echo $produto->getDescricao(); ?></p>
                </div>
                <div class="coluna ativo">
                    <a href="../controller/router.php?tipo=produto&modo=ativar&id=<?php echo $produto->getId(); ?>" class="ativar">
                        <?php if ($produto->getAtivo()) { ?>
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        <?php } else { ?>
                            <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                        <?php } ?>
                    </a>
                </div>
                <div class="coluna acoes">
                    <a href="../controller/router.php?tipo=produto&modo=editar&id=<?php echo $produto->getId(); ?>" class="editar">
                        <img src="imagens/icones/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="../controller/router.php?tipo=produto&modo=excluir&id=<?php echo $produto->getId(); ?>" class="excluir" data-titulo="<?php echo $produto->getTitulo(); ?>">
                        <img src="imagens/icones/excluir.png" alt="Excluir" title="Excluir">
                    </a>
                </div>
            </div>
            <?php
        }
        
        public function getModal($isEditar) {
            $categoriaDao = new CategoriaDAO();
            $categorias = $categoriaDao->getCategorias(false);
            $subcategoriaDao = new SubcategoriaDAO();
            if (!$isEditar) {
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo">Adicionar Produto</h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=produto&modo=gravar" id="form_add_produto">
                                <div class="grupo _55">
                                    <label for="titulo">Título:</label>
                                    <input type="text" name="titulo" maxlength="50" required>
                                </div>
                                <div class="grupo _20">
                                    <label for="preco">Preço:</label>
                                    <input type="text" name="preco" required data-original="1">
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0">
                                        <input type="checkbox" name="ativo" value="1" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo">
                                    <label for="descricao">Descrição:</label>
                                    <input type="text" name="descricao" maxlength="200" required>
                                </div>
                                <div class="grupo _50">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="Imagem">
                                        <label for="imagem">Selecione um arquivo</label>
                                        <input type="file" name="imagem" accept="image/*" required>
                                    </div>
                                </div>
                                <div class="grupo _50 nopadding">
                                    <div class="grupo">
                                        <label for="subcategoria">Subcategoria:</label>
                                        <select name="subcategoria" required>
                                            <option label=" " hidden></option>
                                            <?php
                                                foreach ($categorias as $categoria) {
                                                    $subcategorias = $subcategoriaDao->getSubcategorias($categoria->getId(), true);
                                            ?>
                                                    <optgroup label="<?= $categoria->getNome(); ?>">
                                                        <?php foreach ($subcategorias as $subcategoria) { ?>
                                                            <option value="<?= $subcategoria->getId(); ?>"><?= $subcategoria->getNome(); ?></option>
                                                        <?php } ?>
                                                    </optgroup>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="grupo">
                                        <label for="detalhes">Detalhes:</label>
                                        <textarea class="pequena" name="detalhes" required></textarea>
                                    </div>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_add_produto">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                $id = $_GET["id"];
                $produtoDao = new ProdutoDAO();
                $produto = $produtoDao->getProduto($id);
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo"><?= $produto->getTitulo(); ?></h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=produto&modo=atualizar" id="form_atualizar_produto">
                                <input type="hidden" name="id" value="<?= $produto->getId(); ?>">
                                <div class="grupo _55">
                                    <label for="titulo">Título:</label>
                                    <input type="text" name="titulo" maxlength="50" value="<?= $produto->getTitulo(); ?>" required>
                                </div>
                                <div class="grupo _20">
                                    <label for="preco">Preço:</label>
                                    <input type="text" name="preco" value="<?= $produto->getPreco(); ?>" required data-original="1">
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0" <?= $produto->getAtivo() == "0" ? "checked" : ""; ?>>
                                        <input type="checkbox" name="ativo" value="1" <?= $produto->getAtivo() == "1" ? "checked" : ""; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo">
                                    <label for="descricao">Descrição:</label>
                                    <input type="text" name="descricao" maxlength="200" value="<?= $produto->getDescricao(); ?>" required>
                                </div>
                                <div class="grupo _50">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <input type="hidden" name="imagem_atual" value="<?= $produto->getImagem(); ?>">
                                        <img src="../imagens/produtos/<?= $produto->getImagem(); ?>" alt="Imagem">
                                        <label for="imagem">Selecione um arquivo</label>
                                        <input type="file" name="imagem" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo _50 nopadding">
                                    <div class="grupo">
                                        <label for="subcategoria">Subcategoria:</label>
                                        <select name="subcategoria" required>
                                            <option label=" " hidden></option>
                                            <?php
                                                foreach ($categorias as $categoria) {
                                                    $subcategorias = $subcategoriaDao->getSubcategorias($categoria->getId(), false);
                                            ?>
                                                    <optgroup label="<?= $categoria->getNome(); ?>">
                                                        <?php foreach ($subcategorias as $subcategoria) { ?>
                                                            <option value="<?= $subcategoria->getId(); ?>" <?= $subcategoria->getId() == $produto->getIdSubcategoria() ? "selected" : ""; ?>><?= $subcategoria->getNome(); ?></option>
                                                        <?php } ?>
                                                    </optgroup>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="grupo">
                                        <label for="detalhes">Detalhes:</label>
                                        <textarea class="pequena" name="detalhes" required><?= $produto->getDetalhes(); ?></textarea>
                                    </div>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_atualizar_produto">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        
        public function gravarProduto() {
            $titulo = $_POST["titulo"];
            $preco = $_POST["preco"];
            $ativo = $_POST["ativo"];
            $descricao = $_POST["descricao"];
            $subcategoria = $_POST["subcategoria"];
            $detalhes = $_POST["detalhes"];
            
            $arquivo = basename($_FILES["imagem"]["name"]);
            $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
            $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
            $caminhoArquivo = "../imagens/produtos/" . $nomeCriptografado;
            
            if ($_FILES["imagem"]["error"]) {
                echo "ERRO:Erro ao enviar o arquivo. Código: " . $_FILES["imagem"]["error"];
            } elseif (!getimagesize($_FILES["imagem"]["tmp_name"])) {
                echo "ERRO:Este arquivo não é uma imagem.";
            } elseif ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
                echo "ERRO:Este tipo de imagem não é suportado.";
            } elseif (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoArquivo)) {
                echo "ERRO:Erro ao enviar a imagem.";
            } else {
                $produto = new Produto();
                $produto->setTitulo($titulo);
                $produto->setPreco($preco);
                $produto->setAtivo($ativo == "1");
                $produto->setDescricao($descricao);
                $produto->setImagem($nomeCriptografado);
                $produto->setIdSubcategoria($subcategoria);
                $produto->setDetalhes($detalhes);
                $produtoDao = new ProdutoDAO();
                $id = $produtoDao->gravar($produto);
                $produto->setId($id);
                $this->montarHtmlAdm($produto);
            }
        }
        
        public function ativarProduto() {
            $id = $_GET["id"];
            $ativo = $_GET["ativo"];
            
            $produtoDao = new ProdutoDAO();
            $produtoDao->ativar($id, $ativo == "1" ? 0 : 1);
            if ($ativo == "1") {
                echo "Este produto foi desabilitado e não será mais exibido.";
            } else {
                echo "Este produto foi habilitado e agora será exibido.";
            }
        }
        
        public function atualizarProduto() {
            $id = $_POST["id"];
            $titulo = $_POST["titulo"];
            $preco = $_POST["preco"];
            $ativo = $_POST["ativo"];
            $descricao = $_POST["descricao"];
            $subcategoria = $_POST["subcategoria"];
            $detalhes = $_POST["detalhes"];
            $imagemAtual = $_POST["imagem_atual"];
            
            if (!empty($_FILES["imagem"]["name"])) {
                $arquivo = basename($_FILES["imagem"]["name"]);
                $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
                $caminhoArquivo = "../imagens/produtos/" . $nomeCriptografado;

                if ($_FILES["imagem"]["error"]) {
                    echo "ERRO:Erro ao enviar o arquivo. Código: " . $_FILES["imagem"]["error"];
                    return;
                } elseif (!getimagesize($_FILES["imagem"]["tmp_name"])) {
                    echo "ERRO:Este arquivo não é uma imagem.";
                    return;
                } elseif ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
                    echo "ERRO:Este tipo de imagem não é suportado.";
                    return;
                } elseif (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoArquivo)) {
                    echo "ERRO:Erro ao enviar a imagem.";
                    return;
                }
                
                $imagemAtual = $nomeCriptografado;
            }
            
            $produto = new Produto();
            $produto->setId($id);
            $produto->setTitulo($titulo);
            $produto->setPreco($preco);
            $produto->setAtivo($ativo == "1");
            $produto->setDescricao($descricao);
            $produto->setImagem($imagemAtual);
            $produto->setIdSubcategoria($subcategoria);
            $produto->setDetalhes($detalhes);
            $produtoDao = new ProdutoDAO();
            $produtoDao->atualizar($produto);
            $this->montarHtmlAdm($produto);
        }
        
        public function excluirProduto() {
            $id = $_GET["id"];
            $produtoDao = new ProdutoDAO();
            $produtoDao->excluir($id);
            echo $id;
        }
        
        public function mostrarProdutos() {
            $produtoDao = new ProdutoDAO();
            if (isset($_POST["idSubcategoria"])) {
                $produtos = $produtoDao->mostrarProdutos($_POST["idSubcategoria"], null);
            } else if (isset($_POST["texto"])) {
                $produtos = $produtoDao->mostrarProdutos(null, $_POST["texto"]);
            } else {
                $produtos = $produtoDao->mostrarProdutos(null, null);
            }
            
            if (sizeof($produtos) == 0) {
                echo "<p class=\"sem_pizzas\">Nenhuma pizza encontrada.</p>";
            }
            
            $totalPaginas = intval(sizeof($produtos) / 6) + 1;
            for ($pagina = 0; $pagina < $totalPaginas; $pagina++) {
                echo "<div id=\"pagina_" . ($pagina + 1) . "\" class=\"pagina" . ($pagina == 0 ? " visible" : "") . "\">";
                for ($i = 0; $i < 6; $i++) {
                    if (isset($produtos[$pagina * 6 + $i])) {
                        $produto = $produtos[$pagina * 6 + $i];
                        ?>
                        <div class="pizza">
                            <p class="titulo" title="<?= $produto->getTitulo(); ?>"><?= $produto->getTitulo(); ?></p>
                            <img src="imagens/produtos/<?= $produto->getImagem(); ?>" alt="Pizza">
                            <p class="descricao"><?= $produto->getDescricao(); ?></p>
                            <div class="rodape">
                                <p class="preco">R$ <?= number_format($produto->getPreco(), 2, ",", ""); ?></p>
                                <a href="#" class="detalhes" data-id="<?= $produto->getId(); ?>">Detalhes</a>
                            </div>
                        </div>
                        <?php
                    } else {
                        break;
                    }
                }
                
                echo "</div>";
            }
            
            if ($totalPaginas > 1) {
                ?>
                <div class="paginacao" data-atual="1" data-total="<?= $totalPaginas; ?>">
                    <a href="#" class="pagina_anterior disabled"></a>
                    <a href="#" class="selected" data-pagina="1">1</a>
                    <?php
                        for ($pagina = 2; $pagina <= $totalPaginas; $pagina++) {
                            echo "<a href=\"#\" data-pagina=\"$pagina\">$pagina</a>";
                        }
                    ?>
                    <a href="#" class="pagina_proxima"></a>
                </div>
                <?php
            }
        }
        
        public function modalDetalhes() {
            $id = $_POST["id"];
            $produtoDao = new ProdutoDAO();
            $produto = $produtoDao->getProdutoDetalhes($id);
            $produtoDao->adicionarClique($id);
            ?>
            <div class="modal modal_detalhes">
                <div class="body">
                    <div class="header clearfix">
                        <a href="#" class="fechar">×</a>
                        <h1 class="titulo"><?= $produto->getTitulo(); ?></h1>
                    </div>
                    <div class="content">
                        <img src="./imagens/produtos/<?= $produto->getImagem(); ?>">
                        <div class="informacoes">
                            <p><?= $produto->getCategoria(); ?></p>
                            <p><?= $produto->getSubcategoria(); ?></p>
                            <p>R$ <?= number_format($produto->getPreco(), 2, ",", ""); ?></p>
                        </div>
                        <p><span>Descrição</span><?= $produto->getDescricao(); ?></p>
                        <p><span>Detalhes</span><?= $produto->getDetalhes(); ?></p>
                    </div>
                </div>
            </div>
            <?php
        }
    }
?>