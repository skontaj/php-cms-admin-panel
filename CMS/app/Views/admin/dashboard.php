<?php

// Sprečava direktan pristup fajlu
if (!defined('APP_STARTED')) {
    header("Location: /CMS/public/register");
    exit;
}
?>