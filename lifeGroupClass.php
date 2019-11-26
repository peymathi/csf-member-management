<?php 
class LifeGroup
{
	private $LifeGroupID;
	private $LifeGroupName;
	private $Members;
	
	function __construct($LifeGroupID, $LifeGroupName, $Members)
	{
		$this->LifeGroupID = $LifeGroupID;
		$this->LifeGroupName = $LifeGroupName;
		$this->Members  = $Members;
		
		
	}
	
    public function getLifeGroupID()
    {
        return $this->LifeGroupID;
    }
    public function setLifeGroupID($LifeGroupID)
    {
        $this->LifeGroupID = $LifeGroupID;
    }
	
    public function getLifeGroupName()
    {
        return $this->LifeGroupName;
    }
    public function setLifeGroupName($LifeGroupName)
    {
        $this->LifeGroupName = $LifeGroupName;
    }
	
    public function getMembers()
    {
        return $this->Members;
    }
    public function setMembers($Members)
    {
        $this->Members = $Members;
    }
}