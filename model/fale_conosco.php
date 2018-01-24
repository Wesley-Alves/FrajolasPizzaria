<?php
    class FaleConosco {
        private $id;
        private $nome;
        private $email;
        private $telefone;
        private $celular;
        private $profissao;
        private $sexo;
        private $homePage;
        private $facebook;
        private $produtos;
        private $comentarios;
        
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
        
        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }
        
        public function getTelefone() {
            return $this->telefone;
        }

        public function setTelefone($telefone) {
            $this->telefone = $telefone;
        }
        
        public function getCelular() {
            return $this->celular;
        }
        
        public function setCelular($celular) {
            $this->celular = $celular;
        }
        
        public function getProfissao() {
            return $this->profissao;
        }
        
        public function setProfissao($profissao) {
            $this->profissao = $profissao;
        }
        
        public function getSexo() {
            return $this->sexo;
        }
        
        public function setSexo($sexo) {
            $this->sexo = $sexo;
        }
        
        public function getHomePage() {
            return $this->homePage;
        }
        
        public function setHomePage($homePage) {
            $this->homePage = $homePage;
        }
        
        public function getFacebook() {
            return $this->facebook;
        }
        
        public function setFacebook($facebook) {
            $this->facebook = $facebook;
        }
        
        public function getProdutos() {
            return $this->produtos;
        }
        
        public function setProdutos($produtos) {
            $this->produtos = $produtos;
        }
        
        public function getComentarios() {
            return $this->comentarios;
        }
        
        public function setComentarios($comentarios) {
            $this->comentarios = $comentarios;
        }
    }
?>