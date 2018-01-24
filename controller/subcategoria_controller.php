<?php
    require_once("../database/subcategoria_dao.php");
    require_once("../model/subcategoria.php");

    class SubcategoriaController {
        public function selecionarSubcategorias() {
            if (isset($_GET["id"])) {
                $categoriaId = $_GET["id"];
                $subcategoriaDao = new SubcategoriaDAO();
                $nome = $subcategoriaDao->getNomeCategoria($categoriaId);
                $subcategorias = $subcategoriaDao->getSubcategorias($categoriaId, false);
                ?>
                <div class="header" data-id="<?= $categoriaId; ?>">
                    <p title="Subcategorias - <?= $nome; ?>"><?= $nome; ?></p>
                    <a href="../controller/router.php?tipo=subcategoria&modo=adicionar&categoria=<?= $categoriaId; ?>" id="adicionar_subcategoria" class="botao">Adicionar</a>
                </div>
                <div class="body">
                    <?php 
                        foreach ($subcategorias as $subcategoria) {
                            $this->montarHtmlSubcategoria($subcategoria);
                        }
                    ?>
                </div>
                <?php
            } else {
                ?>
                <div class="header">
                    <p>Subcategorias</p>
                    <a href="#" id="adicionar_subcategoria" class="botao disabled">Adicionar</a>
                </div>
                <div class="body">
                    <p class="selecione">Clique no título de uma categoria ao lado para visualizar suas subcategorias.</p>
                </div>
                <?php
            }
        }
        
        public function montarHtmlSubcategoria($subcategoria) {
            ?>
            <div class="linha" data-id="<?= $subcategoria->getId(); ?>">
                <div class="coluna titulo">
                    <p><?= $subcategoria->getNome(); ?></p>
                </div>
                <div class="coluna ativo">
                    <a href="../controller/router.php?tipo=subcategoria&modo=ativar&id=<?= $subcategoria->getId(); ?>" class="ativar">
                        <?php if ($subcategoria->getAtivo()) { ?>
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        <?php } else { ?>
                            <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                        <?php } ?>
                    </a>
                </div>
                <div class="coluna acoes">
                    <a href="../controller/router.php?tipo=subcategoria&modo=editar&id=<?= $subcategoria->getId(); ?>" class="editar">
                        <img src="imagens/icones/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="../controller/router.php?tipo=subcategoria&modo=excluir&id=<?= $subcategoria->getId(); ?>" class="excluir" data-titulo="<?= $subcategoria->getNome(); ?>">
                        <img src="imagens/icones/excluir.png" alt="Excluir" title="Excluir">
                    </a>
                </div>
            </div>
            <?php
        }
        
        public function getHtmlById() {
            $id = $_GET["id"];
            $subcategoriaDao = new SubcategoriaDAO();
            $subcategoria = $subcategoriaDao->getSubcategoria($id);
            $this->montarHtmlSubcategoria($subcategoria);
        }
        
        public function montarForm($isEditar) {
            if (!$isEditar) {
                ?>
                <div class="linha adicionar">
                    <div class="coluna form">
                        <form action="../controller/router.php?tipo=subcategoria&modo=gravar">
                            <input type="hidden" name="id_categoria" value="<?= $_GET["categoria"]; ?>">
                            <input type="text" name="nome" maxlength="50" required>
                            <input type="hidden" name="ativo" value="1">
                            <input type="submit">
                        </form>
                    </div>
                    <div class="coluna ativo">
                        <a href="#" class="ativar">
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        </a>
                    </div>
                    <div class="coluna acoes">
                        <a href="#" class="salvar">
                            <img src="imagens/icones/salvar.png" alt="Salvar" title="Salvar">
                        </a>
                        <a href="#" class="cancelar">
                            <img src="imagens/icones/excluir.png" alt="Cancelar" title="Cancelar">
                        </a>
                    </div>
                </div>
                <?php
            } else {
                $id = $_GET["id"];
                $subcategoriaDao = new SubcategoriaDAO();
                $subcategoria = $subcategoriaDao->getSubcategoria($id);
                ?>
                <div class="linha atualizar">
                    <div class="coluna form">
                        <form action="../controller/router.php?tipo=subcategoria&modo=atualizar">
                            <input type="hidden" name="id" value="<?= $subcategoria->getId(); ?>">
                            <input type="text" name="nome" maxlength="50" value="<?= $subcategoria->getNome(); ?>" required>
                            <input type="hidden" name="ativo" value="<?= $subcategoria->getAtivo(); ?>">
                            <input type="submit">
                        </form>
                    </div>
                    <div class="coluna ativo">
                        <a href="#" class="ativar">
                            <?php if ($subcategoria->getAtivo()) { ?>
                                <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                            <?php } else { ?>
                                <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                            <?php } ?>
                        </a>
                    </div>
                    <div class="coluna acoes">
                        <a href="#" class="salvar">
                            <img src="imagens/icones/salvar.png" alt="Salvar" title="Salvar">
                        </a>
                        <a href="../controller/router.php?tipo=subcategoria&modo=html&id=<?= $subcategoria->getId(); ?>" class="cancelar">
                            <img src="imagens/icones/excluir.png" alt="Cancelar" title="Cancelar">
                        </a>
                    </div>
                </div>
                <?php
            }
        }
        
        public function gravarSubcategoria() {
            $nome = $_POST["nome"];
            $ativo = $_POST["ativo"];
            $idCategoria = $_POST["id_categoria"];
            
            $subcategoria = new Subcategoria();
            $subcategoria->setNome($nome);
            $subcategoria->setAtivo($ativo);
            $subcategoria->setIdCategoria($idCategoria);
            $subcategoriaDao = new SubcategoriaDAO();
            $subcategoria->setId($subcategoriaDao->gravar($subcategoria));
            $this->montarHtmlSubcategoria($subcategoria);
        }
        
        public function atualizarSubcategoria() {
            $id = $_POST["id"];
            $nome = $_POST["nome"];
            $ativo = $_POST["ativo"];
            
            $subcategoria = new Subcategoria();
            $subcategoria->setId($id);
            $subcategoria->setNome($nome);
            $subcategoria->setAtivo($ativo);
            $subcategoriaDao = new SubcategoriaDAO();
            $subcategoriaDao->atualizar($subcategoria);
            $this->montarHtmlSubcategoria($subcategoria);
        }
        
        public function ativarSubcategoria() {
            $id = $_GET["id"];
            $ativo = $_GET["ativo"];
            
            $subcategoriaDao = new SubcategoriaDAO();
            $subcategoriaDao->ativar($id, $ativo == "1" ? 0 : 1);
            if ($ativo == "1") {
                echo "Esta subcategoria foi desabilitada e agora seus produtos não serão mais exibidos.";
            } else {
                echo "Esta subcategoria foi habilitada e agora seus produtos serão exibidos.";
            }
        }
        
        public function excluirSubcategoria() {
            $id = $_GET["id"];
            $subcategoriaDao = new SubcategoriaDAO();
            $subcategoriaDao->excluir($id);
            echo "SUBCATEGORIA:" . $id;
        }
    }
?>