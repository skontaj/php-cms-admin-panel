<?php

    require_once 'Database.php';

    class User extends Database
    {
        public function updateEmail($userId, $newEmail)
        {
            $errors = [];

            if (empty($newEmail) || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Unesite ispravnu email adresu.";
            }

            // Provera da li već postoji email
            $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
            $stmt->bindParam(':email', $newEmail);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();

            if ($stmt->fetch()) {
                $errors[] = "Email adresa je već u upotrebi.";
            }

            if (!empty($errors)) {
                return ['success' => false, 'errors' => $errors];
            }

            $stmt = $this->conn->prepare("UPDATE users SET email = :email WHERE id = :id");
            $stmt->bindParam(':email', $newEmail);
            $stmt->bindParam(':id', $userId);

            return $stmt->execute()
                ? ['success' => true, 'message' => ['Email je uspješno promijenjen.']]
                : ['success' => false, 'errors' => ['Greška prilikom izmene email adrese.']];
        }

        public function updatePassword($userId, $current, $new, $confirm)
        {
            $errors = [];

            if (empty($current) || empty($new) || empty($confirm)) {
                $errors[] = "Sva polja za lozinku su obavezna.";
            }

            if (strlen($new) < 6) {
                $errors[] = "Nova lozinka mora imati najmanje 6 karaktera.";
            }

            if ($new !== $confirm) {
                $errors[] = "Nova lozinka i potvrda se ne poklapaju.";
            }

            if (!empty($errors)) {
                return ['success' => false, 'errors' => $errors];
            }

            // Provera trenutne lozinke
            $stmt = $this->conn->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($current, $user['password'])) {
                return ['success' => false, 'errors' => ['Trenutna lozinka nije tačna.']];
            }

            $hashedNew = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->bindParam(':password', $hashedNew);
            $stmt->bindParam(':id', $userId);

            return $stmt->execute()
                ? ['success' => true, 'message' => ['Lozinka je uspješno promijenjena.']]
                : ['success' => false, 'errors' => ['Greška prilikom izmene lozinke.']];
        }

        public function deleteAccount($userId) {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        
            return $stmt->execute()
                ? ['success' => true, 'message' => ['Nalog je uspešno obrisan.']]
                : ['success' => false, 'errors' => ['Došlo je do greške prilikom brisanja naloga.']];
        }
        
        public function getAllExceptCurrent($currentUserId)
        {
            $query = "SELECT id, name, email, role FROM users WHERE id != :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $currentUserId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function findUserWithPosts($id)
        {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $stmtPosts = $this->conn->prepare("SELECT * FROM posts WHERE user_id = ?");
                $stmtPosts->execute([$id]);
                $user['posts'] = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);
            }

            return $user;
        }

        public function findUserById($id)
        {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateRole($id, $role)
        {
            $stmt = $this->conn->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$role, $id]);
        }

        public function delete($id)
        {
            // Prvo brišemo njegove postove
            $this->conn->prepare("DELETE FROM posts WHERE user_id = ?")->execute([$id]);

            // Zatim korisnika
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
        }


    }
