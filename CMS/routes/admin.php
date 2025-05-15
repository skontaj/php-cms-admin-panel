<?php

    // GET REQUESTS

    $router->get('/admin/users', function () {
        AuthMiddleware::requireAdmin();

        $userModel = new User();
        $users = $userModel->getAllExceptCurrent(Session::get('user')['id']);

        View::render('admin/users', [
            'title' => 'Korisnici',
            'users' => $users
        ]);
    });

    $router->get('/admin/dashboard', function () {
        AuthMiddleware::requireAdmin();
        View::render('admin/dashboard', [
            'title' => 'Admin Panel'
        ]);
    });
    
    $router->get('/admin/user/(\d+)/edit', function ($id) {
        AuthMiddleware::requireAdmin();

        $userModel = new User();
        $user = $userModel->findUserWithPosts($id);

        if (!$user) {
            http_response_code(404);
            echo "User not found.";
            return;
        }

        View::render('admin/edit_user', [
            'user' => $user
        ]);
    });

    $router->get('/admin/posts/pending', function () {
        AuthMiddleware::requireAdmin(); // ako imaš proveru admin pristupa

        $post = new Post();
        $perPage = 5;
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $offset = ($page - 1) * $perPage;

        $posts = $post->getPendingPaginated($perPage, $offset);
        $totalPosts = $post->countPending();
        $totalPages = ceil($totalPosts / $perPage);

        View::render('admin/pending_posts', [
            'posts' => $posts,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    });



    // POST REQUESTS

    
    $router->post('/admin/posts/approve/(\d+)', function ($id) {
        AuthMiddleware::requireAdmin();
        $post = new Post();
        $post->approve($id);
        header('Location: /CMS/public/admin/posts/pending');
        exit;
    });

    $router->post('/admin/posts/delete/(\d+)', function ($id) {
        AuthMiddleware::requireAdmin();
        $post = new Post();
        $post->delete($id);
        header('Location: /CMS/public/admin/posts/pending');
        exit;
    });

    $router->post('/admin/user/(\d+)/update', function ($id) {
        AuthMiddleware::requireAdmin();

        $userModel = new User();

        $role = $_POST['role'] ?? null;
        if (!in_array($role, ['user', 'admin'])) {
            http_response_code(400);
            echo "Nevažeća uloga.";
            return;
        }

        $user = $userModel->findUserById($id);
        if (!$user) {
            http_response_code(404);
            echo "Korisnik nije pronađen.";
            return;
        }

        $userModel->updateRole($id, $role);

        header("Location: " . BASE_URL . "/admin/user/$id/edit");
        exit;
    });

    $router->post('/admin/user/(\d+)/delete', function ($id) {
        AuthMiddleware::requireAdmin();

        $userModel = new User();

        $user = $userModel->findUserById($id);
        if (!$user) {
            http_response_code(404);
            echo "Korisnik nije pronađen.";
            return;
        }

        $userModel->delete($id);

        header("Location: " . BASE_URL . "/admin/users");
        exit;
    });

    $router->post('/admin/post/(\d+)/delete', function ($id) {
        AuthMiddleware::requireAdmin();

        $postModel = new Post();

        $post = $postModel->findById($id);
        if (!$post) {
            http_response_code(404);
            echo "Post nije pronađen.";
            return;
        }

        $postModel->delete($id);

        // Vrati se na edit korisnika
        header("Location: " . BASE_URL . "/admin/user/" . $post['user_id'] . "/edit");
        exit;
    });
