<?php
    require_once("../database/pizza_do_mes_dao.php");
    require_once("../model/pizza_do_mes.php");

    class PizzaDoMesController {
        public function montarHtmlAdm($pizzaDoMes) {
            ?>
            <div class="linha" data-id="<?php echo $pizzaDoMes->getId(); ?>">
                <div class="coluna imagem">
                    <img src="../imagens/pizza_do_mes/<?php echo $pizzaDoMes->getImagemPrincipal(); ?>" alt="<?php echo $pizzaDoMes->getTitulo(); ?>">
                </div>
                <div class="coluna titulo">
                    <span><?php echo $pizzaDoMes->getTitulo(); ?></span>
                </div>
                <div class="coluna texto">
                    <p><?php echo $pizzaDoMes->getTexto(); ?></p>
                </div>
                <div class="coluna ativo">
                    <a href="../controller/router.php?tipo=pizza_do_mes&modo=ativar&id=<?php echo $pizzaDoMes->getId(); ?>" class="ativar">
                        <?php if ($pizzaDoMes->getAtivo()) { ?>
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        <?php } else { ?>
                            <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                        <?php } ?>
                    </a>
                </div>
                <div class="coluna acoes">
                    <a href="../controller/router.php?tipo=pizza_do_mes&modo=editar&id=<?php echo $pizzaDoMes->getId(); ?>" class="editar">
                        <img src="imagens/icones/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="../controller/router.php?tipo=pizza_do_mes&modo=excluir&id=<?php echo $pizzaDoMes->getId(); ?>" class="excluir" data-titulo="<?php echo $pizzaDoMes->getTitulo(); ?>">
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
                            <h1 class="titulo">Adicionar Pizza do Mês</h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=pizza_do_mes&modo=gravar" id="form_add_pizza_do_mes">
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
                                <div class="grupo _33">
                                    <p class="label">Imagem Principal:</p>
                                    <div class="upload_imagem medio">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="Imagem">
                                        <label for="imagem_1">Selecione um arquivo</label>
                                        <input type="file" name="imagem_1" accept="image/*" required>
                                    </div>
                                </div>
                                <div class="grupo _33">
                                    <p class="label">2ª Imagem (Opcional):</p>
                                    <div class="upload_imagem medio">
                                        <a href="#" class="remover" title="Remover Imagem">X</a>
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="Imagem">
                                        <label for="imagem_2">Selecione um arquivo</label>
                                        <input type="file" name="imagem_2" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo _33">
                                    <p class="label">3ª Imagem (Opcional):</p>
                                    <div class="upload_imagem medio">
                                        <a href="#" class="remover" title="Remover Imagem">X</a>
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="Imagem">
                                        <label for="imagem_3">Selecione um arquivo</label>
                                        <input type="file" name="imagem_3" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo">
                                    <label for="texto">Texto:</label>
                                    <textarea class="full" name="texto" required></textarea>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_add_pizza_do_mes">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                $id = $_GET["id"];
                $pizzaDoMesDao = new PizzaDoMesDAO();
                $pizzaDoMes = $pizzaDoMesDao->getPizzaDoMesItem($id);
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo"><?= $pizzaDoMes->getTitulo(); ?></h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=pizza_do_mes&modo=atualizar" id="form_atualizar_pizza_do_mes">
                                <input type="hidden" name="id" value="<?= $pizzaDoMes->getId(); ?>">
                                <div class="grupo _75">
                                    <label for="titulo">Título:</label>
                                    <input type="text" name="titulo" maxlength="100" value="<?= $pizzaDoMes->getTitulo(); ?>" required>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Exibição:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0" <?= $pizzaDoMes->getAtivo() == "0" ? "checked" : ""; ?>>
                                        <input type="checkbox" name="ativo" value="1" <?= $pizzaDoMes->getAtivo() == "1" ? "checked" : ""; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _33">
                                    <p class="label">Imagem Principal:</p>
                                    <div class="upload_imagem medio">
                                        <input type="hidden" class="atual" name="imagem_atual_1" value="<?= $pizzaDoMes->getImagemPrincipal(); ?>">
                                        <img src="../imagens/pizza_do_mes/<?= $pizzaDoMes->getImagemPrincipal(); ?>" alt="Imagem">
                                        <label for="imagem_1">Selecione um arquivo</label>
                                        <input type="file" name="imagem_1" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo _33">
                                    <p class="label">2ª Imagem (Opcional):</p>
                                    <div class="upload_imagem medio">
                                        <input type="hidden" class="atual" name="imagem_atual_2" value="<?= $pizzaDoMes->getImagem2(); ?>">
                                        <?php if (empty($pizzaDoMes->getImagem2())) { ?>
                                            <a href="#" class="remover" title="Remover Imagem">X</a>
                                            <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="Imagem">
                                        <?php } else { ?>
                                            <a href="#" class="remover visivel" title="Remover Imagem">X</a>
                                            <img src="../imagens/pizza_do_mes/<?= $pizzaDoMes->getImagem2(); ?>" alt="Imagem">
                                        <?php } ?>
                                        <label for="imagem_2">Selecione um arquivo</label>
                                        <input type="file" name="imagem_2" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo _33">
                                    <p class="label">3ª Imagem (Opcional):</p>
                                    <div class="upload_imagem medio">
                                        <input type="hidden" class="atual" name="imagem_atual_3" value="<?= $pizzaDoMes->getImagem3(); ?>">
                                        <?php if (empty($pizzaDoMes->getImagem3())) { ?>
                                            <a href="#" class="remover" title="Remover Imagem">X</a>
                                            <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="Imagem">
                                        <?php } else { ?>
                                            <a href="#" class="remover visivel" title="Remover Imagem">X</a>
                                            <img src="../imagens/pizza_do_mes/<?= $pizzaDoMes->getImagem3(); ?>" alt="Imagem">
                                        <?php } ?>
                                        <label for="imagem_3">Selecione um arquivo</label>
                                        <input type="file" name="imagem_3" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo">
                                    <label for="texto">Texto:</label>
                                    <textarea class="full" name="texto" required><?= $pizzaDoMes->getTexto(); ?></textarea>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_atualizar_pizza_do_mes">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        
        public function gravarPizzaDoMes() {
            $titulo = $_POST["titulo"];
            $ativo = $_POST["ativo"];
            $texto = $_POST["texto"];
            $imagens = array("", "", "");
            
            for ($i = 1; $i <= 3; $i++) {
                if ($i != 1 && empty($_FILES["imagem_$i"]["name"])) {
                    continue;
                }
                
                $arquivo = basename($_FILES["imagem_$i"]["name"]);
                $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
                $caminhoArquivo = "../imagens/pizza_do_mes/" . $nomeCriptografado;

                if ($_FILES["imagem_$i"]["error"]) {
                    echo "ERRO:Imagem $i: Erro ao enviar o arquivo. Código: " . $_FILES["imagem_$i"]["error"];
                    return;
                } elseif (!getimagesize($_FILES["imagem_$i"]["tmp_name"])) {
                    echo "ERRO:Imagem $i: Este arquivo não é uma imagem.";
                    return;
                } elseif ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
                    echo "ERRO:Imagem $i: Este tipo de imagem não é suportado.";
                    return;
                } elseif (!move_uploaded_file($_FILES["imagem_$i"]["tmp_name"], $caminhoArquivo)) {
                    echo "ERRO:Imagem $i: Erro ao enviar a imagem.";
                    return;
                }
                
                $imagens[$i - 1] = $nomeCriptografado;
            }
            
            $pizzaDoMes = new PizzaDoMes();
            $pizzaDoMes->setTitulo($titulo);
            $pizzaDoMes->setAtivo($ativo == "1");
            $pizzaDoMes->setTexto($texto);
            $pizzaDoMes->setImagemPrincipal($imagens[0]);
            $pizzaDoMes->setImagem2($imagens[1]);
            $pizzaDoMes->setImagem3($imagens[2]);
            $pizzaDoMesDao = new PizzaDoMesDAO();
            $id = $pizzaDoMesDao->gravarPizzaDoMes($pizzaDoMes);
            $pizzaDoMes->setId($id);
            $this->montarHtmlAdm($pizzaDoMes);
        }
        
        public function ativarPizzaDoMes() {
            $id = $_GET["id"];
            $ativo = $_GET["ativo"];
            
            $pizzaDoMesDao = new PizzaDoMesDAO();
            $pizzaDoMesDao->ativarPizzaDoMes($id, $ativo == "1" ? 0 : 1);
            if ($ativo == "1") {
                echo "Esta pizza foi desabilitada e não será mais exibida.";
            } else {
                echo "Esta pizza foi habilitada e agora será exibida.";
            }
        }
        
        public function atualizarPizzaDoMes() {
            $id = $_POST["id"];
            $titulo = $_POST["titulo"];
            $ativo = $_POST["ativo"];
            $texto = $_POST["texto"];
            $imagens = array($_POST["imagem_atual_1"], $_POST["imagem_atual_2"], $_POST["imagem_atual_3"]);
            
            for ($i = 1; $i <= 3; $i++) {
                if (!empty($_FILES["imagem_$i"]["name"])) {
                    $arquivo = basename($_FILES["imagem_$i"]["name"]);
                    $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                    $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                    $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
                    $caminhoArquivo = "../imagens/pizza_do_mes/" . $nomeCriptografado;

                    if ($_FILES["imagem_$i"]["error"]) {
                        echo "ERRO:Imagem $i: Erro ao enviar o arquivo. Código: " . $_FILES["imagem_$i"]["error"];
                        return;
                    } elseif (!getimagesize($_FILES["imagem_$i"]["tmp_name"])) {
                        echo "ERRO:Imagem $i: Este arquivo não é uma imagem.";
                        return;
                    } elseif ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
                        echo "ERRO:Imagem $i: Este tipo de imagem não é suportado.";
                        return;
                    } elseif (!move_uploaded_file($_FILES["imagem_$i"]["tmp_name"], $caminhoArquivo)) {
                        echo "ERRO:Imagem $i: Erro ao enviar a imagem.";
                        return;
                    }

                    $imagens[$i - 1] = $nomeCriptografado;
                }
            }
                
            $pizzaDoMes = new PizzaDoMes();
            $pizzaDoMes->setId($id);
            $pizzaDoMes->setTitulo($titulo);
            $pizzaDoMes->setAtivo($ativo == "1");
            $pizzaDoMes->setTexto($texto);
            $pizzaDoMes->setImagemPrincipal($imagens[0]);
            $pizzaDoMes->setImagem2($imagens[1]);
            $pizzaDoMes->setImagem3($imagens[2]);
            $pizzaDoMesDao = new PizzaDoMesDAO();
            $pizzaDoMesDao->atualizarPizzaDoMes($pizzaDoMes);
            $this->montarHtmlAdm($pizzaDoMes);
        }
        
        public function excluirPizzaDoMes() {
            $id = $_GET["id"];
            $pizzaDoMesDao = new PizzaDoMesDAO();
            $pizzaDoMesDao->excluirPizzaDoMes($id);
            echo $id;
        }
    }
?>