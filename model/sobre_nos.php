<?php
    class SobreNos {
        private $id;
        private $titulo;
        private $imagem;
        private $texto;
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
        
        public function getImagem() {
            return $this->imagem;
        }

        public function setImagem($imagem) {
            $this->imagem = $imagem;
        }
        
        public function getTexto() {
            return $this->texto;
        }

        public function setTexto($texto) {
            $this->texto = $texto;
        }
        
        public function getAtivo() {
            return $this->ativo;
        }

        public function setAtivo($ativo) {
            $this->ativo = intval($ativo);
        }
    }
?>