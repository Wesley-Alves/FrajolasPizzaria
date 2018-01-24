<?php
    class Curiosidade {
        private $id;
        private $idDecada;
        private $titulo;
        private $imagem;
        private $texto;
        private $ativo;
        private $decada;

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }
        
        public function getIdDecada() {
            return $this->idDecada;
        }

        public function setIdDecada($idDecada) {
            $this->idDecada = $idDecada;
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
        
        public function getDecada() {
            return $this->decada;
        }

        public function setDecada($decada) {
            $this->decada = $decada;
        }
    }
?>