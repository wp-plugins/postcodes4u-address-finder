function SearchBegin() {
	var scriptTag = document.getElementById("postcodes4youelelement");
	var headTag = document.getElementsByTagName("head").item(0);
	var strUrl = "";
	var SearchTerm = document.getElementById("postcode").value;
	var key = document.getElementById("postcodes4ukey").innerHTML;
	var user = document.getElementById("postcodes4uuser").innerHTML;

	//Build the url
	strUrl = "http://services.3xsoftware.co.uk/Search/ByPostcode/json?";
	strUrl += "username=" + encodeURI(user);
	strUrl += "&key=" + encodeURI(key);
	strUrl += "&postcode=" + encodeURI(SearchTerm);
	strUrl += "&callback=SearchEnd";

	//Make the request
	if (scriptTag) {
		try {
			headTag.removeChild(scriptTag);
		}
		catch (e) {
			//Ignore
		}
	}
	scriptTag = document.createElement("script");
	scriptTag.src = strUrl;
	scriptTag.type = "text/javascript";
	scriptTag.id = "postcodes4youelelement";
	headTag.appendChild(scriptTag);
}

function SearchEnd(response) {
	//Test for an error
	if (response != null && response['Error'] != null) {
		//Show the error message
		alert(response['Error'].Cause);
	}
	else {
		var addresslist = response["Summaries"];
		//Check if there were any items found
		if (addresslist.length == 0) {
			alert("Sorry, no matching items found");
		}
		else {
			var dropdown = document.getElementById("dropdown");
			dropdown.style.display = '';
			dropdown.options.length = 0;
			dropdown.options.add(new Option("Select an address:", ""));
			for (var j = 0; j < addresslist.length; j++) {
				dropdown.options.add(new Option(addresslist[j].StreetAddress + ", " + addresslist[j].Place, addresslist[j].Id));
			}
		}
	}
}


function SearchIdBegin() {
	var scriptTag = document.getElementById("postcodes4youelelement");
	var headTag = document.getElementsByTagName("head").item(0);
	var strUrl = "";
	var Id = document.getElementById("dropdown").value;
	var key = document.getElementById("postcodes4ukey").innerHTML;
	var user = document.getElementById("postcodes4uuser").innerHTML;

	//Build the url
	strUrl = "http://services.3xsoftware.co.uk/search/byid/json?";
	strUrl += "username=" + encodeURI(user);
	strUrl += "&key=" + encodeURI(key);
	strUrl += "&id=" + encodeURI(Id);

	strUrl += "&callback=SearchIdEnd";

	//Make the request
	if (scriptTag) {
		try {
			headTag.removeChild(scriptTag);
		}
		catch (e) {
			//Ignore
		}
	}
	scriptTag = document.createElement("script");
	scriptTag.src = strUrl;
	scriptTag.type = "text/javascript";
	scriptTag.id = "postcodes4youelelement";
	headTag.appendChild(scriptTag);
}

function SearchIdEnd(response) {
	//Test for an error
	if (response != null && response['Error'] != null) {
		//Show the error message
		alert(response['Error'].Cause);
	
	}
	else {
		//Check if there were any items found
		if (response.length == 0) {
			alert("Sorry, no matching items found");
		}
		else {
		    var address = response["Address"];
		    document.getElementById("company").value = address.Company;
			document.getElementById("address1").value = address.Line1;
			document.getElementById("address2").value = address.Line2;
			document.getElementById("town").value = address.PostTown;
			document.getElementById("county").value = address.County;
			document.getElementById("postcode").value = address.Postcode;

			var dropdown = document.getElementById("dropdown");

			dropdown.style.display = 'none';
			dropdown.options.length = 0;

		}
	}
}