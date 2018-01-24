<?php
    require_once("database.php");

    class PromocaoDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function getPromocoes($ativo) {
            $promocoes = array();
            $result = $this->conexao->query("SELECT * FROM tbl_promocoes" . ($ativo ? " WHERE ativo = 1" : ""));
            while ($data = $result->fetch_array()) {
                $promocao = new Promocao();
                $promocao->setId($data["id"]);
                $promocao->setTitulo($data["titulo"]);
                $promocao->setImagem($data["imagem"]);
                $promocao->setTexto($data["texto"]);
                $promocao->setPrecoAntigo($data["precoAntigo"]);
                $promocao->setNovoPreco($data["novoPreco"]);
                $promocao->setAtivo($data["ativo"]);
                $promocoes[] = $promocao;
            }
            
            return $promocoes;
        }
        
        public function getPromocao($id) {
            $statement = $this->conexao->prepare("SELECT * FROM tbl_promocoes WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $promocao = new Promocao();
                $promocao->setId($data["id"]);
                $promocao->setTitulo($data["titulo"]);
                $promocao->setImagem($data["imagem"]);
                $promocao->setTexto($data["texto"]);
                $promocao->setPrecoAntigo($data["precoAntigo"]);
                $promocao->setNovoPreco($data["novoPreco"]);
                $promocao->setAtivo($data["ativo"]);
                return $promocao;
            }
        }
        
        public function gravarPromocao($promocao) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_promocoes (titulo, imagem, texto, ativo, precoAntigo, novoPreco) VALUES (?, ?, ?, ?, ?, ?)");
            $statement->bind_param("sssidd", ...array($promocao->getTitulo(), $promocao->getImagem(), $promocao->getTexto(), $promocao->getAtivo(), $promocao->getPrecoAntigo(), $promocao->getNovoPreco()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function ativarPromocao($id, $ativo) {
            $statement = $this->conexao->prepare("UPDATE tbl_promocoes SET ativo = ? WHERE id = ?");
            $statement->bind_param("ii", $ativo, $id);
            $statement->execute();
            $statement->close();
        }
        
        public function atualizarPromocao($promocao) {
            $statement = $this->conexao->prepare("UPDATE tbl_promocoes SET titulo = ?, imagem = ?, texto = ?, ativo = ?, precoAntigo = ?, novoPreco = ? WHERE id = ?");
            $statement->bind_param("sssiddi", ...array($promocao->getTitulo(), $promocao->getImagem(), $promocao->getTexto(), $promocao->getAtivo(), $promocao->getPrecoAntigo(), $promocao->getNovoPreco(), $promocao->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function excluirPromocao($id) {
            $statement = $this->conexao->prepare("DELETE FROM tbl_promocoes WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
    }
?>