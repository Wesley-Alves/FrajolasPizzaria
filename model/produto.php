<?php
    class Produto {
        private $id;
        private $titulo;
        private $imagem;
        private $descricao;
        private $detalhes;
        private $preco;
        private $ativo;
        private $idSubcategoria;
        private $categoria;
        private $subcategoria;
        
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
        
        public function getDescricao() {
            return $this->descricao;
        }

        public function setDescricao($descricao) {
            $this->descricao = $descricao;
        }
        
        public function getDetalhes() {
            return $this->detalhes;
        }

        public function setDetalhes($detalhes) {
            $this->detalhes = $detalhes;
        }
        
        public function getPreco() {
            return $this->preco;
        }

        public function setPreco($preco) {
            $this->preco = $preco;
        }
        
        public function getAtivo() {
            return $this->ativo;
        }

        public function setAtivo($ativo) {
            $this->ativo = intval($ativo);
        }
        
        public function getIdSubcategoria() {
            return $this->idSubcategoria;
        }

        public function setIdSubcategoria($idSubcategoria) {
            $this->idSubcategoria = $idSubcategoria;
        }
        
        public function getCategoria() {
            return $this->categoria;
        }

        public function setCategoria($categoria) {
            $this->categoria = $categoria;
        }
        
        public function getSubcategoria() {
            return $this->subcategoria;
        }

        public function setSubcategoria($subcategoria) {
            $this->subcategoria = $subcategoria;
        }
    }
?>