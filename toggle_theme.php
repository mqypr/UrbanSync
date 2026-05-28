<?php
require_once 'settings.php';

/* EXTRA FEATURE: Dark/light mode toggle persisted via cookie */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $current = $_COOKIE['dark_mode'] ?? '0';
  $new = $current === '1' ? '0' : '1';

  // update cookie
  setcookie('dark_mode', $new, [
    'expires'  => time() + 60 * 60 * 24 * 30,
    'path'     => '/',
    'secure'   => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
  ]);
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
exit;
