<?php
    require_once("../database/ambiente_dao.php");
    require_once("../model/ambiente.php");

    class AmbienteController {
        public function montarHtmlAdm($ambiente) {
            ?>
            <div class="linha" data-id="<?php echo $ambiente->getId(); ?>">
                <div class="coluna imagem">
                    <img src="../imagens/ambientes/<?php echo $ambiente->getImagem(); ?>" alt="<?php echo $ambiente->getCidade(); ?>">
                </div>
                <div class="coluna endereco">
                    <span>
                        <p><?php echo $ambiente->getLogradouro(); ?> nº <?php echo $ambiente->getNumero(); ?></p>
                        <p>CEP <?php echo $ambiente->getCep(); ?> - <?php echo $ambiente->getBairro(); ?></p>
                        <p><?php echo $ambiente->getCidade(); ?> - <?php echo $ambiente->getEstado(); ?></p>
                    </span>
                </div>
                <div class="coluna telefone">
                    <p><?php echo $ambiente->getTelefone(); ?> <?php echo $ambiente->getOperadora() == "N/A" ? "" : "(" . $ambiente->getOperadora() . ")"; ?></p>
                </div>
                <div class="coluna ativo">
                    <a href="../controller/router.php?tipo=ambiente&modo=ativar&id=<?php echo $ambiente->getId(); ?>" class="ativar">
                        <?php if ($ambiente->getAtivo()) { ?>
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        <?php } else { ?>
                            <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                        <?php } ?>
                    </a>
                </div>
                <div class="coluna acoes">
                    <a href="../controller/router.php?tipo=ambiente&modo=editar&id=<?php echo $ambiente->getId(); ?>" class="editar">
                        <img src="imagens/icones/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="../controller/router.php?tipo=ambiente&modo=excluir&id=<?php echo $ambiente->getId(); ?>" class="excluir" data-titulo="<?php echo $ambiente->getCidade(); ?> - <?php echo $ambiente->getUf(); ?>">
                        <img src="imagens/icones/excluir.png" alt="Excluir" title="Excluir">
                    </a>
                </div>
            </div>
            <?php
        }
        
        public function getModal($isEditar) {
            $ambienteDao = new AmbienteDAO();
            $estados = $ambienteDao->getEstados();
            $operadoras = $ambienteDao->getOperadoras();
            if (!$isEditar) {
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo">Adicionar Ambiente</h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=ambiente&modo=gravar" id="form_add_ambiente">
                                <div class="grupo _60">
                                    <label for="logradouro">Logradouro:</label>
                                    <input type="text" name="logradouro" maxlength="250" required>
                                </div>
                                <div class="grupo _15">
                                    <label for="numero">Número:</label>
                                    <input type="text" name="numero" maxlength="4" required>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0">
                                        <input type="checkbox" name="ativo" value="1" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _35">
                                    <label for="estado">Estado:</label>
                                    <select name="estado" required>
                                        <option label=" " hidden></option>
                                        <?php
                                            foreach ($estados as $estado) {
                                                echo "<option value=\"{$estado["id"]}\">{$estado["estado"]}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="grupo _40">
                                    <label for="cidade">Cidade:</label>
                                    <select name="cidade" required>
                                        <option value="">...</option>
                                    </select>
                                </div>
                                <div class="grupo _25">
                                    <label for="cep">CEP:</label>
                                    <input type="text" name="cep" maxlength="9" placeholder="XXXXX-XXX" required>
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
                                    <label for="bairro">Bairro:</label>
                                    <input type="text" name="bairro" maxlength="100" required>
                                    <div class="grupo _60 subgrupo_left">
                                        <label for="telefone">Telefone:</label>
                                        <input type="text" name="telefone" maxlength="15" placeholder="(XX) XXXX-XXXX" required>
                                    </div>
                                    <div class="grupo _40 subgrupo_right">
                                        <label for="operadora">Operadora:</label>
                                        <select name="operadora" required>
                                            <?php
                                                foreach ($operadoras as $operadora) {
                                                    echo "<option value=\"{$operadora["id"]}\">{$operadora["operadora"]}</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_add_ambiente">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                $id = $_GET["id"];
                $ambiente = $ambienteDao->getAmbiente($id);
                $cidades = $ambienteDao->getCidades($ambiente->getIdEstado());
                $idEstado = $ambiente->getIdEstado();
                $idCidade = $ambiente->getIdCidade();
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo"><?= $ambiente->getCidade(); ?> - <?= $ambiente->getEstado(); ?></h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=ambiente&modo=atualizar" id="form_atualizar_ambiente">
                                <input type="hidden" name="id" value="<?= $ambiente->getId(); ?>">
                                <input type="hidden" name="id_endereco" value="<?= $ambiente->getIdEndereco(); ?>">
                                <div class="grupo _60">
                                    <label for="logradouro">Logradouro:</label>
                                    <input type="text" name="logradouro" maxlength="250" value="<?= $ambiente->getLogradouro(); ?>" required>
                                </div>
                                <div class="grupo _15">
                                    <label for="numero">Número:</label>
                                    <input type="text" name="numero" maxlength="4" value="<?= $ambiente->getNumero(); ?>" required>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0" <?= $ambiente->getAtivo() == "0" ? "checked" : ""; ?>>
                                        <input type="checkbox" name="ativo" value="1" <?= $ambiente->getAtivo() == "1" ? "checked" : ""; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _35">
                                    <label for="estado">Estado:</label>
                                    <select name="estado" required>
                                        <?php
                                            foreach ($estados as $estado) {
                                                echo "<option value=\"{$estado["id"]}\"" . ($estado["id"] == $idEstado ? "selected" : "") . ">{$estado["estado"]}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="grupo _40">
                                    <label for="cidade">Cidade:</label>
                                    <select name="cidade" required>
                                        <?php
                                            foreach ($cidades as $cidade) {
                                                echo "<option value=\"{$cidade["id"]}\"" . ($cidade["id"] == $idCidade ? "selected" : "") . ">{$cidade["cidade"]}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="grupo _25">
                                    <label for="cep">CEP:</label>
                                    <input type="text" name="cep" maxlength="9" value="<?= $ambiente->getCep(); ?>" required>
                                </div>
                                <div class="grupo _50">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <input type="hidden" name="imagem_atual" value="<?= $ambiente->getImagem(); ?>">
                                        <img src="../imagens/ambientes/<?= $ambiente->getImagem(); ?>" alt="Imagem">
                                        <label for="imagem">Selecione um arquivo</label>
                                        <input type="file" name="imagem" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo _50">
                                    <label for="bairro">Bairro:</label>
                                    <input type="text" name="bairro" maxlength="100" value="<?= $ambiente->getBairro(); ?>" required>
                                    <div class="grupo _60 subgrupo_left">
                                        <label for="telefone">Telefone:</label>
                                        <input type="text" name="telefone" maxlength="15" value="<?= $ambiente->getTelefone(); ?>" required>
                                    </div>
                                    <div class="grupo _40 subgrupo_right">
                                        <label for="operadora">Operadora:</label>
                                        <select name="operadora" required>
                                            <?php
                                                foreach ($operadoras as $operadora) {
                                                    echo "<option value=\"{$operadora["id"]}\"" . ($operadora["operadora"] == $ambiente->getOperadora() ? "selected" : "") . ">{$operadora["operadora"]}</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_atualizar_ambiente">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        
        public function getCidades() {
            $id = $_GET["id"];
            $ambienteDao = new AmbienteDAO();
            $cidades = $ambienteDao->getCidades($id);
            foreach ($cidades as $cidade) {
                echo "<option value=\"{$cidade["id"]}\">{$cidade["cidade"]}</option>";
            }
        }
        
        public function gravarAmbiente() {
            $logradouro = $_POST["logradouro"];
            $numero = $_POST["numero"];
            $ativo = $_POST["ativo"];
            $cidade = $_POST["cidade"];
            $cep = $_POST["cep"];
            $bairro = $_POST["bairro"];
            $telefone = $_POST["telefone"];
            $operadora = $_POST["operadora"];
            
            $arquivo = basename($_FILES["imagem"]["name"]);
            $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
            $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
            $caminhoArquivo = "../imagens/ambientes/" . $nomeCriptografado;
            
            if ($_FILES["imagem"]["error"]) {
                echo "ERRO:Erro ao enviar o arquivo. Código: " . $_FILES["imagem"]["error"];
            } elseif (!getimagesize($_FILES["imagem"]["tmp_name"])) {
                echo "ERRO:Este arquivo não é uma imagem.";
            } elseif ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
                echo "ERRO:Este tipo de imagem não é suportado.";
            } elseif (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoArquivo)) {
                echo "ERRO:Erro ao enviar a imagem.";
            } else {
                $ambiente = new Ambiente();
                $ambiente->setLogradouro($logradouro);
                $ambiente->setNumero($numero);
                $ambiente->setAtivo($ativo);
                $ambiente->setIdCidade($cidade);
                $ambiente->setCep($cep);
                $ambiente->setBairro($bairro);
                $ambiente->setTelefone($telefone);
                $ambiente->setIdOperadora($operadora);
                $ambiente->setImagem($nomeCriptografado);
                
                $ambienteDao = new AmbienteDao();
                $idEndereco = $ambienteDao->gravarEndereco($ambiente);
                $ambiente->setIdEndereco($idEndereco);
                
                $id = $ambienteDao->gravarAmbiente($ambiente);
                $ambiente = $ambienteDao->getAmbiente($id);
                $this->montarHtmlAdm($ambiente);
            }
        }
        
        public function ativarAmbiente() {
            $id = $_GET["id"];
            $ativo = $_GET["ativo"];
            
            $ambienteDao = new AmbienteDao();
            $ambienteDao->ativarAmbiente($id, $ativo == "1" ? 0 : 1);
            if ($ativo == "1") {
                echo "Este ambiente foi desabilitado e não será mais exibido.";
            } else {
                echo "Este ambiente foi habilitado e agora será exibido.";
            }
        }
        
        public function atualizarAmbiente() {
            $id = $_POST["id"];
            $idEndereco = $_POST["id_endereco"];
            $logradouro = $_POST["logradouro"];
            $numero = $_POST["numero"];
            $ativo = $_POST["ativo"];
            $cidade = $_POST["cidade"];
            $cep = $_POST["cep"];
            $bairro = $_POST["bairro"];
            $telefone = $_POST["telefone"];
            $operadora = $_POST["operadora"];
            $imagemAtual = $_POST["imagem_atual"];
            
            if (!empty($_FILES["imagem"]["name"])) {
                $arquivo = basename($_FILES["imagem"]["name"]);
                $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
                $caminhoArquivo = "../imagens/ambientes/" . $nomeCriptografado;

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
            
            $ambiente = new Ambiente();
            $ambiente->setId($id);
            $ambiente->setIdEndereco($id);
            $ambiente->setLogradouro($logradouro);
            $ambiente->setNumero($numero);
            $ambiente->setAtivo($ativo);
            $ambiente->setIdCidade($cidade);
            $ambiente->setCep($cep);
            $ambiente->setBairro($bairro);
            $ambiente->setTelefone($telefone);
            $ambiente->setIdOperadora($operadora);
            $ambiente->setImagem($imagemAtual);

            $ambienteDao = new AmbienteDao();
            $ambienteDao->atualizarEndereco($ambiente);
            $ambienteDao->atualizarAmbiente($ambiente);
            $ambiente = $ambienteDao->getAmbiente($id);
            $this->montarHtmlAdm($ambiente);
        }
        
        public function excluirAmbiente() {
            $id = $_GET["id"];
            $ambienteDao = new AmbienteDao();
            $ambienteDao->excluirAmbiente($id);
            echo $id;
        }
    }
?>