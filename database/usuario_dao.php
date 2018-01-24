<?php
    require_once("database.php");

    class UsuarioDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function autenticar($usuario, $senha) {
            $statement = $this->conexao->prepare("SELECT u.*, p.nome AS privilegio, p.permConteudo, p.permFaleConosco, p.permProdutos, p.permUsuarios FROM tbl_usuarios AS u JOIN tbl_privilegio AS p ON p.id = u.idPrivilegio WHERE u.usuario = ? AND u.senha = ? AND u.ativo = 1");
            $statement->bind_param("ss", $usuario, $senha);
            $statement->execute();
            $result = $statement->get_result();
            $data = $result->fetch_array();
            if (is_null($data)) {
                return null;
            } else {
                $usuario = new Usuario();
                $usuario->setId($data["id"]);
                $usuario->setNome($data["nome"]);
                $usuario->setEmail($data["email"]);
                $usuario->setUsuario($data["usuario"]);
                $usuario->setImagem($data["imagem"]);
                $usuario->setNomePrivilegio($data["privilegio"]);
                $usuario->setPermConteudo($data["permConteudo"]);
                $usuario->setPermFaleConosco($data["permFaleConosco"]);
                $usuario->setPermProdutos($data["permProdutos"]);
                $usuario->setPermUsuarios($data["permUsuarios"]);
                return $usuario;
            }
        }
        
        public function getUsuarios() {
            $usuarios = array();
            $result = $this->conexao->query("SELECT u.*, p.id AS idPrivilegio, p.nome AS privilegio FROM tbl_usuarios AS u JOIN tbl_privilegio AS p ON p.id = u.idPrivilegio");
            while ($data = $result->fetch_array()) {
                $usuario = new Usuario();
                $usuario->setId($data["id"]);
                $usuario->setNome($data["nome"]);
                $usuario->setEmail($data["email"]);
                $usuario->setUsuario($data["usuario"]);
                $usuario->setImagem($data["imagem"]);
                $usuario->setAtivo($data["ativo"]);
                $usuario->setIdPrivilegio($data["idPrivilegio"]);
                $usuario->setNomePrivilegio($data["privilegio"]);
                $usuarios[] = $usuario;
            }
            
            return $usuarios;
        }
        
        public function getUsuario($id) {
            $statement = $this->conexao->prepare("SELECT u.*, p.id AS idPrivilegio, p.nome AS privilegio, p.permConteudo, p.permFaleConosco, p.permProdutos, p.permUsuarios FROM tbl_usuarios AS u JOIN tbl_privilegio AS p ON p.id = u.idPrivilegio WHERE u.id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $usuario = new Usuario();
                $usuario->setId($data["id"]);
                $usuario->setNome($data["nome"]);
                $usuario->setEmail($data["email"]);
                $usuario->setUsuario($data["usuario"]);
                $usuario->setImagem($data["imagem"]);
                $usuario->setAtivo($data["ativo"]);
                $usuario->setIdPrivilegio($data["idPrivilegio"]);
                $usuario->setNomePrivilegio($data["privilegio"]);
                $usuario->setPermConteudo($data["permConteudo"]);
                $usuario->setPermFaleConosco($data["permFaleConosco"]);
                $usuario->setPermProdutos($data["permProdutos"]);
                $usuario->setPermUsuarios($data["permUsuarios"]);
                return $usuario;
            }
        }
        
        public function getPrivilegios() {
            $privilegios = array();
            $result = $this->conexao->query("SELECT id, nome FROM tbl_privilegio");
            while ($data = $result->fetch_array()) {
                $privilegios[] = $data;
            }
            
            return $privilegios;
        }
        
        public function checkUsuarioExistente($usuario) {
            $statement = $this->conexao->prepare("SELECT * FROM tbl_usuarios WHERE usuario = ?");
            $statement->bind_param("s", $usuario);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                return true;
            }
            
            return false;
        }
        
        public function gravarUsuario($usuario) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_usuarios (nome, email, usuario, senha, imagem, ativo, idPrivilegio) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $statement->bind_param("sssssii", ...array($usuario->getNome(), $usuario->getEmail(), $usuario->getUsuario(), $usuario->getSenha(), $usuario->getImagem(), $usuario->getAtivo(), $usuario->getIdPrivilegio()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function ativarUsuario($id, $ativo) {
            $statement = $this->conexao->prepare("UPDATE tbl_usuarios SET ativo = ? WHERE id = ?");
            $statement->bind_param("ii", $ativo, $id);
            $statement->execute();
            $statement->close();
        }
        
        public function atualizarUsuario($usuario) {
            $statement = $this->conexao->prepare("UPDATE tbl_usuarios SET nome = ?, email = ?, usuario = ?, imagem = ?, ativo = ?, idPrivilegio = ? WHERE id = ?");
            $statement->bind_param("ssssiii", ...array($usuario->getNome(), $usuario->getEmail(), $usuario->getUsuario(), $usuario->getImagem(), $usuario->getAtivo(), $usuario->getIdPrivilegio(), $usuario->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function atualizarSenha($usuario) {
            $statement = $this->conexao->prepare("UPDATE tbl_usuarios SET senha = ? WHERE id = ?");
            $statement->bind_param("si", ...array($usuario->getSenha(), $usuario->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function excluirUsuario($id) {
            $statement = $this->conexao->prepare("DELETE FROM tbl_usuarios WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
    }
?>