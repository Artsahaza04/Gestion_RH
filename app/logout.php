<?php
session_start();
session_destroy();

// Retour au login
header("Location: login.php");
exit;
