<?php
    require_once("database.php");

    class CategoriaDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function getCategorias($ativo) {
            $categorias = array();
            $result = $this->conexao->query("SELECT * FROM tbl_categorias" . ($ativo ? "  WHERE ativo = 1" : ""));
            while ($data = $result->fetch_array()) {
                $categoria = new Categoria();
                $categoria->setId($data["id"]);
                $categoria->setNome($data["nome"]);
                $categoria->setAtivo($data["ativo"]);
                $categorias[] = $categoria;
            }
            
            return $categorias;
        }
        
        public function getCategoria($id) {
            $statement = $this->conexao->prepare("SELECT * FROM tbl_categorias WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $categoria = new Categoria();
                $categoria->setId($data["id"]);
                $categoria->setNome($data["nome"]);
                $categoria->setAtivo($data["ativo"]);
                return $categoria;
            }
        }
        
        public function gravar($categoria) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_categorias (nome, ativo) VALUES (?, ?)");
            $statement->bind_param("si", ...array($categoria->getNome(), $categoria->getAtivo()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function atualizar($categoria) {
            $statement = $this->conexao->prepare("UPDATE tbl_categorias SET nome = ?, ativo = ? WHERE id = ?");
            $statement->bind_param("sii", ...array($categoria->getNome(), $categoria->getAtivo(), $categoria->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function ativar($id, $ativo) {
            $statement = $this->conexao->prepare("UPDATE tbl_categorias SET ativo = ? WHERE id = ?");
            $statement->bind_param("ii", $ativo, $id);
            $statement->execute();
            $statement->close();
        }
        
        public function excluir($id) {
            $statement = $this->conexao->prepare("DELETE c, s FROM tbl_categorias AS c JOIN tbl_subcategorias AS s ON s.idCategoria = c.id WHERE c.id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
    }
?>