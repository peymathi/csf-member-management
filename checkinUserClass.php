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
	
	function __construct($MemberID = "", $FirstName = "", $LastName = "", $EmailAddress = "", $HomeAddress = "", $PhoneNumber = "",$PhotoPath = "", $PrayerRequest = "", $OptEmail = 0, $OptText = 0, $GroupID = "")
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
		$this->OptText = $OptText;
		$this->GroupID = $GroupID;
		
	}
	
	/* GET/SET for MemberID*/
    public function getMemberID()
    {
        return $this->MemberID;
    }
    public function setMemberID($MemberID)
    {
        $this->MemberID = $MemberID;
    }
	
	/* GET/SET for FirstName*/
    public function getFirstName()
    {
        return $this->FirstName;
    }
    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;
    }
	
	/* GET/SET for LastName*/
    public function getLastName()
    {
        return $this->LastName;
    }
    public function setLastName($LastName)
    {
        $this->LastName = $LastName;
    }
	
	/* GET/SET for EmailAddress*/
    public function getEmailAddress()
    {
        return $this->EmailAddress;
    }
    public function setEmailAddress($EmailAddress)
    {
        $this->EmailAddress = $EmailAddress;
    }
	
	/* GET/SET for HomeAddress*/
    public function getHomeAddress()
    {
        return $this->HomeAddress;
    }
    public function setHomeAddress($HomeAddress)
    {
        $this->HomeAddress = $HomeAddress;
    }
	
	/* GET/SET for PhoneNumber*/
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }
    public function setPhoneNumber($PhoneNumber)
    {
        $this->PhoneNumber = $PhoneNumber;
    }
	
	/* GET/SET for PhotoPath*/
    public function getPhotoPath()
    {
        return $this->PhotoPath;
    }
    public function setPhotoPath($PhotoPath)
    {
        $this->PhotoPath = $PhotoPath;
    }
	
	/* GET/SET for PrayerRequest*/
    public function getPrayerRequest()
    {
        return $this->PrayerRequest;
    }
    public function setPrayerRequest($PrayerRequest)
    {
        $this->PrayerRequest = $PrayerRequest;
    }
	
	/* GET/SET for OptEmail*/
    public function getOptEmail()
    {
        return $this->OptEmail;
    }
    public function setOptEmail($OptEmail)
    {
        $this->OptEmail = $OptEmail;
    }
	
	/* GET/SET for OptText*/
	public function getOptText()
    {
        return $this->OptText;
    }
    public function setOptText($OptText)
    {
        $this->OptText = $OptText;
    }
	
	/* GET/SET for GroupID*/
	public function getGroupID()
    {
        return $this->GroupID;
    }
    public function setGroupID($GroupID)
    {
        $this->GroupID = $GroupID;
    }
}