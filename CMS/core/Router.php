<?php

class Router {
    protected $routes = [];

    public function get($uri, $callback) {
        $uri = $this->normalizeUri($uri);
        $this->routes['GET'][$uri] = $callback;
    }

    public function post($uri, $callback) {
        $uri = $this->normalizeUri($uri);
        $this->routes['POST'][$uri] = $callback;
    }

    public function dispatch($uri, $method) {
        $uri = $this->normalizeUri($uri);

        // Prvo probaj tačno poklapanje
        if (isset($this->routes[$method][$uri])) {
            $callback = $this->routes[$method][$uri];
            if (is_callable($callback)) {
                call_user_func($callback);
                return;
            }
        }

        // Ako nema tačnog poklapanja, traži poklapanje sa regularnim izrazima
        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = "@^" . preg_replace('@\(:num\)@', '(\d+)', $route) . "$@";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Ukloni prvi match (cela ruta)
                if (is_callable($callback)) {
                    call_user_func_array($callback, $matches);
                    return;
                }
            }
        }

        http_response_code(404);
        echo "404 - Page not found.";
    }


    protected function normalizeUri($uri) {
        return rtrim($uri, '/') ?: '/';
    }
}
