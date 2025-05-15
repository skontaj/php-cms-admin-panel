<?php

    require_once 'Database.php';

    class Post extends Database
    {

        public function create($userId, $title, $content, $file = null)
        {
            $errors = [];

            if (empty($title)) {
                $errors[] = "Title is required.";
            }

            if (empty($content)) {
                $errors[] = "Content is required.";
            }

            $imagePath = null;

            if ($file && !empty($file['name'])) {
                $uploadDir = __DIR__ . '/../public/uploads/posts/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $originalName = basename($file['name']);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $safeName = pathinfo($originalName, PATHINFO_FILENAME);
                $uniqueName = $safeName . '_' . time() . '.' . $ext;
                $targetFile = $uploadDir . $uniqueName;

                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array(strtolower($ext), $allowedExtensions)) {
                    $errors[] = "Allowed file types: jpg, jpeg, png, gif.";
                }

                if (empty($errors)) {
                    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                        $imagePath = '/CMS/public/uploads/posts/' . $uniqueName;
                    } else {
                        $errors[] = "Failed to upload image.";
                    }
                }
            }

            if (!empty($errors)) {
                return [
                    'success' => false,
                    'errors' => $errors
                ];
            }

            $query = "INSERT INTO posts (user_id, title, content, image) VALUES (:user_id, :title, :content, :image)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':image', $imagePath);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => ["Post successfully created."]
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => ["Database error while creating post."]
                ];
            }
        }


        public function getAllApproved()
        {
            $query = "
                SELECT posts.*, users.name AS author_name
                FROM posts
                JOIN users ON posts.user_id = users.id
                WHERE posts.approved = 1
                ORDER BY posts.created_at DESC
            ";

            return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
        }

        public function countPending()
        {
            $stmt = $this->conn->query("SELECT COUNT(*) FROM posts WHERE approved = 0");
            return $stmt->fetchColumn();
        }

        public function getPendingPaginated($limit, $offset)
        {
            $stmt = $this->conn->prepare("SELECT * FROM posts WHERE approved = 0 ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function approve($id)
        {
            $stmt = $this->conn->prepare("UPDATE posts SET approved = 1 WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

        public function delete($id)
        {
            $stmt = $this->conn->prepare("DELETE FROM posts WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

        public function getById($id)
        {
            $stmt = $this->conn->prepare("
                SELECT posts.*, users.name AS author_name
                FROM posts
                JOIN users ON posts.user_id = users.id
                WHERE posts.id = :id AND posts.approved = 1
            ");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function findById($id)
        {
            $stmt = $this->conn->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

    }
