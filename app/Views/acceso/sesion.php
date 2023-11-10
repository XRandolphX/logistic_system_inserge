<?php
if (session_status() === PHP_SESSION_NONE) {
    header('Location:' . base_url() . '/iniciar-sesion');
    die();
} else {
    header('Location:' . base_url() . '/dashboard');
    die();
}
