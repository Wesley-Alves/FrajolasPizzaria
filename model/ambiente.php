<?php
    class Ambiente {
        private $id;
        private $imagem;
        private $ativo;
        private $logradouro;
        private $numero;
        private $bairro;
        private $cep;
        private $cidade;
        private $estado;
        private $uf;
        private $telefone;
        private $operadora;
        private $idEstado;
        private $idEndereco;
        private $idOperadora;
        private $idCidade;
        
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
        
        public function getAtivo() {
            return $this->ativo;
        }

        public function setAtivo($ativo) {
            $this->ativo = intval($ativo);
        }
        
        public function getLogradouro() {
            return $this->logradouro;
	    }

        public function setLogradouro($logradouro) {
            $this->logradouro = $logradouro;
        }

        public function getNumero() {
            return $this->numero;
        }

        public function setNumero($numero) {
            $this->numero = $numero;
        }

        public function getBairro() {
            return $this->bairro;
        }

        public function setBairro($bairro) {
            $this->bairro = $bairro;
        }

        public function getCep() {
            return $this->cep;
        }

        public function setCep($cep) {
            $this->cep = $cep;
        }

        public function getCidade() {
            return $this->cidade;
        }

        public function setCidade($cidade) {
            $this->cidade = $cidade;
        }
        
        public function getEstado() {
            return $this->estado;
        }

        public function setEstado($estado) {
            $this->estado = $estado;
        }

        public function getUf() {
            return $this->uf;
        }

        public function setUf($uf) {
            $this->uf = $uf;
        }

        public function getTelefone() {
            return $this->telefone;
        }

        public function setTelefone($telefone) {
            $this->telefone = $telefone;
        }

        public function getOperadora() {
            return $this->operadora;
        }

        public function setOperadora($operadora) {
            $this->operadora = $operadora;
        }
        
        public function getIdEstado() {
            return $this->idEstado;
        }

        public function setIdEstado($idEstado) {
            $this->idEstado = $idEstado;
        }
        
        public function getIdEndereco() {
            return $this->idEndereco;
        }

        public function setIdEndereco($idEndereco) {
            $this->idEndereco = $idEndereco;
        }
        
        public function getIdOperadora() {
            return $this->idOperadora;
        }

        public function setIdOperadora($idOperadora) {
            $this->idOperadora = $idOperadora;
        }
        
        public function getIdCidade() {
            return $this->idCidade;
        }

        public function setIdCidade($idCidade) {
            $this->idCidade = $idCidade;
        }
    }
?>