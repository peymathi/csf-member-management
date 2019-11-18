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
    if ($session->getState() === Session::STATE_IN)
    {
      $session_time = $session->getTime();

      if ($session_time  +  2 * (60 * 60) < time())
      {
        $session->destroy();
        $_SESSION['session'] = serialize($session);
        Header("Location: login.php");
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
        if ($session->getState() != Session::STATE_IN) Header("Location: login.php");
        break;

      case "checkin.php":
      case "edit_member.php":
      case "register.php":
        if ($session->getState() === Session::STATE_OUT) Header("Location: login.php");
        break;

      case "login.php":
        if ($session->getState() === Session::STATE_IN) Header("Location: dashboard.php");
        else if ($session->getState() === Session::STATE_CHECK_IN) Header("Location: checkin.php");
        break;
    }

  }

  else
  {
    $session = new Session();
    $_SESSION['session'] = serialize($session);
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
    echo $session->getState();
    if ($session->getState() === Session::STATE_IN) Header("Location: dashboard.php");
    else  Header ("Location: checkin.php");
  }

  else throw "Error in session verification. Session was not initialized.";
}

?>
