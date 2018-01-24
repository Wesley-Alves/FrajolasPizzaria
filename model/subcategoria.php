<?php
    class Subcategoria {
        private $id;
        private $nome;
        private $ativo;
        private $idCategoria;
        
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }
        
        public function getNome() {
            return $this->nome;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }
        
        public function getAtivo() {
            return $this->ativo;
        }

        public function setAtivo($ativo) {
            $this->ativo = intval($ativo);
        }
        
        public function getIdCategoria() {
            return $this->idCategoria;
        }

        public function setIdCategoria($idCategoria) {
            $this->idCategoria = $idCategoria;
        }
    }
?>