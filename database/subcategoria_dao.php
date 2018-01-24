<?php
    require_once("database.php");

    class SubcategoriaDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function getSubcategorias($idCategoria, $ativo) {
            $subcategorias = array();
            $statement = $this->conexao->prepare("SELECT * FROM tbl_subcategorias WHERE idCategoria = ?" . ($ativo ? " AND ativo = 1" : ""));
            $statement->bind_param("i", $idCategoria);
            $statement->execute();
            $result = $statement->get_result();
            while ($data = $result->fetch_array()) {
                $subcategoria = new Subcategoria();
                $subcategoria->setId($data["id"]);
                $subcategoria->setNome($data["nome"]);
                $subcategoria->setAtivo($data["ativo"]);
                $subcategoria->setIdCategoria($data["idCategoria"]);
                $subcategorias[] = $subcategoria;
            }
            
            return $subcategorias;
        }
        
        public function getSubcategoria($id) {
            $statement = $this->conexao->prepare("SELECT * FROM tbl_subcategorias WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $subcategoria = new Subcategoria();
                $subcategoria->setId($data["id"]);
                $subcategoria->setNome($data["nome"]);
                $subcategoria->setAtivo($data["ativo"]);
                $subcategoria->setIdCategoria($data["idCategoria"]);
                return $subcategoria;
            }
        }
        
        public function getNomeCategoria($id) {
            $statement = $this->conexao->prepare("SELECT nome FROM tbl_categorias WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                return $data["nome"];
            }
        }
        
        public function gravar($subcategoria) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_subcategorias (nome, ativo, idCategoria) VALUES (?, ?, ?)");
            $statement->bind_param("sii", ...array($subcategoria->getNome(), $subcategoria->getAtivo(), $subcategoria->getIdCategoria()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function atualizar($subcategoria) {
            $statement = $this->conexao->prepare("UPDATE tbl_subcategorias SET nome = ?, ativo = ? WHERE id = ?");
            $statement->bind_param("sii", ...array($subcategoria->getNome(), $subcategoria->getAtivo(), $subcategoria->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function ativar($id, $ativo) {
            $statement = $this->conexao->prepare("UPDATE tbl_subcategorias SET ativo = ? WHERE id = ?");
            $statement->bind_param("ii", $ativo, $id);
            $statement->execute();
            $statement->close();
        }
        
        public function excluir($id) {
            $statement = $this->conexao->prepare("DELETE FROM tbl_subcategorias WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
    }
?>