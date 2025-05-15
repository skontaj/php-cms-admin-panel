<?php

    require_once 'Database.php';

    class Register extends Database
    {
        public function register($name, $email, $password, $confirmPassword)
        {
            $errors = [];

            // Validacija imena
            if (empty(trim($name))) {
                $errors[] = "Ime je obavezno.";
            }

            // Validacija emaila
            if (empty(trim($email))) {
                $errors[] = "Email je obavezan.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Neispravan format email adrese.";
            }

            // Validacija lozinke
            if (empty($password)) {
                $errors[] = "Lozinka je obavezna.";
            } elseif (strlen($password) < 6) {
                $errors[] = "Lozinka mora imati najmanje 6 karaktera.";
            }

            if ($password !== $confirmPassword) {
                $errors[] = "Lozinke se ne poklapaju.";
            }

            // Ako ima grešaka, odmah vrati
            if (!empty($errors)) {
                return ['success' => false, 'errors' => $errors];
            }

            // Provera da li email već postoji
            $checkQuery = "SELECT id FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($checkQuery);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->fetch()) {
                return ['success' => false, 'errors' => ["Email adresa je već registrovana."]];
            }

            // Hash lozinke
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Upis korisnika
            $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                // Auto login nakon registracije (opcionalno)
                $_SESSION['user'] = [
                    'id' => $this->conn->lastInsertId(),
                    'name' => $name,
                    'email' => $email,
                    'role' => 'user'
                ];
                return ['success' => true];
            }

            // Ako upis nije uspeo
            return ['success' => false, 'errors' => ["Došlo je do greške prilikom registracije."]];
        }
    }
