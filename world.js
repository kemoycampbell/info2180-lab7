window.addEventListener("load", function() {
    "use strict";
    
    var doc = document; // cache global
    
    var country;
    
    var xhttp = new XMLHttpRequest();
    
    // DOM
    var countryField = doc.getElementById("country");
    var lookupBtn = doc.getElementById("lookup");
    var checkbox = doc.getElementById("checkbox");
    var result = doc.getElementById("result");
    
    lookupBtn.addEventListener("click", function() {
        country = countryField.value;
    
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                result.innerHTML = this.responseText;
            }
        };
    
        xhttp.open("GET", "https://info2180-lab7-macsual.c9users.io/world.php?country=" + country + "&all=" + checkbox.checked, true);
        xhttp.send();
    }, false);
    
}, false);
