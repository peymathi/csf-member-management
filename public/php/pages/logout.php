<?php
    include "../phpUtil/sessionVerification.php";
    session_start();
    if (isset($_SESSION['session']))
    {
      $session = unserialize($_SESSION['session']);
      $session->destroy();
      $_SESSION['session'] = serialize($session);
    }

    Header("Location: login.php");

?>
