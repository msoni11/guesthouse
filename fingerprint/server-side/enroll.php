<?php
// Including the class GrFingerService
include 'GrFingerService.php';
// Check if template is empty
if(!isset($_POST['tpt']) && !isset($_POST['id']))
	exit;
$grs = new GrFingerService();
// Calling the application startup code
if($grs->initialize())
{
	// Posting the template to be enrolled
	$id = $grs->enroll($_POST['tpt'],$_POST['id']);
	// Returning the result of the enroll process
	echo "{ret:0,id:".$id."}";
	// Calling the finalization code
	$grs->finalize();
}
?>
