<?php
class Farmer {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Register a new farmer
    public function register($full_name, $phone_number, $email, $password) {
        try {
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Prepare the SQL statement
            $stmt = $this->db->prepare("INSERT INTO farmers (full_name, phone_number, email, password_hash) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Database error: " . $this->db->error);
            }

            // Bind parameters and execute
            $stmt->bind_param("ssss", $full_name, $phone_number, $email, $password_hash);
            $result = $stmt->execute();

            // Check if the query was successful
            if ($result) {
                return true; // Registration successful
            } else {
                throw new Exception("Registration failed: " . $stmt->error);
            }
        } catch (Exception $e) {
            // Log the error
            error_log($e->getMessage());
            return false; // Registration failed
        }
    }

    // Login a farmer
    public function login($email, $password) {
        try {
            // Prepare the SQL statement
            $stmt = $this->db->prepare("SELECT farmer_id, password_hash FROM farmers WHERE email = ?");
            if (!$stmt) {
                throw new Exception("Database error: " . $this->db->error);
            }
            
            // Bind parameters and execute
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Fetch the farmer data
            $farmer = $result->fetch_assoc();
            
            // Verify the password
            if ($farmer && password_verify($password, $farmer['password_hash'])) {
                // Start session if not already started
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Set farmer_id in session
                $_SESSION['farmer_id'] = $farmer['farmer_id'];
                
                return $farmer['farmer_id']; // Return the farmer_id on successful login
            } else {
                return false; // Login failed
            }
        } catch (Exception $e) {
            // Log the error
            error_log($e->getMessage());
            return false; // Login failed
        }
    }
}
?>