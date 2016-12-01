//Must change to the path that contains the files "enroll.php", "identify.php" and "verify.php"
var url_server="http://localhost/~mahendrasoni/GrFingerService/"

//Initializes the Fingerprint SDK library and the Capture
function Initialize() {
	try
	{
	GrFingerX.Initialize();
	GrFingerX.CapInitialize();
	}
	catch (e)
	{
	alert(e);
	}
}

//Finalizes the Fingerprint SDK library
function Finalize() {
	GrFingerX.Finalize();	
}

/*	
Writes the appropriate message on the log based on the verification
Parameter:	Objpost - Object containing the return of the verification
*/
function post_verify(Objpost){
	if(Objpost.ret == 0){
		document.getElementById('log').value = document.getElementById('log').value + "Not Found\n";
		document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
	}
	else if(Objpost.ret == 1){
		document.getElementById('log').value = document.getElementById('log').value + "Verified\n";
		document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
	}
	else{
		document.getElementById('log').value = document.getElementById('log').value + "Error = " + Objpost.ret + "\n";	
		document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
	}
}

/*	
	Writes the appropriate message on the log based on the identification
	Parameter:	Objpost - Object containing the return of the identification
*/
function post_identify(Objpost){
	if(Objpost.ret == 0){
			document.getElementById('log').value = document.getElementById('log').value + "Not Found\n";
			document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
		}
		else if(Objpost.ret == 1){
			document.getElementById('log').value = document.getElementById('log').value + "Identified with id = " + Objpost.id + "\n";
			document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
		}
		else{
			document.getElementById('log').value = document.getElementById('log').value + "Error = " + Objpost.ret + "\n";	
			document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
		}
}

/*
	Communicates with the appropriate php page that execute the nroll, dentification or verification.
	Sends information about the template and, for verification, the id of the reference template with wich must be compared
	Receives a return of sucess or error and the id of the template identified or enrolled.
	Parameter:	tpt - tempalte
				id_ref - id of the reference template (used only for verification)
				f - Identifies if it supposed to enroll (1), identify (2), or verify (3)
*/
function post(tpt,id_ref,f){
	var http = new XMLHttpRequest();
	var url;
	switch(f){
		case 1:
			url	= url_server + "enroll.php";
			break;
		case 2:
			url	= url_server + "identify.php";
			break;
		case 3:
			url	= url_server + "verify.php";
			break;
	}
	var params;
	if(id_ref == 0)
		params = "tpt="+encodeURIComponent(tpt);
	else
		params = "tpt="+encodeURIComponent(tpt)+"&id="+id_ref;
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");
	http.onreadystatechange = function() {	//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			var Objpost = eval('(' + http.responseText + ')'); //Adaptate the return to an Object form
			switch(f){
				case 1:
					document.getElementById('log').value = document.getElementById('log').value + "Enrolled with id = " + Objpost.id + "\n";
					document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
					break;
				case 2:
					post_identify(Objpost);
					break;
				case 3:
					post_verify(Objpost);
					break;
			}
		}
	}
	http.send(params);
}

/*
	Extracts the template of the image and calls the function responsable for the Verification
	Parameters:	rawImg - Image acquired by the sensor
				w - Image width in pixels
				h - Image height in pixels
				res - Image resolution in DPI
*/
function CallVerify(rawImg, w, h, res){
	try
	{
		var result = GrFingerX.ExtractJSON(rawImg, w, h, res, GrFingerX.GR_DEFAULT_CONTEXT,GrFingerX.GR_FORMAT_DEFAULT);
		var Objret = eval('(' + result + ')');	//Adaptate the return to an Object form
		var ret = GrFingerX.FreeJSON(result);
		if(Objret.ret < 0){
			document.getElementById('log').value = document.getElementById('log').value + "Extract Error = " + Objret.ret + "\n";
			document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
		}
		else
		{
			var id_ref = document.getElementById('ref_id').value;
			post(Objret.tpt, id_ref,3);
		}
	}
	catch(e)
	{
		alert(e);
	}
}

/*
	Extracts the template of the image and calls the function responsable for the Identification
	Parameters:	rawImg - Image acquired by the sensor
				w - Image width in pixels
				h - Image height in pixels
				res - Image resolution in DPI
*/
function CallIdentify(rawImg, w, h, res){
	try
	{
		var result = GrFingerX.ExtractJSON(rawImg, w, h, res, GrFingerX.GR_DEFAULT_CONTEXT,GrFingerX.GR_FORMAT_DEFAULT);
		var Objret = eval('(' + result + ')');	//Adaptate the return to an Object form
		var ret = GrFingerX.FreeJSON(result);
		if(Objret.ret < 0){
			document.getElementById('log').value = document.getElementById('log').value + "Extract Error = " + Objret.ret + "\n";
			document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
		}
		else
		{
			post(Objret.tpt,0,2);
		}
	}
	catch(e)
	{
		alert(e);
	}
}

/*
	Starts the Enrollment process, enrolls images until consolidation of the template and calls the function responsable for saving the template
	Parameters:	rawImg - Image acquired by the sensor
				w - Image width in pixels
				h - Image height in pixels
				res - Image resolution in DPI
*/
function CallEnroll(rawImg, w, h, res){
	if(i == 0){
		result = GrFingerX.StartEnroll(GrFingerX.GR_DEFAULT_CONTEXT);	//Starts the Enrollment process
		document.getElementById('log').value = document.getElementById('log').value + "StartEnroll\n";
		i++;
	}
	var tptSize = w*h;
	result = GrFingerX.EnrollJSON(rawImg, w, h, res, GrFingerX.GR_FORMAT_DEFAULT, GrFingerX.GR_DEFAULT_CONTEXT);
	var saveConsolidatedTemplate = 0; 
	var retObj = eval('(' + result + ')');	//Adaptate the return to an Object form
	var ret = GrFingerX.FreeJSON(result);
	switch(retObj.ret){
		case 0:
			document.getElementById('log').value = document.getElementById('log').value + "Enrollment Not Ready\n";
			document.getElementById('log').value = document.getElementById('log').value + "Put your Finger Again\n";
			document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
			break;
		case 1:
			document.getElementById('log').value = document.getElementById('log').value + "Sufficient enrollment\n";
			document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
			 //if we consolidated at least 8 templates and did not reach GR_ENROLL_GOOD, 
			 //we stop consolidation and save the current consolidated template
			if(i > 7){
				saveConsolidatedTemplate = true;
			}
			else
				document.getElementById('log').value = document.getElementById('log').value + "Put you finger again\n"; 
				document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
			break;
		case 2:
			saveConsolidatedTemplate = true;
			document.getElementById('log').value = document.getElementById('log').value + "Good enrollment\n";
			document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
            break;
		case 3:
			saveConsolidatedTemplate = true;
			document.getElementById('log').value = document.getElementById('log').value + "Very good enrollment\n";
			document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
            break;
		case 4:
			// no more templates can be consolidated
			// save the current consolidated template
            saveConsolidatedTemplate = true;                            
            break;
		default:
			break;
	}
	if(saveConsolidatedTemplate)
	{
		i = -1;
		post(retObj.tpt,0,1);
	}
	i++;
}