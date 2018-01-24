<?php
    require_once("../database/imagem_slider_dao.php");
    require_once("../model/imagem_slider.php");

    class SliderController {
        public function montarHtmlAdm($imagem) {
            ?>
            <div class="linha" data-id="<?php echo $imagem->getId(); ?>">
                <div class="coluna imagem">
                    <img src="../imagens/slides/<?php echo $imagem->getImagem(); ?>" alt="<?php echo $imagem->getLegenda(); ?>">
                </div>
                <div class="coluna legenda">
                    <span><?php echo $imagem->getLegenda(); ?></span>
                </div>
                <div class="coluna ativo">
                    <a href="../controller/router.php?tipo=slider&modo=ativar&id=<?php echo $imagem->getId(); ?>" class="ativar">
                        <?php if ($imagem->getAtivo()) { ?>
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        <?php } else { ?>
                            <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                        <?php } ?>
                    </a>
                </div>
                <div class="coluna acoes">
                    <a href="../controller/router.php?tipo=slider&modo=editar&id=<?php echo $imagem->getId(); ?>" class="editar">
                        <img src="imagens/icones/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="../controller/router.php?tipo=slider&modo=excluir&id=<?php echo $imagem->getId(); ?>" class="excluir" data-titulo="<?php echo $imagem->getLegenda(); ?>">
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
                            <h1 class="titulo">Adicionar Slider</h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=slider&modo=gravar" id="form_add_slider">
                                <div class="grupo _75">
                                    <label for="legenda">Legenda:</label>
                                    <input type="text" name="legenda" maxlength="50" required>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0">
                                        <input type="checkbox" name="ativo" value="1" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _50 centro">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="Imagem">
                                        <label for="imagem">Selecione um arquivo</label>
                                        <input type="file" name="imagem" accept="image/*" required>
                                    </div>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_add_slider">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                $id = $_GET["id"];
                $imagemSliderDao = new ImagemSliderDAO();
                $imagem = $imagemSliderDao->getImagem($id);
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo"><?= $imagem->getLegenda(); ?></h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=slider&modo=atualizar" id="form_atualizar_slider">
                                <input type="hidden" name="id" value="<?= $imagem->getId(); ?>">
                                <div class="grupo _75">
                                    <label for="legenda">Legenda:</label>
                                    <input type="text" name="legenda" maxlength="50" value="<?= $imagem->getLegenda(); ?>" required>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0" <?= $imagem->getAtivo() == "0" ? "checked" : ""; ?>>
                                        <input type="checkbox" name="ativo" value="1" <?= $imagem->getAtivo() == "1" ? "checked" : ""; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _50 centro">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <input type="hidden" name="imagem_atual" value="<?= $imagem->getImagem(); ?>">
                                        <img src="../imagens/slides/<?= $imagem->getImagem(); ?>" alt="Imagem">
                                        <label for="imagem">Selecione um arquivo</label>
                                        <input type="file" name="imagem" accept="image/*">
                                    </div>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_atualizar_slider">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        
        public function gravarImagem() {
            $legenda = $_POST["legenda"];
            $ativo = $_POST["ativo"];
            
            $arquivo = basename($_FILES["imagem"]["name"]);
            $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
            $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
            $caminhoArquivo = "../imagens/slides/" . $nomeCriptografado;
            
            if ($_FILES["imagem"]["error"]) {
                echo "ERRO:Erro ao enviar o arquivo. Código: " . $_FILES["imagem"]["error"];
            } elseif (!getimagesize($_FILES["imagem"]["tmp_name"])) {
                echo "ERRO:Este arquivo não é uma imagem.";
            } elseif ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
                echo "ERRO:Este tipo de imagem não é suportado.";
            } elseif (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoArquivo)) {
                echo "ERRO:Erro ao enviar a imagem.";
            } else {
                $imagem = new ImagemSlider();
                $imagem->setImagem($nomeCriptografado);
                $imagem->setLegenda($legenda);
                $imagem->setAtivo($ativo == "1");
                $imagemSliderDao = new ImagemSliderDAO();
                $id = $imagemSliderDao->gravarImagem($imagem);
                $imagem->setId($id);
                $this->montarHtmlAdm($imagem);
            }
        }
        
        public function ativarImagem() {
            $id = $_GET["id"];
            $ativo = $_GET["ativo"];
            
            $imagemSliderDao = new ImagemSliderDAO();
            $imagemSliderDao->ativarImagem($id, $ativo == "1" ? 0 : 1);
            if ($ativo == "1") {
                echo "Esta imagem foi desabilitada e não será mais exibida.";
            } else {
                echo "Esta imagem foi habilitada e agora será exibida.";
            }
        }
        
        public function atualizarImagem() {
            $id = $_POST["id"];
            $legenda = $_POST["legenda"];
            $ativo = $_POST["ativo"];
            $imagemAtual = $_POST["imagem_atual"];
            
            if (!empty($_FILES["imagem"]["name"])) {
                $arquivo = basename($_FILES["imagem"]["name"]);
                $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
                $caminhoArquivo = "../imagens/slides/" . $nomeCriptografado;

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
            
            $imagem = new ImagemSlider();
            $imagem->setId($id);
            $imagem->setImagem($imagemAtual);
            $imagem->setLegenda($legenda);
            $imagem->setAtivo($ativo == "1");
            $imagemSliderDao = new ImagemSliderDAO();
            $imagemSliderDao->atualizarImagem($imagem);
            $this->montarHtmlAdm($imagem);
        }
        
        public function excluirImagem() {
            $id = $_GET["id"];
            $imagemSliderDao = new ImagemSliderDAO();
            $imagemSliderDao->excluirImagem($id);
            echo $id;
        }
    }
?>