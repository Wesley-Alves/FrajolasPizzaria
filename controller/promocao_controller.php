<?php
    require_once("../database/promocao_dao.php");
    require_once("../model/promocao.php");

    class PromocaoController {
        public function montarHtmlAdm($promocao) {
            ?>
            <div class="linha" data-id="<?php echo $promocao->getId(); ?>">
                <div class="coluna imagem">
                    <img src="../imagens/promocoes/<?php echo $promocao->getImagem(); ?>" alt="<?php echo $promocao->getTitulo(); ?>">
                </div>
                <div class="coluna titulo">
                    <span><?php echo $promocao->getTitulo(); ?></span>
                </div>
                <div class="coluna texto">
                    <p><?php echo $promocao->getTexto(); ?></p>
                </div>
                <div class="coluna ativo">
                    <a href="../controller/router.php?tipo=promocao&modo=ativar&id=<?php echo $promocao->getId(); ?>" class="ativar">
                        <?php if ($promocao->getAtivo()) { ?>
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        <?php } else { ?>
                            <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                        <?php } ?>
                    </a>
                </div>
                <div class="coluna acoes">
                    <a href="../controller/router.php?tipo=promocao&modo=editar&id=<?php echo $promocao->getId(); ?>" class="editar">
                        <img src="imagens/icones/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="../controller/router.php?tipo=promocao&modo=excluir&id=<?php echo $promocao->getId(); ?>" class="excluir" data-titulo="<?php echo $promocao->getTitulo(); ?>">
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
                            <h1 class="titulo">Adicionar Promoção</h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=promocao&modo=gravar" id="form_add_promocao">
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
                                    <div class="grupo subgrupo_left_top _50">
                                        <label for="preco_antigo">Preço Antigo:</label>
                                        <input type="text" name="preco_antigo" required data-original="1">
                                    </div>
                                    <div class="grupo subgrupo_right_top _50">
                                        <label for="novo_preco">Novo Preço:</label>
                                        <input type="text" name="novo_preco" required data-original="1">
                                    </div>
                                    <label for="texto">Texto:</label>
                                    <textarea class="pequena" name="texto" required></textarea>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_add_promocao">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                $id = $_GET["id"];
                $promocaoDao = new PromocaoDAO();
                $promocao = $promocaoDao->getPromocao($id);
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo"><?= $promocao->getTitulo(); ?></h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=promocao&modo=atualizar" id="form_atualizar_promocao">
                                <input type="hidden" name="id" value="<?= $promocao->getId(); ?>">
                                <div class="grupo _75">
                                    <label for="titulo">Título:</label>
                                    <input name="titulo" maxlength="100" value="<?= $promocao->getTitulo(); ?>" required>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0" <?= $promocao->getAtivo() == "0" ? "checked" : ""; ?>>
                                        <input type="checkbox" name="ativo" value="1" <?= $promocao->getAtivo() == "1" ? "checked" : ""; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _50">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <input type="hidden" name="imagem_atual" value="<?= $promocao->getImagem(); ?>">
                                        <img src="../imagens/promocoes/<?= $promocao->getImagem(); ?>" alt="Imagem">
                                        <label for="imagem">Selecione um arquivo</label>
                                        <input type="file" name="imagem" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo _50">
                                    <div class="grupo subgrupo_left_top _50">
                                        <label for="preco_antigo">Preço Antigo:</label>
                                        <input name="preco_antigo" value="<?= $promocao->getPrecoAntigo(); ?>" required data-original="1">
                                    </div>
                                    <div class="grupo subgrupo_right_top _50">
                                        <label for="novo_preco">Novo Preço:</label>
                                        <input name="novo_preco" required value="<?= $promocao->getNovoPreco(); ?>" data-original="1">
                                    </div>
                                    <label for="texto">Texto:</label>
                                    <textarea class="pequena" name="texto" required><?= $promocao->getTexto(); ?></textarea>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_atualizar_promocao">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        
        public function gravarPromocao() {
            $titulo = $_POST["titulo"];
            $ativo = $_POST["ativo"];
            $texto = $_POST["texto"];
            $precoAntigo = $_POST["preco_antigo"];
            $novoPreco = $_POST["novo_preco"];
            
            $arquivo = basename($_FILES["imagem"]["name"]);
            $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
            $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
            $caminhoArquivo = "../imagens/promocoes/" . $nomeCriptografado;
            
            if ($_FILES["imagem"]["error"]) {
                echo "ERRO:Erro ao enviar o arquivo. Código: " . $_FILES["imagem"]["error"];
            } elseif (!getimagesize($_FILES["imagem"]["tmp_name"])) {
                echo "ERRO:Este arquivo não é uma imagem.";
            } elseif ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
                echo "ERRO:Este tipo de imagem não é suportado.";
            } elseif (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoArquivo)) {
                echo "ERRO:Erro ao enviar a imagem.";
            } else {
                $promocao = new Promocao();
                $promocao->setTitulo($titulo);
                $promocao->setImagem($nomeCriptografado);
                $promocao->setTexto($texto);
                $promocao->setAtivo($ativo == "1");
                $promocao->setPrecoAntigo($precoAntigo);
                $promocao->setNovoPreco($novoPreco);
                
                $promocaoDao = new PromocaoDAO();
                $id = $promocaoDao->gravarPromocao($promocao);
                $promocao->setId($id);
                $this->montarHtmlAdm($promocao);
            }
        }
        
        public function ativarPromocao() {
            $id = $_GET["id"];
            $ativo = $_GET["ativo"];
            
            $promocaoDao = new PromocaoDAO();
            $promocaoDao->ativarPromocao($id, $ativo == "1" ? 0 : 1);
            if ($ativo == "1") {
                echo "Esta promoção foi desabilitada e não será mais exibida.";
            } else {
                echo "Esta promoção foi habilitada e agora será exibida.";
            }
        }
        
        public function atualizarPromocao() {
            $id = $_POST["id"];
            $titulo = $_POST["titulo"];
            $ativo = $_POST["ativo"];
            $texto = $_POST["texto"];
            $precoAntigo = $_POST["preco_antigo"];
            $novoPreco = $_POST["novo_preco"];
            $imagemAtual = $_POST["imagem_atual"];
            
            if (!empty($_FILES["imagem"]["name"])) {
                $arquivo = basename($_FILES["imagem"]["name"]);
                $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
                $caminhoArquivo = "../imagens/promocoes/" . $nomeCriptografado;

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
            
            $promocao = new Promocao();
            $promocao->setId($id);
            $promocao->setTitulo($titulo);
            $promocao->setImagem($imagemAtual);
            $promocao->setTexto($texto);
            $promocao->setAtivo($ativo == "1");
            $promocao->setPrecoAntigo($precoAntigo);
            $promocao->setNovoPreco($novoPreco);

            $promocaoDao = new PromocaoDAO();
            $promocaoDao->atualizarPromocao($promocao);
            $this->montarHtmlAdm($promocao);
        }
        
        public function excluirPromocao() {
            $id = $_GET["id"];
            $promocaoDao = new PromocaoDAO();
            $promocaoDao->excluirPromocao($id);
            echo $id;
        }
    }
?>