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
        // Open mysql database

        if ($this->db = new mysqli('localhost', 'root', 'qwER1234!', 'guesthouse'))
        {
            //DB initialized
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
        mysqli_close($this->db);
        $this->GrFingerX->Finalize();
    }
    
    //Add a fingerprint to database
    public function enroll($tpt, $id)
    {
        // Insert the template into database

        if ($this->db->query("UPDATE guest_infos SET finger_print='".$tpt."' WHERE id=".$id)) {
            return $id;
        } else {
            return false;
        }
    }
    
    // Verify if two fingerprints match
    public function verify ($id,$rcvtpt)
    {       
        // Find and encode the database template to base 64
        $query = $this->db->query("SELECT * FROM guest_infos WHERE id=".$id);
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);        
        $score = 0;
        // Comparing the given template and the encoded one
        $ret = $this->GrFingerX->VerifyBase64($rcvtpt,$row["finger_print"],$score,$this->GR_DEFAULT_CONTEXT);
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
        $query = $this->db->query("SELECT * FROM enroll");       
        $score = 0;
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
        {           
            // Comparing the current template and the given one
            $ret = $this->GrFingerX->IdentifyBase64($row["finger_print"],$score,$this->GR_DEFAULT_CONTEXT);
            if( $ret == $this->GR_MATCH)
                return $row["id"];              
        }
        return 0;
    }
}
?>