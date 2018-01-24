<?php
    class Database {
        public static function getConexao() {
            try {
                mysqli_report(MYSQLI_REPORT_STRICT);
                $conexao = new mysqli("localhost", "root", "bcd127", "db_pizzaria");
                return $conexao;
            } catch (Exception $e) {
                die("Erro interno. Tente novamente mais tarde.");
            }
        }
    }
?>