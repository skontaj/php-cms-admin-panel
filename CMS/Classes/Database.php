<?php

    class Database
    {

        protected $conn;

        // Konstante unutar klase
        private const DB_HOST = 'localhost';
        private const DB_NAME = 'oop';
        private const DB_USER = 'root';
        private const DB_PASS = '';

        // Ovu konekciju sam uzeo od GPT-a
        // PDO je PHP klasa za rad sa bazama
        // U PDO uacimo DSN (Data Source Name) koji sadrzi informacije o bazi podataka, dodam jos korisnicko ime i lozinku
        // Konekcija je aktivna i cuvamo je u $conn
        // Ako dodje do greske, hvata se izuzetak i ispisuje poruka o gresci

        public function __construct()
        {
            $this->connect();
        }

        // Metoda za konekciju
        public function connect()
        {

            try
            {
                // DSN (Data Source Name)
                $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=utf8mb4";

                // Kreiranje PDO objekta
                $this->conn = new PDO($dsn, self::DB_USER, self::DB_PASS);

                // Postavljanje PDO atributa za prikazivanje gresaka kao izuzetaka
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            }
            catch (PDOException $e)
            {
                echo "Greska pri konekciji: " . $e->getMessage();
                die();
            }

            return $this->conn;
        }

        // Getter za PDO konekciju
        public function getConnection()
        {
            return $this->conn;
        }

        // Zatvaranje konekcije
        public function disconnect()
        {
            $this->conn = null;
        }
    }