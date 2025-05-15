<?php

    require_once 'Database.php';

    class Login extends Database
    {
        public function login($email, $password) {
            $errors = [];
    
            // Provere unosa
            if (empty(trim($email))) {
                $errors[] = "Email je obavezan.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Neispravan format email adrese.";
            }
    
            if (empty($password)) {
                $errors[] = "Lozinka je obavezna.";
            }
    
            // Ako ima grešaka, prekini
            if (!empty($errors)) {
                return ['success' => false, 'errors' => $errors];
            }
    
            // Provera korisnika
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$user || !password_verify($password, $user['password'])) {
                return ['success' => false, 'errors' => ["Pogrešan email ili lozinka."]];
            }
    
            // Uspešno logovanje
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
    
            return ['success' => true];
        }
    }
    
