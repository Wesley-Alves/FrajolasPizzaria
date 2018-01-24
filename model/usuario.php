<?php
    class Usuario {
        private $id;
        private $nome;
        private $email;
        private $usuario;
        private $senha;
        private $imagem;
        private $ativo;
        private $idPrivilegio;
        private $nomePrivilegio;
        private $permConteudo;
        private $permFaleConosco;
        private $permProdutos;
        private $permUsuarios;

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
        
        public function getUsuario() {
            return $this->usuario;
        }
        
        public function setUsuario($usuario) {
            $this->usuario = $usuario;
        }
        
        public function getSenha() {
            return $this->senha;
        }
        
        public function setSenha($senha) {
            $this->senha = $senha;
        }
        
        public function getImagem() {
            return $this->imagem;
        }
        
        public function setImagem($imagem) {
            $this->imagem = $imagem;
        }
        
        public function getAtivo() {
            return $this->ativo;
        }

        public function setAtivo($ativo) {
            $this->ativo = intval($ativo);
        }
        
        public function getIdPrivilegio() {
            return $this->idPrivilegio;
        }

        public function setIdPrivilegio($idPrivilegio) {
            $this->idPrivilegio = $idPrivilegio;
        }
        
        public function getNomePrivilegio() {
            return $this->nomePrivilegio;
        }

        public function setNomePrivilegio($nomePrivilegio) {
            $this->nomePrivilegio = $nomePrivilegio;
        }
        
        public function getPermConteudo() {
            return $this->permConteudo;
        }

        public function setPermConteudo($permConteudo) {
            $this->permConteudo = $permConteudo;
        }
        
        public function getPermFaleConosco() {
            return $this->permFaleConosco;
        }

        public function setPermFaleConosco($permFaleConosco) {
            $this->permFaleConosco = $permFaleConosco;
        }
        
        public function getPermProdutos() {
            return $this->permProdutos;
        }

        public function setPermProdutos($permProdutos) {
            $this->permProdutos = $permProdutos;
        }
        
        public function getPermUsuarios() {
            return $this->permUsuarios;
        }

        public function setPermUsuarios($permUsuarios) {
            $this->permUsuarios = $permUsuarios;
        }
    }
?>