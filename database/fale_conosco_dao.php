<?php
    require_once("database.php");

    class FaleConoscoDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function gravar($faleConosco) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_fale_conosco (nome, email, telefone, celular, profissao, sexo, homePage, facebook, produtos, comentarios) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $statement->bind_param("ssssssssss", ...array($faleConosco->getNome(), $faleConosco->getEmail(), $faleConosco->getTelefone(), $faleConosco->getCelular(), $faleConosco->getProfissao(), $faleConosco->getSexo(), $faleConosco->getHomePage(), $faleConosco->getFacebook(), $faleConosco->getProdutos(), $faleConosco->getComentarios()));
            $statement->execute();
            $statement->close();
        }
        
        public function getFaleConosco() {
            $faleConosco = array();
            $result = $this->conexao->query("SELECT * FROM tbl_fale_conosco");
            while ($data = $result->fetch_array()) {
                $faleConoscoItem = new FaleConosco();
                $faleConoscoItem->setId($data["id"]);
                $faleConoscoItem->setNome($data["nome"]);
                $faleConoscoItem->setEmail($data["email"]);
                $faleConoscoItem->setTelefone($data["telefone"]);
                $faleConoscoItem->setCelular($data["celular"]);
                $faleConoscoItem->setProfissao($data["profissao"]);
                $faleConoscoItem->setSexo($data["sexo"]);
                $faleConoscoItem->setHomePage($data["homePage"]);
                $faleConoscoItem->setFacebook($data["facebook"]);
                $faleConoscoItem->setProdutos($data["produtos"]);
                $faleConoscoItem->setComentarios($data["comentarios"]);
                $faleConosco[] = $faleConoscoItem;
            }
            
            return $faleConosco;
        }
        
        public function getFaleConoscoItem($id) {
            $statement = $this->conexao->prepare("SELECT * FROM tbl_fale_conosco WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $faleConoscoItem = new FaleConosco();
                $faleConoscoItem->setId($data["id"]);
                $faleConoscoItem->setNome($data["nome"]);
                $faleConoscoItem->setEmail($data["email"]);
                $faleConoscoItem->setTelefone($data["telefone"]);
                $faleConoscoItem->setCelular($data["celular"]);
                $faleConoscoItem->setProfissao($data["profissao"]);
                $faleConoscoItem->setSexo($data["sexo"]);
                $faleConoscoItem->setHomePage($data["homePage"]);
                $faleConoscoItem->setFacebook($data["facebook"]);
                $faleConoscoItem->setProdutos($data["produtos"]);
                $faleConoscoItem->setComentarios($data["comentarios"]);
                return $faleConoscoItem;
            }
        }
        
        public function excluir($id) {
            $statement = $this->conexao->prepare("DELETE FROM tbl_fale_conosco WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
    }
?>