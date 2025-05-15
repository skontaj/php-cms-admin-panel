<?php

class AuthMiddleware
{
    // Zaštićeni pristup samo za ulogovane korisnike
    public static function requireLogin()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /CMS/public/login');
            exit;
        }
    }

    // Zaštićeni pristup samo za neregistrovane korisnike (goste)
    public static function requireGuest()
    {
        if (isset($_SESSION['user'])) {
            header('Location: /CMS/public/profile');
            exit;
        }
    }

    // Zaštićeni pristup samo za administratore
    public static function requireAdmin()
    {
        self::requireLogin(); // Prvo proveri da je korisnik ulogovan

        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: /CMS/public/profile');  // Ako nije admin, preusmeri ga
            exit;
        }
    }
}

    
