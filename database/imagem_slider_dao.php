<?php
    require_once("database.php");

    class ImagemSliderDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function getImagens($ativo) {
            $imagens = array();
            $result = $this->conexao->query("SELECT * FROM tbl_imagem_slider" . ($ativo ? " WHERE ativo = 1 " : ""));
            while ($data = $result->fetch_array()) {
                $imagem = new ImagemSlider();
                $imagem->setId($data["id"]);
                $imagem->setImagem($data["imagem"]);
                $imagem->setLegenda($data["legenda"]);
                $imagem->setAtivo($data["ativo"]);
                $imagens[] = $imagem;
            }
            
            return $imagens;
        }
        
        public function getImagem($id) {
            $statement = $this->conexao->prepare("SELECT * FROM tbl_imagem_slider WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $imagem = new ImagemSlider();
                $imagem->setId($data["id"]);
                $imagem->setImagem($data["imagem"]);
                $imagem->setLegenda($data["legenda"]);
                $imagem->setAtivo($data["ativo"]);
                return $imagem;
            }
        }
        
        public function gravarImagem($imagem) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_imagem_slider (imagem, legenda, ativo) VALUES (?, ?, ?)");
            $statement->bind_param("ssi", ...array($imagem->getImagem(), $imagem->getLegenda(), $imagem->getAtivo()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function ativarImagem($id, $ativo) {
            $statement = $this->conexao->prepare("UPDATE tbl_imagem_slider SET ativo = ? WHERE id = ?");
            $statement->bind_param("ii", $ativo, $id);
            $statement->execute();
            $statement->close();
        }
        
        public function atualizarImagem($imagem) {
            $statement = $this->conexao->prepare("UPDATE tbl_imagem_slider SET imagem = ?, legenda = ?, ativo = ? WHERE id = ?");
            $statement->bind_param("ssii", ...array($imagem->getImagem(), $imagem->getLegenda(), $imagem->getAtivo(), $imagem->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function excluirImagem($id) {
            $statement = $this->conexao->prepare("DELETE FROM tbl_imagem_slider WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
    }
?>