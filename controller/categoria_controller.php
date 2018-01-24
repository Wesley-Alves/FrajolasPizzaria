<?php
    require_once("../database/categoria_dao.php");
    require_once("../model/categoria.php");

    class CategoriaController {
        public function montarHtmlCategoria($categoria) {
            ?>
            <div class="linha" data-id="<?= $categoria->getId(); ?>">
                <div class="coluna titulo">
                    <p>
                        <a href="../controller/router.php?tipo=subcategoria&modo=selecionar&id=<?= $categoria->getId(); ?>" class="selecionar">
                            <?= $categoria->getNome(); ?>
                        </a>
                    </p>
                </div>
                <div class="coluna ativo">
                    <a href="../controller/router.php?tipo=categoria&modo=ativar&id=<?= $categoria->getId(); ?>" class="ativar">
                        <?php if ($categoria->getAtivo()) { ?>
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        <?php } else { ?>
                            <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                        <?php } ?>
                    </a>
                </div>
                <div class="coluna acoes">
                    <a href="../controller/router.php?tipo=categoria&modo=editar&id=<?= $categoria->getId(); ?>" class="editar">
                        <img src="imagens/icones/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="../controller/router.php?tipo=categoria&modo=excluir&id=<?= $categoria->getId(); ?>" class="excluir" data-titulo="<?= $categoria->getNome(); ?>">
                        <img src="imagens/icones/excluir.png" alt="Excluir" title="Excluir">
                    </a>
                </div>
            </div>
            <?php
        }
        
        public function getHtmlById() {
            $id = $_GET["id"];
            $categoriaDao = new CategoriaDAO();
            $categoria = $categoriaDao->getCategoria($id);
            $this->montarHtmlCategoria($categoria);
        }
        
        public function montarForm($isEditar) {
            if (!$isEditar) {
                ?>
                <div class="linha adicionar">
                    <div class="coluna form">
                        <form action="../controller/router.php?tipo=categoria&modo=gravar">
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
                $categoriaDao = new CategoriaDAO();
                $categoria = $categoriaDao->getCategoria($id);
                ?>
                <div class="linha atualizar">
                    <div class="coluna form">
                        <form action="../controller/router.php?tipo=categoria&modo=atualizar">
                            <input type="hidden" name="id" value="<?= $categoria->getId(); ?>">
                            <input type="text" name="nome" maxlength="50" value="<?= $categoria->getNome(); ?>" required>
                            <input type="hidden" name="ativo" value="<?= $categoria->getAtivo(); ?>">
                            <input type="submit">
                        </form>
                    </div>
                    <div class="coluna ativo">
                        <a href="#" class="ativar">
                            <?php if ($categoria->getAtivo()) { ?>
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
                        <a href="../controller/router.php?tipo=categoria&modo=html&id=<?= $categoria->getId(); ?>" class="cancelar">
                            <img src="imagens/icones/excluir.png" alt="Cancelar" title="Cancelar">
                        </a>
                    </div>
                </div>
                <?php
            }
        }
        
        public function gravarCategoria() {
            $nome = $_POST["nome"];
            $ativo = $_POST["ativo"];
            
            $categoria = new Categoria();
            $categoria->setNome($nome);
            $categoria->setAtivo($ativo);
            $categoriaDao = new CategoriaDAO();
            $categoria->setId($categoriaDao->gravar($categoria));
            $this->montarHtmlCategoria($categoria);
        }
        
        public function atualizarCategoria() {
            $id = $_POST["id"];
            $nome = $_POST["nome"];
            $ativo = $_POST["ativo"];
            
            $categoria = new Categoria();
            $categoria->setId($id);
            $categoria->setNome($nome);
            $categoria->setAtivo($ativo);
            $categoriaDao = new CategoriaDAO();
            $categoriaDao->atualizar($categoria);
            $this->montarHtmlCategoria($categoria);
        }
        
        public function ativarCategoria() {
            $id = $_GET["id"];
            $ativo = $_GET["ativo"];
            
            $categoriaDao = new CategoriaDAO();
            $categoriaDao->ativar($id, $ativo == "1" ? 0 : 1);
            if ($ativo == "1") {
                echo "Esta categoria foi desabilitada e agora suas subcategorias e seus produtos não serão mais exibidos.";
            } else {
                echo "Esta categoria foi habilitada e agora suas subcategorias e seus produtos serão exibidos.";
            }
        }
        
        public function excluirCategoria() {
            $id = $_GET["id"];
            $categoriaDao = new CategoriaDAO();
            $categoriaDao->excluir($id);
            echo "CATEGORIA:" . $id;
        }
    }