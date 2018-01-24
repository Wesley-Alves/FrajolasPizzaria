<?php
    require_once("../database/usuario_dao.php");
    require_once("../model/usuario.php");
    @session_start();

    class UsuarioController {
        public function autenticar() {
            $usuario = $_POST["nome_usuario"];
            $senha = $_POST["senha"];
            
            $usuarioDao = new UsuarioDAO();
            $usuario = $usuarioDao->autenticar($usuario, $senha);
            if (is_null($usuario)) {
                echo "Usuário ou senha incorretos.";
            } else {
                $_SESSION["usuario"] = $usuario;
                echo "SUCCESS";
            }
        }
        
        public function montarHtmlAdm($usuario) {
            ?>
            <div class="linha" data-id="<?php echo $usuario->getId(); ?>">
                <div class="coluna imagem_medio">
                    <img src="../imagens/usuarios/<?php echo $usuario->getImagem(); ?>">
                </div>
                <div class="coluna nome">
                    <span><?php echo $usuario->getNome(); ?></span>
                </div>
                <div class="coluna email_grande">
                    <span><?php echo $usuario->getEmail(); ?></span>
                </div>
                <div class="coluna privilegio">
                    <p><?php echo $usuario->getNomePrivilegio(); ?></p>
                </div>
                
                <div class="coluna ativo">
                    <a href="../controller/router.php?tipo=usuario&modo=ativar&id=<?php echo $usuario->getId(); ?>" class="ativar">
                        <?php if ($usuario->getAtivo()) { ?>
                            <img src="imagens/icones/habilitado.png" alt="Habilitado" title="Habilitado" data-ativo="1">
                        <?php } else { ?>
                            <img src="imagens/icones/desabilitado.png" alt="Desabilitado" title="Desabilitado" data-ativo="0">
                        <?php } ?>
                    </a>
                </div>
                <div class="coluna acoes">
                    <a href="../controller/router.php?tipo=usuario&modo=editar&id=<?php echo $usuario->getId(); ?>" class="editar">
                        <img src="imagens/icones/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="../controller/router.php?tipo=usuario&modo=excluir&id=<?php echo $usuario->getId(); ?>" class="excluir" data-titulo="<?php echo $usuario->getNome(); ?>">
                        <img src="imagens/icones/excluir.png" alt="Excluir" title="Excluir">
                    </a>
                </div>
            </div>
            <?php
        }
        
        public function getModal($isEditar) {
            $usuarioDao = new UsuarioDAO();
            $privilegios = $usuarioDao->getPrivilegios();
            if (!$isEditar) {
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo">Adicionar Usuário</h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=usuario&modo=gravar" id="form_add_usuario">
                                <div class="grupo _75">
                                    <label for="nome">Nome:</label>
                                    <input type="text" name="nome" maxlength="100" required>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Ativo:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0">
                                        <input type="checkbox" name="ativo" value="1" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _20">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="Imagem">
                                        <label for="imagem">Selecione</label>
                                        <input type="file" name="imagem" accept="image/*" required>
                                    </div>
                                </div>
                                <div class="grupo _80 nopadding">
                                    <div class="grupo _50">
                                        <label for="email">Email:</label>
                                        <input type="email" name="email" maxlength="100" required>
                                    </div>
                                    <div class="grupo _50">
                                        <label for="privilegio">Privilégio:</label>
                                        <select name="privilegio" required>
                                            <?php foreach ($privilegios as $privilegio) { ?>
                                                <option value="<?= $privilegio["id"]; ?>"><?= $privilegio["nome"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="grupo _50">
                                        <label for="usuario">Nome de usuário:</label>
                                        <input type="text" name="usuario" maxlength="30" required>
                                    </div>
                                    <div class="grupo _50">
                                        <label for="senha">Senha:</label>
                                        <input type="password" name="senha" maxlength="30" required>
                                    </div>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_add_usuario">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                $id = $_GET["id"];
                $usuario = $usuarioDao->getUsuario($id);
                ?>
                <div class="modal_form">
                    <div class="body">
                        <div class="header clearfix">
                            <a href="#" class="fechar">×</a>
                            <h1 class="titulo"><?= $usuario->getNome(); ?></h1>
                        </div>
                        <div class="content">
                            <form action="../controller/router.php?tipo=usuario&modo=atualizar" id="form_atualizar_usuario">
                                <input type="hidden" name="id" value="<?= $usuario->getId(); ?>">
                                <div class="grupo _75">
                                    <label for="nome">Nome:</label>
                                    <input type="text" name="nome" maxlength="100" value="<?= $usuario->getNome(); ?>" required>
                                </div>
                                <div class="grupo _25">
                                    <p class="label">Ativo:</p>
                                    <label class="switch">
                                        <input type="hidden" name="ativo" value="0" <?= $usuario->getAtivo() == "0" ? "checked" : ""; ?>>
                                        <input type="checkbox" name="ativo" value="1" <?= $usuario->getAtivo() == "1" ? "checked" : ""; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="grupo _20">
                                    <p class="label">Imagem:</p>
                                    <div class="upload_imagem">
                                        <input type="hidden" name="imagem_atual" value="<?= $usuario->getImagem(); ?>">
                                        <img src="../imagens/usuarios/<?= $usuario->getImagem(); ?>" alt="Imagem">
                                        <label for="imagem">Selecione</label>
                                        <input type="file" name="imagem" accept="image/*">
                                    </div>
                                </div>
                                <div class="grupo _80 nopadding">
                                    <div class="grupo _50">
                                        <label for="email">Email:</label>
                                        <input type="email" name="email" maxlength="100" value="<?= $usuario->getEmail(); ?>" required>
                                    </div>
                                    <div class="grupo _50">
                                        <label for="privilegio">Privilégio:</label>
                                        <select name="privilegio" required>
                                            <?php foreach ($privilegios as $privilegio) { ?>
                                                <option value="<?= $privilegio["id"]; ?>" <?= $privilegio["id"] == $usuario->getIdPrivilegio() ? "selected" : ""; ?>>
                                                    <?= $privilegio["nome"]; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="grupo _50">
                                        <input type="hidden" name="usuario_atual" value="<?= $usuario->getUsuario(); ?>">
                                        <label for="usuario">Nome de usuário:</label>
                                        <input type="text" name="usuario" maxlength="30" value="<?= $usuario->getUsuario(); ?>" required>
                                    </div>
                                    <div class="grupo _50">
                                        <label for="senha">Senha:</label>
                                        <input type="password" name="senha" maxlength="30" placeholder="(não alterado)">
                                    </div>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="footer clearfix">
                            <p class="erro"></p>
                            <a href="#" class="form_submit" data-form="#form_atualizar_usuario">Salvar</a>
                            <a href="#" class="fechar">Cancelar</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        
        public function gravarUsuario() {
            $nome = $_POST["nome"];
            $ativo = $_POST["ativo"];
            $email = $_POST["email"];
            $privilegio = $_POST["privilegio"];
            $nomeUsuario = $_POST["usuario"];
            $senha = $_POST["senha"];
            
            $usuarioDao = new UsuarioDAO();
            if ($usuarioDao->checkUsuarioExistente($nomeUsuario)) {
                echo "ERRO:Nome de usuário já cadastrado.";
            } else {
                $arquivo = basename($_FILES["imagem"]["name"]);
                $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
                $caminhoArquivo = "../imagens/usuarios/" . $nomeCriptografado;

                if ($_FILES["imagem"]["error"]) {
                    echo "ERRO:Erro ao enviar o arquivo. Código: " . $_FILES["imagem"]["error"];
                } elseif (!getimagesize($_FILES["imagem"]["tmp_name"])) {
                    echo "ERRO:Este arquivo não é uma imagem.";
                } elseif ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
                    echo "ERRO:Este tipo de imagem não é suportado.";
                } elseif (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoArquivo)) {
                    echo "ERRO:Erro ao enviar a imagem.";
                } else {
                    $usuario = new Usuario();
                    $usuario->setNome($nome);
                    $usuario->setAtivo($ativo == "1");
                    $usuario->setImagem($nomeCriptografado);
                    $usuario->setEmail($email);
                    $usuario->setIdPrivilegio($privilegio);
                    $usuario->setUsuario($nomeUsuario);
                    $usuario->setSenha($senha);
                    $id = $usuarioDao->gravarUsuario($usuario);
                    $usuario = $usuarioDao->getUsuario($id);
                    $this->montarHtmlAdm($usuario);
                }
            }
        }
        
        public function ativarUsuario() {
            $id = $_GET["id"];
            $ativo = $_GET["ativo"];
            
            if ($_SESSION["usuario"]->getId() == $id) {
                echo "ERRO:Você não pode se auto desativar.";
            } else {
                $usuarioDao = new UsuarioDAO();
                $usuarioDao->ativarUsuario($id, $ativo == "1" ? 0 : 1);
                if ($ativo == "1") {
                    echo "Este usuário foi desabilitado e não poderá mais logar.";
                } else {
                    echo "Este usuário foi habilitado e agora poderá logar normalmente.";
                }
            }
        }
        
        public function atualizarUsuario() {
            $id = $_POST["id"];
            $nome = $_POST["nome"];
            $ativo = $_POST["ativo"];
            $email = $_POST["email"];
            $privilegio = $_POST["privilegio"];
            $nomeUsuario = $_POST["usuario"];
            $senha = $_POST["senha"];
            $usuarioAtual = $_POST["usuario_atual"];
            $imagemAtual = $_POST["imagem_atual"];
            
            $usuarioDao = new UsuarioDAO();
            if (strtolower($nomeUsuario) != strtolower($usuarioAtual) && $usuarioDao->checkUsuarioExistente($nomeUsuario)) {
                echo "ERRO:Nome de usuário já cadastrado.";
            } else if ($_SESSION["usuario"]->getId() == $id && $ativo != "1") {
                echo "ERRO:Você não pode se auto desativar.";
            } else {
                if (!empty($_FILES["imagem"]["name"])) {
                    $arquivo = basename($_FILES["imagem"]["name"]);
                    $nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                    $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                    $nomeCriptografado = md5($nomeArquivo . uniqid()) . "." . $extensao;
                    $caminhoArquivo = "../imagens/usuarios/" . $nomeCriptografado;

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
                
                $usuario = new Usuario();
                $usuario->setId($id);
                $usuario->setNome($nome);
                $usuario->setAtivo($ativo == "1");
                $usuario->setImagem($imagemAtual);
                $usuario->setEmail($email);
                $usuario->setIdPrivilegio($privilegio);
                $usuario->setUsuario($nomeUsuario);
                $usuarioDao->atualizarUsuario($usuario);
                if (!empty($senha)) {
                    $usuario->setSenha($senha);
                    $usuarioDao->atualizarSenha($usuario);
                }
                
                $usuario = $usuarioDao->getUsuario($id);
                if ($_SESSION["usuario"]->getId() == $id) {
                    $_SESSION["usuario"] = $usuario;
                }
                
                $this->montarHtmlAdm($usuario);
            }
        }
        
        public function excluirUsuario() {
            $id = $_GET["id"];
            if ($_SESSION["usuario"]->getId() == $id) {
                echo "ERRO:Você não pode se auto excluir.";
            } else {
                $usuarioDao = new UsuarioDAO();
                $usuarioDao->excluirUsuario($id);
                echo $id;
            }
        }
    }
?>