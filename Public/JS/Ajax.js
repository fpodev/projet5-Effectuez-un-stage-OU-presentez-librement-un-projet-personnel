/*
Author: fpodev (fpodev@gmx.fr)
Ajax.js (c) 2020
Desc: description
Created:  2020-04-26T15:08:43.799Z
Modified: !date!
*/
function ajaxGet(url, callback) {
    var req = new XMLHttpRequest();
    req.open("GET", url);
    req.addEventListener("load", function () {
        if (req.status >= 200 && req.status < 400) {
            // Appelle la fonction callback en lui passant la réponse de la requête
            callback(req.responseText);
        } else {
            console.error(req.status + " " + req.statusText + " " + url);
        }
    });
    req.addEventListener("error", function () {
        console.error("Erreur réseau avec l'URL " + url);
    });
    req.send(null);    
}

function ajaxPost(url, data, callback) { 
    
    var req = new XMLHttpRequest();
    req.open("POST", url, false);
    req.addEventListener("load", function () {
        if (req.status >= 200 && req.status < 400) {
               // Appelle la fonction callback en lui passant la réponse de la requête
            callback(req.responseText);            
        } else {         
            console.error(req.status + " " + req.statusText + " " + url);
        }
    }); 
    req.addEventListener("error", function () {
        console.error("Erreur réseau avec l'URL " + url);
    });  
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        data = JSON.stringify(data);                 
        req.send(data);                          
      }
