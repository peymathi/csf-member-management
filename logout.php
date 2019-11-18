<?php
    session_start();
    include "phpUtil/sessionVerification.php";
    if (isset($_SESSION['session']))
    {
      $session = unserialize($_SESSION['session']);
      $session->destroy();
      $_SESSION['session'] = serialize($session);
    }

    Header("location: login.php");

    exit;
?>
