<?php
// Database configuration for NBA Teams Database
// Group 13 - NBA Teams
// Updated for Azure deployment with environment variables

// Azure Database configuration - uses environment variables
$azure_db_host = getenv('DB_HOST') ?: 'localhost';
$azure_db_name = getenv('DB_NAME') ?: 'nba_teams_db';
$azure_db_user = getenv('DB_USER') ?: 'root';
$azure_db_pass = getenv('DB_PASSWORD') ?: '';

// Legacy constants for backward compatibility
define('DB_HOST', $azure_db_host);
define('DB_NAME', $azure_db_name);
define('DB_USER', $azure_db_user);
define('DB_PASS', $azure_db_pass);
define('DB_CHARSET', 'utf8mb4');

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset = 'utf8mb4';
    public $conn;

    public function __construct() {
        // Use environment variables for Azure deployment
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->db_name = getenv('DB_NAME') ?: 'nba_teams_db';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: '';
        
        // For Azure MySQL, adjust connection parameters
        if (strpos($this->host, 'mysql.database.azure.com') !== false) {
            // Azure Database for MySQL specific settings
            $this->charset = 'utf8mb4';
        }
    }

    public function getConnection() {
        $this->conn = null;
        
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            
            // Azure MySQL specific options
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_SSL_CA => false,
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
            ];
            
            // For Azure MySQL, enable SSL
            if (strpos($this->host, 'mysql.database.azure.com') !== false) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = true;
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
            }
            
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch(PDOException $exception) {
            error_log("Database connection error: " . $exception->getMessage());
            
            // In production, don't expose database errors
            if (getenv('ENVIRONMENT') === 'production') {
                die("Database connection failed. Please try again later.");
            } else {
                echo "Connection error: " . $exception->getMessage();
            }
        }
        
        return $this->conn;
    }
    
    // Method to test connection
    public function testConnection() {
        try {
            $conn = $this->getConnection();
            if ($conn) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }
}

// Create database connection instance
$database = new Database();
$db = $database->getConnection();

// Check if connection was successful
if (!$db) {
    if (getenv('ENVIRONMENT') === 'production') {
        die("Service temporarily unavailable. Please try again later.");
    } else {
        die("Database connection failed. Please check your configuration.");
    }
}
?> 