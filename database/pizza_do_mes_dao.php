<?php
    require_once("database.php");

    class PizzaDoMesDAO {
        public $conexao;
        public function __construct() {
            $this->conexao = Database::getConexao();
        }
        
        public function getPizzaDoMes($ativo) {
            $pizzaDoMes = array();
            $result = $this->conexao->query("SELECT * FROM tbl_pizza_do_mes" . ($ativo ? " WHERE ativo = 1" : ""));
            while ($data = $result->fetch_array()) {
                $pizzaDoMesItem = new PizzaDoMes();
                $pizzaDoMesItem->setId($data["id"]);
                $pizzaDoMesItem->setTitulo($data["titulo"]);
                $pizzaDoMesItem->setTexto($data["texto"]);
                $pizzaDoMesItem->setImagemPrincipal($data["imagemPrincipal"]);
                $pizzaDoMesItem->setImagem2($data["imagem2"]);
                $pizzaDoMesItem->setImagem3($data["imagem3"]);
                $pizzaDoMesItem->setAtivo($data["ativo"]);
                $pizzaDoMes[] = $pizzaDoMesItem;
            }
            
            return $pizzaDoMes;
        }
        
        public function getPizzaDoMesItem($id) {
            $statement = $this->conexao->prepare("SELECT * FROM tbl_pizza_do_mes WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $pizzaDoMes = new PizzaDoMes();
                $pizzaDoMes->setId($data["id"]);
                $pizzaDoMes->setTitulo($data["titulo"]);
                $pizzaDoMes->setTexto($data["texto"]);
                $pizzaDoMes->setImagemPrincipal($data["imagemPrincipal"]);
                $pizzaDoMes->setImagem2($data["imagem2"]);
                $pizzaDoMes->setImagem3($data["imagem3"]);
                $pizzaDoMes->setAtivo($data["ativo"]);
                return $pizzaDoMes;
            }
        }
        
        public function gravarPizzaDoMes($pizzaDoMes) {
            $statement = $this->conexao->prepare("INSERT INTO tbl_pizza_do_mes (titulo, texto, ativo, imagemPrincipal, imagem2, imagem3) VALUES (?, ?, ?, ?, ?, ?)");
            $statement->bind_param("ssisss", ...array($pizzaDoMes->getTitulo(), $pizzaDoMes->getTexto(), $pizzaDoMes->getAtivo(), $pizzaDoMes->getImagemPrincipal(), $pizzaDoMes->getImagem2(), $pizzaDoMes->getImagem3()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            return $id;
        }
        
        public function ativarPizzaDoMes($id, $ativo) {
            $statement = $this->conexao->prepare("UPDATE tbl_pizza_do_mes SET ativo = ? WHERE id = ?");
            $statement->bind_param("ii", $ativo, $id);
            $statement->execute();
            $statement->close();
        }
        
        public function atualizarPizzaDoMes($pizzaDoMes) {
            $statement = $this->conexao->prepare("UPDATE tbl_pizza_do_mes SET titulo = ?, texto = ?, ativo = ?, imagemPrincipal = ?, imagem2 = ?, imagem3 = ? WHERE id = ?");
            $statement->bind_param("ssisssi", ...array($pizzaDoMes->getTitulo(), $pizzaDoMes->getTexto(), $pizzaDoMes->getAtivo(), $pizzaDoMes->getImagemPrincipal(), $pizzaDoMes->getImagem2(), $pizzaDoMes->getImagem3(), $pizzaDoMes->getId()));
            $statement->execute();
            $statement->close();
        }
        
        public function excluirPizzaDoMes($id) {
            $statement = $this->conexao->prepare("DELETE FROM tbl_pizza_do_mes WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
        }
    }
?>