<?php

class View {
    public static function render($viewName, $data = []) {
        extract($data);
        require_once PARTIALS_PATH . '/header.php';
        require_once VIEWS_PATH . "/$viewName.php";
        require_once PARTIALS_PATH . '/footer.php';
    }
}
