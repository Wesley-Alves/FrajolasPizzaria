<?php
    require_once("database.php");

    class CuriosidadeDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function getCuriosidades($ativo) {
            $curiosidades = array();
            $result = $this->conexao->query("SELECT c.*, d.decada FROM tbl_curiosidades AS c JOIN tbl_decadas AS d ON c.idDecada = d.id " . ($ativo ? "WHERE ativo = 1 " : "") . "ORDER BY decada ASC");
            while ($data = $result->fetch_array()) {
                $curiosidade = new Curiosidade();
                $curiosidade->setId($data["id"]);
                $curiosidade->setIdDecada($data["idDecada"]);
                $curiosidade->setTitulo($data["titulo"]);
                $curiosidade->setImagem($data["imagem"]);
                $curiosidade->setTexto($data["texto"]);
                $curiosidade->setAtivo($data["ativo"]);
                $curiosidade->setDecada($data["decada"]);
                $curiosidades[] = $curiosidade;
            }
            
            return $curiosidades;
        }
        
        public function getCuriosidade($id) {
            $statement = $this->conexao->prepare("SELECT * FROM tbl_curiosidades WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $curiosidade = new Curiosidade();
                $curiosidade->setId($data["id"]);
                $curiosidade->setIdDecada($data["idDecada"]);
                $curiosidade->setTitulo($data["titulo"]);
                $curiosidade->setImagem($data["imagem"]);
                $curiosidade->setTexto($data["texto"]);
                $curiosidade->setAtivo($data["ativo"]);
                return $curiosidade;
            }
        }
        
        public function getDecadas() {
            $decadas = array();
            $result = $this->conexao->query("SELECT * FROM tbl_decadas");
            while ($data = $result->fetch_array()) {
                $decadas[] = $data;
            }
            
            return $decadas;
        }
        
        public function gravarCuriosidade($curiosidade) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_curiosidades (idDecada, titulo, imagem, texto, ativo) VALUES (?, ?, ?, ?, ?)");
            $statement->bind_param("isssi", ...array($curiosidade->getIdDecada(), $curiosidade->getTitulo(), $curiosidade->getImagem(), $curiosidade->getTexto(), $curiosidade->getAtivo()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function ativarCuriosidade($id, $ativo) {
            $statement = $this->conexao->prepare("UPDATE tbl_curiosidades SET ativo = ? WHERE id = ?");
            $statement->bind_param("ii", $ativo, $id);
            $statement->execute();
            $statement->close();
        }
        
        public function atualizarCuriosidade($curiosidade) {
            $statement = $this->conexao->prepare("UPDATE tbl_curiosidades SET idDecada = ?, titulo = ?, imagem = ?, texto = ?, ativo = ? WHERE id = ?");
            $statement->bind_param("isssii", ...array($curiosidade->getIdDecada(), $curiosidade->getTitulo(), $curiosidade->getImagem(), $curiosidade->getTexto(), $curiosidade->getAtivo(), $curiosidade->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function excluirCuriosidade($id) {
            $statement = $this->conexao->prepare("DELETE FROM tbl_curiosidades WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
    }
?>