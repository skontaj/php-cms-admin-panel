<?php

require_once CLASSES_PATH . '/Login.php';
require_once CLASSES_PATH . '/Register.php';
require_once CLASSES_PATH . '/User.php';
require_once CLASSES_PATH . '/Post.php';

//GET REQUESTS

$router->get('/', function() {
    $posts = new Post();
    $result = $posts->getAllApproved();
    
    View::render('home', [
        'title' => 'Početna',
        'posts' => $result
    ]);
});

$router->get('/kontakt', function() {
    View::render('kontakt', ['title' => 'Kontakt']);
});

$router->get('/login', function() {
    AuthMiddleware::requireGuest();
    View::render('login', ['title' => 'Login']);
});

$router->get('/profile', function() {
    AuthMiddleware::requireLogin();
    View::render('profile', ['title' => 'Profil']);
});

$router->get('/create-post', function() {
    AuthMiddleware::requireLogin();
    View::render('create_post', ['title' => 'Create post']);
});

$router->get('/register', function() {
    AuthMiddleware::requireGuest();
    View::render('register', ['title' => 'Registracija']);
});

$router->get('/post/(\d+)', function($id) {
    $post = new Post();
    $result = $post->getById($id);
    
    if (!$result) {
        http_response_code(404);
        echo "Post not found.";
        return;
    }
    
    View::render('post-detail', [
        'title' => $result['title'],
        'post' => $result
    ]);
});

//POST REQUESTS


$router->post('/login', function () {
    AuthMiddleware::requireGuest();
   
    $login = new Login();

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $result = $login->login($email, $password);

    // Ako ima grešaka, renderuj login sa greškama
    if (!$result['success']) {
        View::render('login', [
            'errors' => $result['errors'],
        ]);
        return;
    }

    // Uspešno logovanje – redirekcija na dashboard
    View::render('profile', ['title' => 'Profil']);
    exit;
});

$router->post('/register', function () {
    AuthMiddleware::requireGuest();

    $register = new Register();

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $result = $register->register($name, $email, $password, $confirmPassword);

    // Ako ima grešaka, renderuj register sa greškama
    if (!$result['success']) {
        View::render('register', [
            'errors' => $result['errors'],
        ]);
        return;
    }

    // Uspešno registracija – redirekcija na login
    View::render('profile', ['title' => 'Profil']);
    exit;
});

$router->post('/logout', function () {
    AuthMiddleware::requireLogin();
    Auth::logout();
});

$router->post('/update-email', function () {
    AuthMiddleware::requireLogin();
    
    $user = new User();

    $newEmail = trim($_POST['email'] ?? '');
    $result = $user->updateEmail($_SESSION['user']['id'], $newEmail);

    // Ako ima grešaka, renderuj profil sa greškama
    if (!$result['success']) {
        View::render('profile', [
            'errors' => $result['errors'],
        ]);
        return;
    } else {
        $_SESSION['user']['email'] = $newEmail;
        View::render('profile', [
            'message' => $result['message'],
        ]);
        return;
    }
});

$router->post('/update-password', function () {
    AuthMiddleware::requireLogin();
    
    $user = new User();

    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $result = $user->updatePassword($_SESSION['user']['id'], $currentPassword, $newPassword, $confirmPassword);

    // Ako ima grešaka, renderuj profil sa greškama
    if (!$result['success']) {
        View::render('profile', [
            'errors' => $result['errors'],
        ]);
        return;
    } else {
        View::render('profile', [
            'message' => $result['message'],
        ]);
        return;
    }
});

$router->post('/delete-account', function () {
    AuthMiddleware::requireLogin();
    
    $user = new User();
    $result = $user->deleteAccount($_SESSION['user']['id']);

    // Ako ima grešaka, renderuj profil sa greškama
    if (!$result['success']) {
        View::render('profile', [
            'errors' => $result['errors'],
        ]);
        return;
    } else {
        $_SESSION = [];
        Session::destroy();
        View::render('login', [
            'message' => $result['message'],
        ]);
        return;
    }
});

$router->post('/create-post', function () {
    AuthMiddleware::requireLogin();

    $userId = $_SESSION['user']['id'];
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $file = $_FILES['image'] ?? null;

    $post = new Post();
    $result = $post->create($userId, $title, $content, $file);

    if ($result['success']) {
        View::render('create_post', ['message' => $result['message']]);
    } else {
        View::render('create_post', [
            'errors' => $result['errors'],
            'title' => $title,
            'content' => $content
        ]);
    }
});
