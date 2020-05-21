<?php

// Class to represent the current session

include 'authenticatedUser.php';

class Session
{
  const STATE_IN = "IN";
  const STATE_OUT = "OUT";
  const STATE_CHECK_IN = "CI";

  // Variable that contains the authenticated user
  private $authUser;

  // Session state. Either logged in, logged out, or checking in.
  private $state;
  private $time;
  private $inactive;

  public function __construct()
  {
    $this->authUser = new AuthenticatedUser();
    $this->state = Session::STATE_OUT;
    $this->time = time();
    $this->inactive = False;
  }

  public function authenticate()
  {
    $this->time = time();

    // Check if authentication is for check in or all
    if ($this->state === Session::STATE_CHECK_IN)
    {
      $this->authUser->giveCheckIn();
    }

    else
    {
      $this->state = Session::STATE_IN;
      $this->authUser->giveAll();
    }
  }

  public function destroy()
  {
    $this->state = Session::STATE_OUT;
    $this->authUser->removeRights();
  }

  public function checkIn()
  {
    $this->state = Session::STATE_CHECK_IN;
    $this->authUser->giveCheckIn();
  }

  public function getState()
  {
    return $this->state;
  }

  public function getTime()
  {
    return $this->time;
  }

  public function resetTime()
  {
    $this->time = time();
  }

  public function wasInactive()
  {
    return $this->inactive;
  }

  public function toggleInactive()
  {
    if($this->inactive) $this->inactive = False;
    else $this->inactive = True;
  }
}

?>
