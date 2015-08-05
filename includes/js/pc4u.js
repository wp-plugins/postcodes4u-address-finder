// Public Variables
var pc4uCallingFormCode = "";
var pc4uLookupFormCode = "";

// Postcode4u Lookup Called From Basic 'Blog' Form
// ===============================================
function Pc4uSearchBegin() {
    pc4uCallingFormCode = "";
    pc4uPostcodeSearchBegin();
}

// Postcode4u Lookup Called From WooCommerce Checkout
// - Billing Address
// ===============================================
function Pc4uWooSearchBookingBegin() {
    // Ensure Billing county is set to UK
   var dCountry = document.getElementById("billing_country");    
    if (dCountry == null || dCountry.value == "GB" || dCountry.value == null || dCountry.value == "") {
        // Process WooCommerce Billing Postcode
        pc4uCallingFormCode = "pc4uWooBilling";   
       
        pc4uPostcodeSearchBegin();
    } else {
        // Invalid Country
        alert("Billing Postcode Lookup is only valid when the country is set as the UK.");

        pc4uCallingFormCode = "";
        // Ensure No Address Lookups are displayed
        var lookupDropdown = document.getElementById("pc4uWooBillingDropdown");
        lookupDropdown.style.display = 'none';
    }
}

// Postcode4u Lookup Called From WooCommerce Checkout
// - Shipping Address 
// ===============================================
function Pc4uWooSearchShippingBegin() {
    // Ensure Shipping county is set to UK
    var dCountry = document.getElementById("shipping_country");
    if (dCountry == null || dCountry.value == "GB" || dCountry.value == null || dCountry.value == "") {
        // Process WooCommerce Shipping Postcode
        pc4uCallingFormCode = "pc4uWooShipping";
        pc4uPostcodeSearchBegin();
    } else {
        // Invalid Country
        alert("Shipping Postcode Lookup is only valid when the country is set as the UK.");
        pc4uCallingFormCode = "";
        // Ensure No Address Lookups are displayed
        var lookupDropdown = document.getElementById("pc4uWooShippingDropdown");
        if (lookupDropdown !== null) {
            lookupDropdown.style.display = 'none';
        }
    }
}

// ===============================================
// Postcode4u Lookup Common 'Start Search Process'
//  Generate Postcodes4u Search Request
// ===============================================
function pc4uPostcodeSearchBegin() {
    var scriptTag = document.getElementById("postcodes4youelelement");
    var headTag = document.getElementsByTagName("head").item(0);
    var strUrl = "";
   

    var pc4ukey = document.getElementById("postcodes4ukey").innerHTML;
    var pc4uuser = document.getElementById("postcodes4uuser").innerHTML;

    // Ensure Pc4u Username and Key set up
    if (pc4ukey !== null && pc4ukey != "") {
        if (pc4uuser !== null && pc4uuser != "") {

            var pc4uPostcodeFieldName = "pc4uPostcode";

            // Decode Calling Form Code - Postcode Field
            if (pc4uCallingFormCode == "pc4uWooBilling") {
                pc4uPostcodeFieldName = "billing_postcode";

            } else {
                if (pc4uCallingFormCode == "pc4uWooShipping") {
                    pc4uPostcodeFieldName = "shipping_postcode";
                }
            }
            var SearchTerm = document.getElementById(pc4uPostcodeFieldName).value;

            //Build the url
            //  Check if HTTPS
            if (window.location.protocol == "'https:") {
                strUrl = "https://";
            } else {
                strUrl = "http://";
            }
            strUrl += "services.3xsoftware.co.uk/Search/ByPostcode/json?";
            strUrl += "username=" + encodeURI(pc4uuser);
            strUrl += "&key=" + encodeURI(pc4ukey);
            strUrl += "&postcode=" + encodeURI(SearchTerm);
            strUrl += "&callback=Pc4uSearchEnd";

            //Make the request
            if (scriptTag) {
                try {
                    headTag.removeChild(scriptTag);
                }
                catch (e) {
                    //Ignore
                    // alert("pc4uPostcodeSearchBegin Error:" + e.message);
                }
            }
            scriptTag = document.createElement("script");
            scriptTag.src = strUrl;
            scriptTag.type = "text/javascript";
            scriptTag.id = "postcodes4youelelement";
            headTag.appendChild(scriptTag);
        } else {
            // No Pc4u Username
            alert("Postcode4u Configuration Error: No Username")
        }
    } else {
        // No Pc4u Key
        alert("Postcode4u Configuration Error: No User Key")
    }
}

// ===============================================
// Postcode4u Lookup 'Return 'Callback' Function
//  Show matching Postcode Addresses Postcodes4u Search Request
// ===============================================
function Pc4uSearchEnd(response) {
    var pc4uDropdownFieldName = "pc4uDropdown";

    // Decode Calling Form Code - Dropdown List  Field
    if (pc4uCallingFormCode == "pc4uWooBilling") {
        pc4uDropdownFieldName = "pc4uWooBillingDropdown"

    } else {
        if (pc4uCallingFormCode == "pc4uWooShipping") {
            pc4uDropdownFieldName = "pc4uWooShippingDropdown"
        }
    }

    //Test for an error
    if (response != null && response['Error'] != null) {
        //Show the error message
        alert("Postcode4u Lookup Error: "+response['Error'].Cause);
    }
    else {
      var addresslist = response["Summaries"];
        //Check if there were any items found
        if (addresslist.length == 0) {
            alert("Sorry, no matching items found for postcode");
        } else {
           
            try{ 
                var dropdown = document.getElementById(pc4uDropdownFieldName);

                dropdown.style.display = '';
                dropdown.options.length = 0;
                dropdown.options.add(new Option("Select an address:", ""));
                for (var j = 0; j < addresslist.length; j++) {
                    dropdown.options.add(new Option(addresslist[j].StreetAddress + ", " + addresslist[j].Place, addresslist[j].Id));
                }
                
            }
            catch (e) {
                //Ignore
                //alert("SearchEnd Dropdown Error:"+ e.message);
            }
        }
    }
    // Clear Calling Form Details
    pc4uCallingFormCode = "";
}


// ==================================================
// Postcode4u Lookup Common 'Select Address Process'
//  Return Selected Address Details
// ==================================================
function Pc4uSearchIdBegin(lookupcode) {
    var pc4uDropdownFieldName = "pc4uDropdown";
    pc4uLookupFormCode = lookupcode;

    if (pc4uLookupFormCode == "pc4uWooBilling") {
        pc4uDropdownFieldName = "pc4uWooBillingDropdown";
    } else {
        if (pc4uLookupFormCode == "pc4uWooShipping") {
            pc4uDropdownFieldName = "pc4uWooShippingDropdown";
        }
    }
    
    var scriptTag = document.getElementById("postcodes4youelelement");
    var headTag = document.getElementsByTagName("head").item(0);
    var strUrl = "";
    var Id = document.getElementById(pc4uDropdownFieldName).value;
    var key = document.getElementById("postcodes4ukey").innerHTML;
    var user = document.getElementById("postcodes4uuser").innerHTML;

    //Build the url
    //  Check if HTTPS
    if (window.location.protocol == "'https:") {
        strUrl = "https://services.3xsoftware.co.uk";
    } else {
        strUrl = "http://services.3xsoftware.co.uk";
    }
    strUrl += "/search/byid/json?";
    strUrl += "username=" + encodeURI(user);
    strUrl += "&key=" + encodeURI(key);
    strUrl += "&id=" + encodeURI(Id);

    strUrl += "&callback=Pc4uSearchIdEnd";
    //Make the request
    if (scriptTag) {
        try {
            headTag.removeChild(scriptTag);
        }
        catch (e) {
            //Ignore
            //alert("SearchIdBegin Error:" + e.message);
        }
    }
    scriptTag = document.createElement("script");
    scriptTag.src = strUrl;
    scriptTag.type = "text/javascript";
    scriptTag.id = "postcodes4youelelement";
    headTag.appendChild(scriptTag);
}

// ====================================================================
// Postcode4u Lookup 'Single Address Select Return 'Callback' Function
//  Populate Relavant Address Form with Returned Details
// ====================================================================
function Pc4uSearchIdEnd(response) {
    
    //Test for an error
    if (response != null && response['Error'] != null) {
        //Show the error message
        alert("Postcode4u Lookup Error: " + response['Error'].Cause);
    }
    else {
        //Check if there were any items found
        if (response.length == 0) {
            alert("Sorry, no matching postcode items found");
        }
        else {
            // Decode Address
            var address = response["Address"];

            // Decode Calling Form Code - Dropdown List  Field
            if (pc4uLookupFormCode == "pc4uWooBilling") {
                // Woo Commerce Billing Form
                document.getElementById("billing_company").value = address.Company;
                document.getElementById("billing_address_1").value = address.Line1;
                document.getElementById("billing_address_2").value = address.Line2;
                document.getElementById("billing_city").value = address.PostTown;
                document.getElementById("billing_state").value = address.County;
                document.getElementById("billing_postcode").value = address.Postcode;
                document.getElementById("billing_country").value = "GB";
             
                var lookupDropdown = document.getElementById("pc4uWooBillingDropdown");

                lookupDropdown.style.display = 'none';
                lookupDropdown.options.length = 0;

            } else {
                if (pc4uLookupFormCode == "pc4uWooShipping") {
                    // Woo Commerce Shipping Form
                    document.getElementById("shipping_company").value = address.Company;
                    document.getElementById("shipping_address_1").value = address.Line1;
                    document.getElementById("shipping_address_2").value = address.Line2;
                    document.getElementById("shipping_city").value = address.PostTown;
                    document.getElementById("shipping_state").value = address.County;
                    document.getElementById("shipping_postcode").value = address.Postcode;
                    document.getElementById("shipping_country").value = "GB";
                                    
                    var lookupDropdown = document.getElementById("pc4uWooShippingDropdown");

                    lookupDropdown.style.display = 'none';
                    lookupDropdown.options.length = 0;
                } else {
                    // Default Form (3x)

                    document.getElementById("pc4uCompany").value = address.Company;
                    document.getElementById("pc4uAddress1").value = address.Line1;
                    document.getElementById("pc4uAddress2").value = address.Line2;
                    document.getElementById("pc4uTown").value = address.PostTown;
                    document.getElementById("pc4uCounty").value = address.County;
                    document.getElementById("pc4uPostcode").value = address.Postcode;

                    var dropdown = document.getElementById("pc4uDropdown");

                    dropdown.style.display = 'none';
                    dropdown.options.length = 0;
                }
            }
        }
    }
}


