<?php

// File to handle all session verification
include 'session.php';

// Function that verifies the current session
function session_verify()
{
  if (isset($_SESSION['session']))
  {
    $session = unserialize($_SESSION['session']);

    // If the session is in a logged in state check for inactivity
    if ($session->getState() != Session::STATE_OUT)
    {
      $session_time = $session->getTime();

      // 2 and a half hour inactivity limit
      if ($session_time  + 2.5 * (60 * 60) < time())
      {
        $session->toggleInactive();
        $session->destroy();
        $_SESSION['session'] = serialize($session);
        Header("Location: ../pages/login.php");
        exit;
      }

      else
      {
        $session->resetTime();
        $_SESSION['session'] = serialize($session);
      }
    }

    // Find out what page we are at
    $curpage = basename($_SERVER["PHP_SELF"]);

    // Route depending on the current page and authentication of user
    switch ($curpage)
    {
      case "change_password.php":
      case "dashboard.php":
      case "edit_member.php":
      case "register.php":
        if ($session->getState() != Session::STATE_IN) Header("Location: ../pages/login.php");
        break;

      case "checkin.php":
        if ($session->getState() === Session::STATE_OUT) Header("Location: ../pages/login.php");
        else $session->checkIn();
        $_SESSION['session'] = serialize($session);
        break;

      case "login.php":
        if ($session->getState() === Session::STATE_IN) Header("Location: ../pages/dashboard.php");
        else if ($session->getState() === Session::STATE_CHECK_IN) Header("Location: ../pages/checkin.php");
        break;
    }

  }

  else
  {
    $session = new Session();
    $_SESSION['session'] = serialize($session);

    // Check if we are already at login page
    if (basename($_SERVER['PHP_SELF']) != 'login.php')
    {
      Header("Location: ../pages/login.php");
      exit;
    }
  }
}

function isInactive()
{
 if (isset($_SESSION['session']))
 {
   $session = unserialize($_SESSION['session']);
   if ($session->wasInactive())
   {
     $session->toggleInactive();
     $_SESSION['session'] = serialize($session);
     return True;
   }
 }
 return False;
}

function authenticate()
{
  if (isset($_SESSION['session']))
  {
    $session = unserialize($_SESSION['session']);
    $session->authenticate();
    $_SESSION['session'] = serialize($session);

    if ($session->getState() === Session::STATE_IN) Header("Location: ../pages/dashboard.php");
    else  Header ("Location: ../pages/checkin.php");
  }

  else throw "Error in session verification. Session was not initialized.";
}

?>
