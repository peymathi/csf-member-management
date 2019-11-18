<?php 
class UserCheckin
{
	private $MemberID;
	private $FirstName;
	private $LastName;
	private $EmailAddress;
	private $HomeAddress;
	private $PhoneNumber;
	private $PhotoPath;
	private $PrayerRequest;
	private $OptEmail;
	private $OptText;
	private $GroupID;
	function __construct($MemberID = 0, $FirstName = "", $LastName = "", $EmailAddress = "", $HomeAddress = "", $PhoneNumber = 0,$PhotoPath = "", $PrayerRequest = "", $OptEmail = 0, $OptText = 0, $GroupID = 0)
	{
		$this->MemberID = $MemberID;
		$this->FirstName = $FirstName;
		$this->LastName  = $LastName;
		$this->EmailAddress = $EmailAddress;
		$this->HomeAddress = $HomeAddress;
		$this->PhoneNumber = $PhoneNumber;
		$this->PhotoPath = $PhotoPath;
		$this->PrayerRequest = $PrayerRequest;
		$this->OptEmail = $OptEmail;
	}
    public function getMemberID()
    {
        return $this->MemberID;
    }
    public function setMemberID($MemberID)
    {
        $this->MemberID = $MemberID;
    }
    public function getFirstName()
    {
        return $this->FirstName;
    }
    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;
    }
    public function getLastName()
    {
        return $this->LastName;
    }
    public function setLastName($LastName)
    {
        $this->LastName = $LastName;
    }
    public function getEmailAddress()
    {
        return $this->EmailAddress;
    }
    public function setEmailAddress($EmailAddress)
    {
        $this->EmailAddress = $EmailAddress;
    }
    public function getHomeAddress()
    {
        return $this->HomeAddress;
    }
    public function setHomeAddress($HomeAddress)
    {
        $this->HomeAddress = $HomeAddress;
    }
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }
    public function setPhoneNumber($PhoneNumber)
    {
        $this->PhoneNumber = $PhoneNumber;
    }
    public function getPhotoPath()
    {
        return $this->PhotoPath;
    }
    public function setPhotoPath($PhotoPath)
    {
        $this->PhotoPath = $PhotoPath;
    }
    public function getPrayerRequest()
    {
        return $this->PrayerRequest;
    }
    public function setPrayerRequest($PrayerRequest)
    {
        $this->PrayerRequest = $PrayerRequest;
    }
    public function getOptEmail()
    {
        return $this->OptEmail;
    }
    public function setOptEmail($OptEmail)
    {
        $this->OptEmail = $OptEmail;
    }
	public function getOptText()
    {
        return $OptText->OptText;
    }
    public function setOptText($OptText)
    {
        $this->OptText = $OptText;
    }
	public function getGroupID()
    {
        return $this->GroupID;
    }
    public function setGroupID($GroupID)
    {
        $this->GroupID = $GroupID;
    }
}