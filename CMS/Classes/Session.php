<?php

    class Session
    {
        public static function start() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }

        public static function set($key, $value) {
            $_SESSION[$key] = $value;
        }

        public static function get($key) {
            return $_SESSION[$key] ?? null;
        }

        public static function has($key) {
            return isset($_SESSION[$key]);
        }

        public static function remove($key) {
            unset($_SESSION[$key]);
        }

        public static function role()
        {
            return self::get('user')['role'];
        }

        public static function destroy() {
            session_destroy();
        }

    }
