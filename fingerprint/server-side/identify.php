<?php
// Including the class GrFingerService
include("GrFingerService.php");
// Check if template is empty
if(!isset($_POST['tpt']))
	exit;
$grs = new GrFingerService();
// Calling the application startup code
if($grs->initialize())
{
	// Posting the template to be identified		
	$id = $grs->identify($_POST['tpt']);
	// Returning the result of the identification process
	if($id<=0)
		echo "{ret:".$id.",id:0}";
	else	
		echo "{ret:1,id:".$id."}";
	// Calling the finalization code
	$grs->finalize();
}
?>