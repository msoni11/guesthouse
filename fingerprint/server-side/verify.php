<?php
// Including the class GrFingerService
include("GrFingerService.php");
// Check if template or id is empty	
if(!isset($_POST['tpt']) || !isset($_POST['id']))
	exit;
$grs = new GrFingerService();
// Calling the application startup code
if($grs->initialize())
{
	// Posting the template and the database template id to verify match
	$id = $grs->verify($_POST['id'],$_POST['tpt']);
	// Returning the result of the verification process
	if($id<=0)
		echo "{ret:".$id.",id:0}";
	else
		echo "{ret:1,id:".$id."}";
	// Calling the finalization code
	$grs->finalize();
}
?>