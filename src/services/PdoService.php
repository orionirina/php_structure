<?php

/**
 * Class PdoService
 * Manages the database connection using PDO.
 */
class PdoService {
    /**
     * @var PDO|null The PDO instance
     */
    private $pdo;

    /**
     * PdoService constructor.
     * Loads database configuration and establishes a PDO connection.
     */
    public function __construct() {
        $this->connect();
    }

    /**
     * Load database configuration and connect to the database.
     * @return void
     */
    private function connect() {
        $xmlFile = 'config/database.xml';
        if (!file_exists($xmlFile)) {
            throw new Exception("Erreur : Le fichier de configuration '$xmlFile' n'existe pas.");
        }
        

        $config = simplexml_load_file($xmlFile);

        $connection = $config->connection;

        $host = (string)$connection['host'];
        $port = (string)$connection->port;
        $dbname = (string)$connection->dbname;
        $username = (string)$connection->username;
        $password = (string)$connection->password;
        $charset = (string)$connection->charset;
        
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

        try {
            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Get the PDO instance.
     * @return PDO
     */
    public function getPdo() {
        return $this->pdo;
    }
}
?>