<?php
class GrFingerService
{
	// Constants declation
	public $GR_OK = 0;
	public $GR_MATCH = 1;
	public $GR_DEFAULT_CONTEXT = 0;	
	public $GrFingerX;
	public $db;

	// Application startup code
	public function initialize()
	{
		// Initialize GrFingerX Library
		$this->GrFingerX = new COM('GrFingerX.GrFingerXCtrl.1') or die ('Could not initialise object.');
		com_load_typelib('{A9995C7C-77BF-4E27-B581-A4B5BBD90E50}');
		// Open sqlite database
		if ($this->db = sqlite_open('GrFingerSample.sqlite', 0666, $sqliteerror))
		{
			$query = sqlite_query($this->db, "SELECT name FROM sqlite_master WHERE type='table' and name='enroll'");
			$rows = sqlite_num_rows($query);
			if ($rows<1)
				sqlite_query($this->db, "CREATE TABLE enroll (id INTEGER PRIMARY KEY, tpt TEXT NOT NULL)");
		}
		else 
			return false;
		if($this->GrFingerX->Initialize() != $this->GR_OK)
			return false;
		return true;
	}
	
	// Application finalization code
	public function finalize()
	{
		sqlite_close ($this->db);
		$this->GrFingerX->Finalize();
	}
	
	//Add a fingerprint to database
	public function enroll($tpt)
	{
		// Insert the template into database
		sqlite_query($this->db, "INSERT INTO enroll (tpt) VALUES ('".$tpt."')");
		//return sqlite_last_insert_rowid ($this->db);
		return sqlite_last_insert_rowid ($this->db);
	}
	
	// Verify if two fingerprints match
	public function verify ($id,$rcvtpt)
	{		
		// Find and encode the database template to base 64
		$query = sqlite_query($this->db, "SELECT * FROM enroll WHERE id=".$id);
		$row = sqlite_fetch_array($query, SQLITE_ASSOC);		
		$score = 0;
		// Comparing the given template and the encoded one
		$ret = $this->GrFingerX->VerifyBase64($rcvtpt,$row["tpt"],$score,$this->GR_DEFAULT_CONTEXT);
		if($ret == $this->GR_MATCH)
			return $row["id"];
		else
			return $ret;
	}

	// Identify a fingerprint
	public function identify ($rcvtpt)
	{
		// Starting identification process
		$ret = $this->GrFingerX->IdentifyPrepareBase64($rcvtpt, $this->GR_DEFAULT_CONTEXT);
		if($ret!=$this->GR_OK)
			return $ret;
		// Getting enrolled templates from database
		$query = sqlite_query($this->db, "SELECT * FROM enroll");		
		$score = 0;
		while ($row = sqlite_fetch_array($query, SQLITE_ASSOC))
		{			
			// Comparing the current template and the given one
			$ret = $this->GrFingerX->IdentifyBase64($row["tpt"],$score,$this->GR_DEFAULT_CONTEXT);
			if( $ret == $this->GR_MATCH)
				return $row["id"];				
		}
		return 0;
	}
}
?>