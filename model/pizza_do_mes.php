<?php
    class PizzaDoMes {
        private $id;
        private $titulo;
        private $texto;
        private $imagemPrincipal;
        private $imagem2;
        private $imagem3;
        private $ativo;
        
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getTitulo() {
            return $this->titulo;
        }

        public function setTitulo($titulo) {
            $this->titulo = $titulo;
        }

        public function getTexto() {
            return $this->texto;
        }

        public function setTexto($texto) {
            $this->texto = $texto;
        }

        public function getImagemPrincipal() {
            return $this->imagemPrincipal;
        }

        public function setImagemPrincipal($imagemPrincipal) {
            $this->imagemPrincipal = $imagemPrincipal;
        }

        public function getImagem2() {
            return $this->imagem2;
        }

        public function setImagem2($imagem2) {
            $this->imagem2 = $imagem2;
        }

        public function getImagem3() {
            return $this->imagem3;
        }

        public function setImagem3($imagem3) {
            $this->imagem3 = $imagem3;
        }
        
        public function getAtivo() {
            return $this->ativo;
        }

        public function setAtivo($ativo) {
            $this->ativo = intval($ativo);
        }
    }
?>