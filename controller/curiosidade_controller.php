<?php
    require_once("../database/curiosidade_dao.php");
    require_once("../model/curiosidade.php");

    class CuriosidadeController {
        public function montarHtmlAdm($curiosidade) {
            ?>
            <div class="linha" data-id="<?php echo $curiosidade->getId(); ?>">
                <div class="coluna imagem">
                    <img src="../imagens/curiosidades/<?php echo $curiosidade->getImagem(); ?>" alt="<?php echo $curiosidade->getTitulo(); ?>">
                </div>
                <div class="coluna titulo">
                    <span><?php echo $curiosidade->getTitulo(); ?></span>
                </div>
                <div class="coluna texto">
                    <p><?php echo $curiosidade->getTexto(); ?></p>
                </div>
                <div class="coluna ativo">
                    <a href="../controller/router.php?tipo=curiosidade&modo=ativar&id=<?php echo $curiosidade->getId(); ?>" class="ativar">
                        <?php if ($curiosidade->getAtivo()) { ?>
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        <?php } else { ?>
                            <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                        <?php } ?>
                    </a>
                </div>
                <div class="coluna acoes">
                    <a href="../controller/router.php?tipo=curiosidade&modo=editar&id=<?php echo $curiosidade->getId(); ?>" class="editar">
                        <img src="imagens/icones/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="../controller/router.php?tipo=curiosidade&modo=excluir&id=<?php echo $curiosidade->getId(); ?>" class="excluir" data-titulo="<?php echo $curiosidade->getTitulo(); ?>">
                        <img src="imagens/icones/excluir.png" alt="Excluir" title="Excluir">
                    </a>
                </div>
            </div>
            <?php
        }
        
        public function getModal($isEditar) {
            $curiosidadeDao = new CuriosidadeDAO();
            $decadas = $curiosidadeDao->getDecadas();
            if (!$isEditar) {
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo">Adicionar Curiosidade</h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=curiosidade&modo=gravar" id="form_add_curiosidade">
                                <div class="grupo _50">
                                    <label for="titulo">Título:</label>
                                    <input type="text" name="titulo" maxlength="100" required>
                                </div>
                                <div class="grupo _25">
                                    <label for="decada">Década:</label>
                                    <select name="decada" required>
                                        <?php foreach ($decadas as $decada) { ?>
                                            <option value="<?= $decada["id"]; ?>">
                                                Anos <?= $decada["decada"]; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
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
                            <a href="#" class="form_submit" data-form="#form_add_curiosidade">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                $id = $_GET["id"];
                $curiosidade = $curiosidadeDao->getCuriosidade($id);
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo"><?= $curiosidade->getTitulo(); ?></h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=curiosidade&modo=atualizar" id="form_atualizar_curiosidade">
                                <input type="hidden" name="id" value="<?= $curiosidade->getId(); ?>">
                                <div class="grupo _50">
                                    <label for="titulo">Título:</label>
                                    <input type="text" name="titulo" maxlength="100" value="<?= $curiosidade->getTitulo(); ?>" required>
                                </div>
                                <div class="grupo _25">
                                    <label for="decada">Década:</label>
                                    <select name="decada" required>
                                        <?php foreach ($decadas as $decada) { ?>
                                            <option value="<?= $decada["id"]; ?>" <?= $decada["id"] == $curiosidade->getIdDecada() ? "selected" : ""; ?>>
                                                Anos <?= $decada["decada"]; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0" <?= $curiosidade->getAtivo() == "0" ? "checked" : ""; ?>>
                                        <input type="checkbox" name="ativo" value="1" <?= $curiosidade->getAtivo() == "1" ? "checked" : ""; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _50">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <input type="hidden" name="imagem_atual" value="<?= $curiosidade->getImagem(); ?>">
                                        <img src="../imagens/curiosidades/<?= $curiosidade->getImagem(); ?>" alt="Imagem">
                                        <label for="imagem">Selecione um arquivo</label>
                                        <input type="file" name="imagem" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo _50">
                                    <label for="texto">Texto:</label>
                                    <textarea name="texto" required><?= $curiosidade->getTexto(); ?></textarea>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_atualizar_curiosidade">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        
        public function gravarCuriosidade() {
            $titulo = $_POST["titulo"];
            $decada = $_POST["decada"];
            $ativo = $_POST["ativo"];
            $texto = $_POST["texto"];
            
            $arquivo = basename($_FILES["imagem"]["name"]);
            $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
            $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
            $caminhoArquivo = "../imagens/curiosidades/" . $nomeCriptografado;
            
            if ($_FILES["imagem"]["error"]) {
                echo "ERRO:Erro ao enviar o arquivo. Código: " . $_FILES["imagem"]["error"];
            } elseif (!getimagesize($_FILES["imagem"]["tmp_name"])) {
                echo "ERRO:Este arquivo não é uma imagem.";
            } elseif ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
                echo "ERRO:Este tipo de imagem não é suportado.";
            } elseif (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoArquivo)) {
                echo "ERRO:Erro ao enviar a imagem.";
            } else {
                $curiosidade = new Curiosidade();
                $curiosidade->setIdDecada($decada);
                $curiosidade->setTitulo($titulo);
                $curiosidade->setImagem($nomeCriptografado);
                $curiosidade->setTexto($texto);
                $curiosidade->setAtivo($ativo == "1");
                $curiosidadeDao = new CuriosidadeDAO();
                $id = $curiosidadeDao->gravarCuriosidade($curiosidade);
                $curiosidade->setId($id);
                $this->montarHtmlAdm($curiosidade);
            }
        }
        
        public function ativarCuriosidade() {
            $id = $_GET["id"];
            $ativo = $_GET["ativo"];
            
            $curiosidadeDao = new CuriosidadeDAO();
            $curiosidadeDao->ativarCuriosidade($id, $ativo == "1" ? 0 : 1);
            if ($ativo == "1") {
                echo "Esta curiosidade foi desabilitada e não será mais exibida.";
            } else {
                echo "Esta curiosidade foi habilitada e agora será exibida.";
            }
        }
        
        public function atualizarCuriosidade() {
            $id = $_POST["id"];
            $titulo = $_POST["titulo"];
            $decada = $_POST["decada"];
            $ativo = $_POST["ativo"];
            $texto = $_POST["texto"];
            $imagemAtual = $_POST["imagem_atual"];
            
            if (!empty($_FILES["imagem"]["name"])) {
                $arquivo = basename($_FILES["imagem"]["name"]);
                $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
                $caminhoArquivo = "../imagens/curiosidades/" . $nomeCriptografado;

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
                
            $curiosidade = new Curiosidade();
            $curiosidade->setId($id);
            $curiosidade->setIdDecada($decada);
            $curiosidade->setTitulo($titulo);
            $curiosidade->setImagem($imagemAtual);
            $curiosidade->setTexto($texto);
            $curiosidade->setAtivo($ativo == "1");
            $curiosidadeDao = new CuriosidadeDAO();
            $curiosidadeDao->atualizarCuriosidade($curiosidade);
            $this->montarHtmlAdm($curiosidade);
        }
        
        public function excluirCuriosidade() {
            $id = $_GET["id"];
            $curiosidadeDao = new CuriosidadeDAO();
            $curiosidadeDao->excluirCuriosidade($id);
            echo $id;
        }
    }
?>