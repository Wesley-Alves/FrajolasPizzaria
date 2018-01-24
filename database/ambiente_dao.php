<?php
    require_once("database.php");

    class AmbienteDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function getAmbientes($ativo) {
            $ambientes = array();
            $result = $this->conexao->query("SELECT a.id, a.imagem, a.ativo, a.telefone, e.logradouro, e.numero, e.bairro, e.cep, c.cidade, es.estado, es.uf, o.operadora FROM tbl_ambientes AS a JOIN tbl_endereco AS e ON a.idEndereco = e.id JOIN tbl_cidades AS c ON e.idCidade = c.id JOIN tbl_estados AS es ON c.idEstado = es.id JOIN tbl_operadora AS o on a.idOperadora = o.id " . ($ativo ? "WHERE ativo = 1 " : ""));
            while ($data = $result->fetch_array()) {
                $ambiente = new Ambiente();
                $ambiente->setId($data["id"]);
                $ambiente->setImagem($data["imagem"]);
                $ambiente->setAtivo($data["ativo"]);
                $ambiente->setLogradouro($data["logradouro"]);
                $ambiente->setNumero($data["numero"]);
                $ambiente->setBairro($data["bairro"]);
                $ambiente->setCep($data["cep"]);
                $ambiente->setCidade($data["cidade"]);
                $ambiente->setEstado($data["estado"]);
                $ambiente->setUf($data["uf"]);
                $ambiente->setTelefone($data["telefone"]);
                $ambiente->setOperadora($data["operadora"]);
                $ambientes[] = $ambiente;
            }
            
            return $ambientes;
        }
        
        public function getAmbiente($id) {
            $statement = $this->conexao->prepare("SELECT a.id, a.imagem, a.ativo, a.telefone, e.logradouro, e.numero, e.bairro, e.cep, e.id AS idEndereco, c.cidade, c.id AS idCidade, es.estado, es.uf, es.id AS idEstado, o.operadora FROM tbl_ambientes AS a JOIN tbl_endereco AS e ON a.idEndereco = e.id JOIN tbl_cidades AS c ON e.idCidade = c.id JOIN tbl_estados AS es ON c.idEstado = es.id JOIN tbl_operadora AS o on a.idOperadora = o.id WHERE a.id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $ambiente = new Ambiente();
                $ambiente->setId($data["id"]);
                $ambiente->setImagem($data["imagem"]);
                $ambiente->setAtivo($data["ativo"]);
                $ambiente->setLogradouro($data["logradouro"]);
                $ambiente->setNumero($data["numero"]);
                $ambiente->setBairro($data["bairro"]);
                $ambiente->setCep($data["cep"]);
                $ambiente->setIdEndereco($data["idEndereco"]);
                $ambiente->setCidade($data["cidade"]);
                $ambiente->setEstado($data["estado"]);
                $ambiente->setUf($data["uf"]);
                $ambiente->setTelefone($data["telefone"]);
                $ambiente->setOperadora($data["operadora"]);
                $ambiente->setIdCidade($data["idCidade"]);
                $ambiente->setIdEstado($data["idEstado"]);
                return $ambiente;
            }
        }
        
        public function getEstados() {
            $estados = array();
            $result = $this->conexao->query("SELECT * FROM tbl_estados");
            while ($data = $result->fetch_array()) {
                $estados[] = $data;
            }
            
            return $estados;
        }
        
        public function getCidades($idEstado) {
            $cidades = array();
            $statement = $this->conexao->prepare("SELECT * FROM tbl_cidades WHERE idEstado = ?");
            $statement->bind_param("i", $idEstado);
            $statement->execute();
            $result = $statement->get_result();
            while ($data = $result->fetch_array()) {
                $cidades[] = $data;
            }
            
            return $cidades;
        }
        
        public function getOperadoras() {
            $operadoras = array();
            $result = $this->conexao->query("SELECT * FROM tbl_operadora");
            while ($data = $result->fetch_array()) {
                $operadoras[] = $data;
            }
            
            return $operadoras;
        }
        
        public function gravarEndereco($ambiente) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_endereco (logradouro, numero, idCidade, bairro, cep) VALUES (?, ?, ?, ?, ?)");
            $statement->bind_param("siiss", ...array($ambiente->getLogradouro(), $ambiente->getNumero(), $ambiente->getIdCidade(), $ambiente->getBairro(), $ambiente->getCep()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function gravarAmbiente($ambiente) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_ambientes (imagem, ativo, idEndereco, telefone, idOperadora) VALUES (?, ?, ?, ?, ?)");
            $statement->bind_param("siisi", ...array($ambiente->getImagem(), $ambiente->getAtivo(), $ambiente->getIdEndereco(), $ambiente->getTelefone(), $ambiente->getIdOperadora()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function ativarAmbiente($id, $ativo) {
            $statement = $this->conexao->prepare("UPDATE tbl_ambientes SET ativo = ? WHERE id = ?");
            $statement->bind_param("ii", $ativo, $id);
            $statement->execute();
            $statement->close();
        }
        
        public function atualizarEndereco($ambiente) {
            $statement = $this->conexao->prepare("UPDATE tbl_endereco SET logradouro = ?, numero = ?, idCidade = ?, bairro = ?, cep = ? WHERE id = ?");
            $statement->bind_param("siissi", ...array($ambiente->getLogradouro(), $ambiente->getNumero(), $ambiente->getIdCidade(), $ambiente->getBairro(), $ambiente->getCep(), $ambiente->getIdEndereco()));
            $statement->execute();
            $statement->close();
        }
        
        public function atualizarAmbiente($ambiente) {
            $statement = $this->conexao->prepare("UPDATE tbl_ambientes SET imagem = ?, ativo = ?, telefone = ?, idOperadora = ? WHERE id = ?");
            $statement->bind_param("sisii", ...array($ambiente->getImagem(), $ambiente->getAtivo(), $ambiente->getTelefone(), $ambiente->getIdOperadora(), $ambiente->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function excluirAmbiente($id) {
            $statement = $this->conexao->prepare("DELETE a, e FROM tbl_ambientes AS a JOIN tbl_endereco AS e ON a.idEndereco = e.id WHERE a.id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
    }
?>