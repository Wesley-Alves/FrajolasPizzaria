<?php
    class ImagemSlider {
        private $id;
        private $imagem;
        private $legenda;
        private $ativo;
        
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getImagem() {
            return $this->imagem;
        }

        public function setImagem($imagem) {
            $this->imagem = $imagem;
        }
        
        public function getLegenda() {
            return $this->legenda;
        }

        public function setLegenda($legenda) {
            $this->legenda = $legenda;
        }
        
        public function getAtivo() {
            return $this->ativo;
        }

        public function setAtivo($ativo) {
            $this->ativo = $ativo;
        }
    }
?>