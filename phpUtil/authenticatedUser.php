<?php
// Class to contain all information about an authenticated user
class AuthenticatedUser
{
  const ACCESS_NONE = "N";
  const ACCESS_ALL = "A";
  const ACCESS_CHECK_IN = "C";

  // String that contains the current access rights that the Authenticated user
  // has. Current possibilities are: "N" = None (User is not logged in at all), "A" = All
  // (User can access everything), "C" = Check in (User can access all check in pages)
  private $accessRights;

  // User must have
  public function __construct()
  {
    $accessRights = AuthenticatedUser::ACCESS_NONE;
  }

  // Method to give all access rights
  public function giveAll()
  {
    $this->accessRights = AuthenticatedUser::ACCESS_ALL;
  }

  // Method to give check in rights
  public function giveCheckIn()
  {
    $this->accessRights = AuthenticatedUser::ACCESS_CHECK_IN;
  }

  // Method to remove all access rights
  public function removeRights()
  {
    $this->accessRights = AuthenticatedUser::ACCESS_NONE;
  }

  // Method to check for all access rights
  public function checkAll()
  {
    if ($this->accessRights === AuthenticatedUser::ACCESS_ALL)
    {
      return True;
    }

    return False;
  }

  // Method to check for check in rights
  public function checkCheckIn()
  {
    if ($this->accessRights === AuthenticatedUser::ACCESS_NONE)
    {
      return False;
    }

    return True;
  }
}

?>
