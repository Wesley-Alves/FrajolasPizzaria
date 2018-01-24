<?php
    require_once("database.php");

    class SobreNosDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function getSobreNos($ativo) {
            $sobreNos = array();
            $result = $this->conexao->query("SELECT * FROM tbl_sobre_nos" . ($ativo ? " WHERE ativo = 1" : ""));
            while ($data = $result->fetch_array()) {
                $sobreNosItem = new SobreNos();
                $sobreNosItem->setId($data["id"]);
                $sobreNosItem->setTitulo($data["titulo"]);
                $sobreNosItem->setImagem($data["imagem"]);
                $sobreNosItem->setTexto($data["texto"]);
                $sobreNosItem->setAtivo($data["ativo"]);
                $sobreNos[] = $sobreNosItem;
            }
            
            return $sobreNos;
        }
        
        public function getSobreNosItem($id) {
            $statement = $this->conexao->prepare("SELECT * FROM tbl_sobre_nos WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $sobreNosItem = new SobreNos();
                $sobreNosItem->setId($data["id"]);
                $sobreNosItem->setTitulo($data["titulo"]);
                $sobreNosItem->setImagem($data["imagem"]);
                $sobreNosItem->setTexto($data["texto"]);
                $sobreNosItem->setAtivo($data["ativo"]);
                return $sobreNosItem;
            }
        }
        
        public function gravarSobreNos($sobreNos) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_sobre_nos (titulo, imagem, texto, ativo) VALUES (?, ?, ?, ?)");
            $statement->bind_param("sssi", ...array($sobreNos->getTitulo(), $sobreNos->getImagem(), $sobreNos->getTexto(), $sobreNos->getAtivo()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function ativarSobreNos($id, $ativo) {
            $statement = $this->conexao->prepare("UPDATE tbl_sobre_nos SET ativo = ? WHERE id = ?");
            $statement->bind_param("ii", $ativo, $id);
            $statement->execute();
            $statement->close();
        }
        
        public function atualizarSobreNos($sobreNos) {
            $statement = $this->conexao->prepare("UPDATE tbl_sobre_nos SET titulo = ?, imagem = ?, texto = ?, ativo = ? WHERE id = ?");
            $statement->bind_param("sssii", ...array($sobreNos->getTitulo(), $sobreNos->getImagem(), $sobreNos->getTexto(), $sobreNos->getAtivo(), $sobreNos->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function excluirSobreNos($id) {
            $statement = $this->conexao->prepare("DELETE FROM tbl_sobre_nos WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
    }
?>