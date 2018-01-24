<?php
    require_once("../database/sobre_nos_dao.php");
    require_once("../model/sobre_nos.php");

    class SobreNosController {
        public function montarHtmlAdm($sobreNos) {
            ?>
            <div class="linha" data-id="<?php echo $sobreNos->getId(); ?>">
                <div class="coluna imagem">
                    <img src="../imagens/sobre_nos/<?php echo $sobreNos->getImagem(); ?>" alt="<?php echo $sobreNos->getTitulo(); ?>">
                </div>
                <div class="coluna titulo">
                    <span><?php echo $sobreNos->getTitulo(); ?></span>
                </div>
                <div class="coluna texto">
                    <p><?php echo $sobreNos->getTexto(); ?></p>
                </div>
                <div class="coluna ativo">
                    <a href="../controller/router.php?tipo=sobre_nos&modo=ativar&id=<?php echo $sobreNos->getId(); ?>" class="ativar">
                        <?php if ($sobreNos->getAtivo()) { ?>
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        <?php } else { ?>
                            <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                        <?php } ?>
                    </a>
                </div>
                <div class="coluna acoes">
                    <a href="../controller/router.php?tipo=sobre_nos&modo=editar&id=<?php echo $sobreNos->getId(); ?>" class="editar">
                        <img src="imagens/icones/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="../controller/router.php?tipo=sobre_nos&modo=excluir&id=<?php echo $sobreNos->getId(); ?>" class="excluir" data-titulo="<?php echo $sobreNos->getTitulo(); ?>">
                        <img src="imagens/icones/excluir.png" alt="Excluir" title="Excluir">
                    </a>
                </div>
            </div>
            <?php
        }
        
        public function getModal($isEditar) {
            if (!$isEditar) {
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo">Adicionar Sobre a Pizzaria</h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=sobre_nos&modo=gravar" id="form_add_sobre_nos">
                                <div class="grupo _75">
                                    <label for="titulo">Título:</label>
                                    <input type="text" name="titulo" maxlength="100" required>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0">
                                        <input type="checkbox" name="ativo" value="1" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _50">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="Imagem">
                                        <label for="imagem">Selecione um arquivo</label>
                                        <input type="file" name="imagem" accept="image/*" required>
                                    </div>
                                </div>
                                <div class="grupo _50">
                                    <label for="texto">Texto:</label>
                                    <textarea name="texto" required></textarea>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_add_sobre_nos">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                $id = $_GET["id"];
                $sobreNosDao = new SobreNosDAO();
                $sobreNos = $sobreNosDao->getSobreNosItem($id);
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo"><?= $sobreNos->getTitulo(); ?></h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=sobre_nos&modo=atualizar" id="form_atualizar_sobre_nos">
                                <input type="hidden" name="id" value="<?= $sobreNos->getId(); ?>">
                                <div class="grupo _75">
                                    <label for="titulo">Título:</label>
                                    <input type="text" name="titulo" maxlength="100" value="<?= $sobreNos->getTitulo(); ?>" required>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0" <?= $sobreNos->getAtivo() == "0" ? "checked" : ""; ?>>
                                        <input type="checkbox" name="ativo" value="1" <?= $sobreNos->getAtivo() == "1" ? "checked" : ""; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _50">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <input type="hidden" name="imagem_atual" value="<?= $sobreNos->getImagem(); ?>">
                                        <img src="../imagens/sobre_nos/<?= $sobreNos->getImagem(); ?>" alt="Imagem">
                                        <label for="imagem">Selecione um arquivo</label>
                                        <input type="file" name="imagem" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo _50">
                                    <label for="texto">Texto:</label>
                                    <textarea name="texto" required><?= $sobreNos->getTexto(); ?></textarea>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_atualizar_sobre_nos">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        
        public function gravarSobreNos() {
            $titulo = $_POST["titulo"];
            $ativo = $_POST["ativo"];
            $texto = $_POST["texto"];
            
            $arquivo = basename($_FILES["imagem"]["name"]);
            $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
            $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
            $caminhoArquivo = "../imagens/sobre_nos/" . $nomeCriptografado;
            
            if ($_FILES["imagem"]["error"]) {
                echo "ERRO:Erro ao enviar o arquivo. Código: " . $_FILES["imagem"]["error"];
            } elseif (!getimagesize($_FILES["imagem"]["tmp_name"])) {
                echo "ERRO:Este arquivo não é uma imagem.";
            } elseif ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
                echo "ERRO:Este tipo de imagem não é suportado.";
            } elseif (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoArquivo)) {
                echo "ERRO:Erro ao enviar a imagem.";
            } else {
                $sobreNos = new SobreNos();
                $sobreNos->setTitulo($titulo);
                $sobreNos->setImagem($nomeCriptografado);
                $sobreNos->setTexto($texto);
                $sobreNos->setAtivo($ativo == "1");
                $sobreNosDao = new SobreNosDAO();
                $id = $sobreNosDao->gravarSobreNos($sobreNos);
                $sobreNos->setId($id);
                $this->montarHtmlAdm($sobreNos);
            }
        }
        
        public function ativarSobreNos() {
            $id = $_GET["id"];
            $ativo = $_GET["ativo"];
            
            $sobreNosDao = new SobreNosDAO();
            $sobreNosDao->ativarSobreNos($id, $ativo == "1" ? 0 : 1);
            if ($ativo == "1") {
                echo "Este item foi desabilitado e não será mais exibido.";
            } else {
                echo "Este item foi habilitado e agora será exibido.";
            }
        }
        
        public function atualizarSobreNos() {
            $id = $_POST["id"];
            $titulo = $_POST["titulo"];
            $ativo = $_POST["ativo"];
            $texto = $_POST["texto"];
            $imagemAtual = $_POST["imagem_atual"];
            
            if (!empty($_FILES["imagem"]["name"])) {
                $arquivo = basename($_FILES["imagem"]["name"]);
                $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
                $caminhoArquivo = "../imagens/sobre_nos/" . $nomeCriptografado;

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
            
            $sobreNos = new SobreNos();
            $sobreNos->setId($id);
            $sobreNos->setTitulo($titulo);
            $sobreNos->setImagem($imagemAtual);
            $sobreNos->setTexto($texto);
            $sobreNos->setAtivo($ativo == "1");
            $sobreNosDao = new SobreNosDAO();
            $sobreNosDao->atualizarSobreNos($sobreNos);
            $this->montarHtmlAdm($sobreNos);
        }
        
        public function excluirSobreNos() {
            $id = $_GET["id"];
            $sobreNosDao = new SobreNosDAO();
            $sobreNosDao->excluirSobreNos($id);
            echo $id;
        }
    }
?>