window.addEventListener("load", function() {
    "use strict";
    
    var doc = document; // cache global
    
    var country;
    
    var xhttp = new XMLHttpRequest();
    
    // DOM
    var countryField = doc.getElementById("country");
    var lookupBtn = doc.getElementById("lookup");
    var controls = doc.getElementById("controls");
    var result = doc.getElementById("result");
    var h1Ele = doc.getElementsByTagName("h1")[0];
    var labelEle = doc.getElementsByTagName("label")[0];
    var headEle = doc.getElementsByTagName("head")[0];
    var bodyEle = doc.getElementsByTagName("body")[0];
    
    var scriptEle;
    var linkEle;
    var divEle;
    
    linkEle = doc.createElement("link");
    linkEle.setAttribute("href", "https://fonts.googleapis.com/css?family=Roboto");
    linkEle.setAttribute("rel", "stylesheet");
    headEle.appendChild(linkEle);
    
    linkEle = doc.createElement("link");
    linkEle.setAttribute("href", "https://fonts.googleapis.com/icon?family=Material+Icons");
    linkEle.setAttribute("rel", "stylesheet");
    headEle.appendChild(linkEle);
    
    linkEle = doc.createElement("link");
    linkEle.setAttribute("href", "https://code.getmdl.io/1.2.1/material.indigo-pink.min.css");
    linkEle.setAttribute("rel", "stylesheet");
    headEle.appendChild(linkEle);
    
    scriptEle = doc.createElement("script");
    scriptEle.setAttribute("src", "https://code.getmdl.io/1.2.1/material.min.js");
    headEle.appendChild(scriptEle);
    
    controls.appendChild(labelEle);
    controls.appendChild(doc.createElement("br"));
    controls.appendChild(countryField);
    
    lookupBtn.style.marginLeft = "10px";
    
    controls.appendChild(lookupBtn);
    
    divEle = doc.createElement("div");
    divEle.style.margin = "auto";
    divEle.style.width = "50%";
    divEle.style.backgroundColor = "#E0E0E0";
    divEle.style.padding = "25px";
    divEle.style.marginTop = "25px";
    divEle.style.borderRadius = "10px";

    divEle.appendChild(h1Ele);
    divEle.appendChild(controls);
    divEle.appendChild(result);
    
    bodyEle.appendChild(divEle);
    
    lookupBtn.setAttribute("class", "mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent");
    
    lookupBtn.addEventListener("click", function() {
        country = countryField.value;
    
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                result.innerHTML = this.responseText;
                alert(this.responseText.substring(8, this.responseText.length - 10));
            }
        };
    
        xhttp.open("GET", "https://info2180-lab7-macsual.c9users.io/world.php?country=" + country, true);
        xhttp.send();
    }, false);
    
}, false);
