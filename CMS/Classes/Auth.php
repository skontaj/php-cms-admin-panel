<?php

    require_once 'Session.php';

    class Auth
    {
        public static function isLoggedIn()
        {
            return Session::has('user');
        }

        public static function isAdmin(): bool
        {
            return self::isLoggedIn() && Session::role() === 'admin';
        }

        public static function requireLogin()
        {
            if (!self::isLoggedIn())
            {
                header('Location: index.php');
                exit;
            }
        }

        public static function user()
        {
            return Session::get('user');
        }

        public static function login($userData)
        {
            Session::set('user', $userData);
        }

        public static function logout()
        {
            $_SESSION = [];
            Session::destroy();
            header('Location: /CMS/public/login');
            exit;
        }
    }
