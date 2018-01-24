<?php
    require_once("database.php");

    class ProdutoDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function getProdutos() {
            $produtos = array();
            $result = $this->conexao->query("SELECT * FROM tbl_produtos");
            while ($data = $result->fetch_array()) {
                $produto = new Produto();
                $produto->setId($data["id"]);
                $produto->setTitulo($data["titulo"]);
                $produto->setImagem($data["imagem"]);
                $produto->setDescricao($data["descricao"]);
                $produto->setDetalhes($data["detalhes"]);
                $produto->setPreco($data["preco"]);
                $produto->setAtivo($data["ativo"]);
                $produto->setIdSubcategoria($data["idSubcategoria"]);
                $produtos[] = $produto;
            }
            
            return $produtos;
        }
        
        public function getProduto($id) {
            $statement = $this->conexao->prepare("SELECT * FROM tbl_produtos WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $produto = new Produto();
                $produto->setId($data["id"]);
                $produto->setTitulo($data["titulo"]);
                $produto->setImagem($data["imagem"]);
                $produto->setDescricao($data["descricao"]);
                $produto->setDetalhes($data["detalhes"]);
                $produto->setPreco($data["preco"]);
                $produto->setAtivo($data["ativo"]);
                $produto->setIdSubcategoria($data["idSubcategoria"]);
                return $produto;
            }
        }
        
        public function gravar($produto) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_produtos (titulo, imagem, descricao, detalhes, preco, ativo, cliques, idSubcategoria) VALUES (?, ?, ?, ?, ?, ?, 0, ?)");
            $statement->bind_param("ssssdii", ...array($produto->getTitulo(), $produto->getImagem(), $produto->getDescricao(), $produto->getDetalhes(), $produto->getPreco(), $produto->getAtivo(), $produto->getIdSubcategoria()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function ativar($id, $ativo) {
            $statement = $this->conexao->prepare("UPDATE tbl_produtos SET ativo = ? WHERE id = ?");
            $statement->bind_param("ii", $ativo, $id);
            $statement->execute();
            $statement->close();
        }
        
        public function atualizar($produto) {
            $statement = $this->conexao->prepare("UPDATE tbl_produtos SET titulo = ?, imagem = ?, descricao = ?, detalhes = ?, preco = ?, ativo = ?, idSubcategoria = ? WHERE id = ?");
            $statement->bind_param("ssssdiii", ...array($produto->getTitulo(), $produto->getImagem(), $produto->getDescricao(), $produto->getDetalhes(), $produto->getPreco(), $produto->getAtivo(), $produto->getIdSubcategoria(), $produto->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function excluir($id) {
            $statement = $this->conexao->prepare("DELETE FROM tbl_produtos WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
        
        public function mostrarProdutos($subcategoriaId, $texto) {
            $produtos = array();
            if ($subcategoriaId) {
                $statement = $this->conexao->prepare("SELECT * FROM tbl_produtos WHERE idSubcategoria = ? AND ativo = 1");
                $statement->bind_param("i", $subcategoriaId);
                $statement->execute();
                $result = $statement->get_result();
            } else if ($texto) {
                $texto = "%$texto%";
                $statement = $this->conexao->prepare("SELECT p.* FROM tbl_produtos AS p JOIN tbl_subcategorias AS s ON s.id = p.idSubcategoria  JOIN tbl_categorias AS c ON c.id = s.idCategoria WHERE (p.titulo LIKE ? OR p.descricao LIKE ?) AND p.ativo = 1 AND s.ativo = 1 AND c.ativo = 1");
                $statement->bind_param("ss", $texto, $texto);
                $statement->execute();
                $result = $statement->get_result();
            } else {
                $result = $this->conexao->query("SELECT p.* FROM tbl_produtos AS p JOIN tbl_subcategorias AS s ON s.id = p.idSubcategoria  JOIN tbl_categorias AS c ON c.id = s.idCategoria WHERE p.ativo = 1 AND s.ativo = 1 AND c.ativo = 1 ORDER BY RAND()");
            }
            
            while ($data = $result->fetch_array()) {
                $produto = new Produto();
                $produto->setId($data["id"]);
                $produto->setTitulo($data["titulo"]);
                $produto->setImagem($data["imagem"]);
                $produto->setDescricao($data["descricao"]);
                $produto->setDetalhes($data["detalhes"]);
                $produto->setPreco($data["preco"]);
                $produtos[] = $produto;
            }
            
            return $produtos;
        }
        
        public function getProdutoDetalhes($id) {
            $statement = $this->conexao->prepare("SELECT p.*, s.nome AS subcategoria, c.nome AS categoria FROM tbl_produtos AS p JOIN tbl_subcategorias AS s on s.id = p.idSubcategoria JOIN tbl_categorias AS c on c.id = s.idCategoria WHERE p.id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $produto = new Produto();
                $produto->setId($data["id"]);
                $produto->setTitulo($data["titulo"]);
                $produto->setImagem($data["imagem"]);
                $produto->setDescricao($data["descricao"]);
                $produto->setDetalhes($data["detalhes"]);
                $produto->setPreco($data["preco"]);
                $produto->setCategoria($data["categoria"]);
                $produto->setSubcategoria($data["subcategoria"]);
                return $produto;
            }
        }
    
        public function adicionarClique($id) {
            $statement = $this->conexao->prepare("UPDATE tbl_produtos SET cliques = cliques + 1 WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
        
        public function getEstatisticas() {
            $result = $this->conexao->query("SELECT SUM(cliques) AS total, TRUNCATE(AVG(cliques), 2) AS media FROM tbl_produtos");
            if ($data = $result->fetch_array()) {
                return $data;
            }
        }
        
        public function getProdutosGrafico() {
            $produtos = array();
            $result = $this->conexao->query("SELECT titulo, cliques, TRUNCATE(cliques / (SELECT SUM(cliques) FROM tbl_produtos) * 100, 2) AS porcentagem FROM tbl_produtos ORDER BY porcentagem DESC LIMIT 5");
            while ($data = $result->fetch_array()) {
                $produtos[] = $data;
            }
            
            return $produtos;
        }
    }
?>