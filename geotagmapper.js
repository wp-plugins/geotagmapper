<!--
/*
ajax bei Juergen Schulze, www.juergen-schulze.de
	ajax('address', 'result', [GET|POST], String formid, NOSTRING ReturnFunctionaName); -> print result into <div id="result"></div>
	ajax('address', null, [GET|POST], formid); -> sends the result to function "returnformaction" in calling page
	method (GET or POST) must be given in capital letters
	
	example: ajax('./check_input.php', 'mydiv', 'GET', 'myform', displayMessage);
	Be careful: ReturnFunctionName must not be a string, so don't use Quotes
*/
function ajax(address, output, method, formid, returnFunctionName) {
	//alert(formid);
	var xmlHttp = null;
	// Mozilla, Opera, Safari and Internet Explorer 7
	if (typeof XMLHttpRequest != 'undefined') {
	    xmlHttp = new XMLHttpRequest();
	}
	if (!xmlHttp) {
	    // Internet Explorer 6 or older
	    try {
	        xmlHttp  = new ActiveXObject("Msxml2.XMLHTTP");
	    } catch(e) {
	        try {
	            xmlHttp  = new ActiveXObject("Microsoft.XMLHTTP");
	        } catch(e) {
	            xmlHttp  = null;
	        }
	    }
	}

	if (xmlHttp) {
		if (method=='GET') {
			// GET
			if (address.match(/\?/i)) {
				address=address+'&'+Math.floor(Math.random() * 99999999999)
			} else {
				address=address+'?'+Math.floor(Math.random() * 99999999999)
			}
			xmlHttp.open('GET', address, true);
			xmlHttp.send(null);
		} else {
			// POST
			xmlHttp.open('POST', address, true);
			xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
			xmlHttp.setRequestHeader("Pragma", "no-cache"); 
			//xmlHttp.setRequestHeader("Cache-Control", "must-revalidate"); 
			//xmlHttp.setRequestHeader("If-Modified-Since", document.lastModified); 

			if (formid!='') {
				formDataString = getFormData(formid);
			} else {
				formDataString='';
			}
			xmlHttp.send(formDataString);
		}

		if (!xmlHttp) {
			alert('can not build xmlHttp');
			return false;
		}		
		
	    xmlHttp.onreadystatechange = function () {
			//alert('State: '+xmlHttp.readyState);
	        if (xmlHttp.readyState == 4) {
				//alert('Status: '+xmlHttp.status);
				if (xmlHttp.status == 200) {
				
					if (output) {
						// Print to DIV
						document.getElementById(output).innerHTML = xmlHttp.responseText;
					} 
					if (returnFunctionName) {
						// send back to function
						//alert(xmlHttp.responseText);
						returnFunctionName(xmlHttp.responseText);
					}
					
				} else {
					alert('Ajax request Error: '+address+'\nPlease try again in a few seconds');
				}
	        }
			
	    }
		

	}
	
}

// get all the form values back as an sendable string
function getFormData(formid) {
		//alert(formid);
		queryString = "";
		for(n=0; n < document.getElementById(formid).elements.length; n++) {
			elementType = document.getElementById(formid).elements[n].type;
			elementName = document.getElementById(formid).elements[n].name; 
			elementValue = document.getElementById(formid).elements[n].value;
			//alert (elementType+":"+elementName+"="+elementValue+"("+document.getElementById(formid).elements[n].checked+")");
			if (elementType=="checkbox") {
				if (document.getElementById(formid).elements[n].checked==true) {
					//elementValue='true';
				} else {
					elementName='';
				}
			}
			if (elementType=="radio") {
				if (document.getElementById(formid).elements[n].checked!=true) {
					elementName='';
				}			
			}
			
			if (elementName!='') {
				queryString += elementName+"="+encodeURIComponent(elementValue)+"&";
			}
			
		}
		return queryString;
}

function parseXML(text, tag, parent,child) {
try //Internet Explorer
  {
  xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
  xmlDoc.async="false";
  xmlDoc.loadXML(text);
  }
catch(e)
  {
  try //Firefox, Mozilla, Opera, etc.
  {
  parser=new DOMParser();
  xmlDoc=parser.parseFromString(text,"text/xml");
  }
  catch(e)
  {
  alert(e.message);
  return;
  }
}
return (xmlDoc.getElementsByTagName(tag)[parent].childNodes[child].nodeValue);
}

// detect geo information with ajax api call
function geotagmapperDetect(ajaxurl) {
	//ajaxurl='http://localhost/adtwitt/wp-content/plugins/geotagmapper/proxy.php';
	ajax(ajaxurl, null, 'POST', 'my_plugin_form', geotagmapperDetectBack);
}

function geotagmapperDetectBack(returnValue) {
	if (debug) alert(returnValue);
	returnStatus=parseXML(returnValue, 'status', 0, 0);
	if (returnStatus=='ZERO_RESULTS') alert('Sorry, no results found.');
	
	returnCity=parseXML(returnValue, 'long_name',2,0);
	returnStreet=parseXML(returnValue, 'long_name',1,0)+' '+parseXML(returnValue, 'long_name',0,0);
	returnCountryCode=parseXML(returnValue, 'short_name',5,0);
	returnCountry=parseXML(returnValue, 'long_name',5,0);
	returnStateCode=parseXML(returnValue, 'short_name',4,0);
	returnZip=parseXML(returnValue, 'short_name',6,0);
	returnTest=parseXML(returnValue, 'short_name',6,0);
	
	returnLat=parseXML(returnValue, 'lat', 0, 0);
	returnLng=parseXML(returnValue, 'lng', 0, 0);	
	
	document.getElementById('geotagmapper_lat').value=returnLat;
	document.getElementById('geotagmapper_lng').value=returnLng;
	document.getElementById('geotagmapper_country').value=returnCountry;
	document.getElementById('geotagmapper_state').value=returnStateCode;
	document.getElementById('geotagmapper_city').value=returnCity;
	document.getElementById('geotagmapper_street').value=returnStreet;
	document.getElementById('geotagmapper_zip').value=returnZip;
	document.getElementById('geotagmapper_country_code').value=returnCountryCode;
	
}
// -->