<?php
    require_once("../database/fale_conosco_dao.php");
    require_once("../model/fale_conosco.php");

    class FaleConoscoController {
        public function gravar() {
            $faleConosco = new FaleConosco();
            $faleConosco->setNome($_POST["nome"]);
            $faleConosco->setEmail($_POST["email"]);
            $faleConosco->setTelefone($_POST["telefone"]);
            $faleConosco->setCelular($_POST["celular"]);
            $faleConosco->setProfissao($_POST["profissao"]);
            $faleConosco->setSexo($_POST["sexo"]);
            $faleConosco->setHomePage($_POST["home_page"]);
            $faleConosco->setFacebook($_POST["facebook"]);
            $faleConosco->setProdutos($_POST["produtos"]);
            $faleConosco->setComentarios($_POST["comentarios"]);
            
            $faleConoscoDao = new FaleConoscoDAO();
            $faleConoscoDao->gravar($faleConosco);
        }
        
        public function montarHtmlAdm($faleConosco) {
            ?>
            <div class="linha" data-id="<?php echo $faleConosco->getId(); ?>">
                <div class="coluna medio nome">
                    <span><?php echo $faleConosco->getNome(); ?></span>
                </div>
                <div class="coluna medio email">
                    <span><?php echo $faleConosco->getEmail(); ?></span>
                </div>
                <div class="coluna medio celular">
                    <span><?php echo $faleConosco->getCelular(); ?></span>
                </div>
                <div class="coluna medio sugestao">
                    <p><?php echo $faleConosco->getComentarios(); ?></p>
                </div>
                <div class="coluna medio acoes">
                    <a href="../controller/router.php?tipo=fale_conosco&modo=visualizar&id=<?php echo $faleConosco->getId(); ?>" class="visualizar">
                        <img src="imagens/icones/visualizar.png" alt="Visualizar" title="Visualizar">
                    </a>
                    <a href="../controller/router.php?tipo=fale_conosco&modo=excluir&id=<?php echo $faleConosco->getId(); ?>" class="excluir">
                        <img src="imagens/icones/excluir.png" alt="Excluir" title="Excluir">
                    </a>
                </div>
            </div>
            <?php
        }
        
        public function getModal() {
            $id = $_GET["id"];
            $faleConoscoDao = new FaleConoscoDAO();
            $faleConosco = $faleConoscoDao->getFaleConoscoItem($id);
            ?>
            <div class="modal_form">
                <div class="body">
                    <div class="header clearfix">
                        <a href="#" class="fechar">×</a>
                        <h1 class="titulo">Dados do formulário</h1>
                    </div>
                    <div class="content">
                        <form action="#" id="form_fale_conosco">
                            <div class="grupo _50">
                                <label for="nome">Nome:</label>
                                <input type="text" name="nome" value="<?= $faleConosco->getNome(); ?>" disabled>
                            </div>
                            <div class="grupo _50">
                                <label for="email">Email:</label>
                                <input type="text" name="email" value="<?= $faleConosco->getEmail(); ?>" disabled>
                            </div>
                            <div class="grupo _33">
                                <label for="telefone">Telefone:</label>
                                <input type="text" name="telefone" value="<?= $faleConosco->getTelefone(); ?>" disabled>
                            </div>
                            <div class="grupo _33">
                                <label for="celular">Celular:</label>
                                <input type="text" name="celular" value="<?= $faleConosco->getCelular(); ?>" disabled>
                            </div>
                            <div class="grupo _33">
                                <label for="sexo">Sexo:</label>
                                <input type="text" name="sexo" value="<?= $faleConosco->getSexo() == "M" ? "Masculino": "Feminino"; ?>" disabled>
                            </div>
                            <div class="grupo _50">
                                <label for="profissao">Profissão:</label>
                                <input type="text" name="profissao" value="<?= $faleConosco->getProfissao(); ?>" disabled>
                            </div>
                            <div class="grupo _50">
                                <label for="home_page">Home Page:</label>
                                <input type="text" name="home_page" value="<?= $faleConosco->getHomePage(); ?>" disabled>
                            </div>
                            <div class="grupo _50">
                                <label for="facebook">Facebook:</label>
                                <input type="text" name="facebook" value="<?= $faleConosco->getFacebook(); ?>" disabled>
                            </div>
                            <div class="grupo _50">
                                <label for="produtos">Informações de Produtos:</label>
                                <input type="text" name="produtos" value="<?= $faleConosco->getProdutos(); ?>" disabled>
                            </div>
                            <div class="grupo">
                                <label for="comentarios">Sugestões / Críticas:</label>
                                <textarea name="comentarios" disabled><?= $faleConosco->getComentarios(); ?></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="footer clearfix">
                        <p class="erro"></p>
                        <a href="#" class="fechar">Fechar</a>
                    </div>
                </div>
            </div>
            <?php
        }
        
        public function excluir() {
            $id = $_GET["id"];
            $faleConoscoDao = new FaleConoscoDAO();
            $faleConoscoDao->excluir($id);
            echo $id;
        }
    }
?>