/*
Author: fpodev (fpodev@gmx.fr)
TravauxListe.js (c) 2020
Desc: utilisation API pour les utilisateurs de niveau 2(technicien)
Created:  2020-04-26T15:11:26.536Z
Modified: !date!
*/
class TravauxListe{
    constructor(urlGet, urlPost){
        this.urlPost = urlPost;
        this.urlGet = urlGet; 
        this.retour = document.getElementById("retour");                                    
        this.listeTravaux(); 
        this.return();               
    }
listeTravaux(){    
    ajaxGet(this.urlGet, function(response){        
        let data = JSON.parse(response);         
        let travaux = data['travaux'];                   
        travaux.forEach(function(value){  
        //construction du tableau et entrées des valeurs retournées par l'API         
           let row = tableau.insertRow(0);
           let idElt = row.insertCell(0);
           idElt.textContent = value.id;
           let descriptionElt = row.insertCell(1);
           descriptionElt.textContent = value.descriptions;
           let urgenceElt = row.insertCell(2);
           urgenceElt.textContent = value.urgence;
           let nomElt = row.insertCell(3);
           nomElt.textContent = value.materiel;
           let date_demandeElt = row.insertCell(4);
           date_demandeElt.textContent = value.date_prevu;
            let linkElt = row.insertCell(5);           
            let link2 = document.createElement("i") ;                                   
            link2.className = "fas fa-eye fa-2x";
            let form = document.createElement("form");                                                                     
            let id = document.createElement("input");
            id.className = "masque";
            id.type = "hidden";
            id.value = value.id;                          
            let link = document.createElement("button");
            link.type = "submit";                                                
            let separateur = document.createTextNode(' | ');  
            link2.addEventListener("click",function(){                         
                document.getElementById("description").textContent = value.descriptions;
                document.getElementById("detail").textContent = value.detail;
                document.getElementById("demandeur").textContent = value.email;
                document.getElementById("externe").textContent = value.externe;                         
                document.title = "Détail de la demande de travaux";
                document.getElementById("table").style.display ="none";
                document.getElementById("blocDetail").style.display ="block";                
                document.getElementById("test").appendChild(form);
                form.appendChild(this.retour);
            }.bind(this));
        /*Insére le bouton "start" dans le tableau pour démarrer les travaux au clic, envoie la date
        **a la Bdd par l'API puis change en bouton "stop".*/                                     
            if(value.date_debut != null){
                   id.name ='id_fin';
                   link.className = "btn btn-danger";  
                   link.textContent = "Stop";
                   form.addEventListener("submit", function(){                   
                    let fin = {
                                id_fin: form.elements.id_fin.value   
                              } 
                                                                                                                   
                    ajaxPost(this.urlPost, fin, function(response){                                    
                    let data = JSON.parse(response); 
                    let success = data['valeur']; 
                    alert(success);                             
                 });                 
                }.bind(this)); 
            }
            else{ 
                id.name ='id_debut';
                link.className = "btn btn-primary"; 
                link.textContent = "Start";                
                form.addEventListener("submit", function(){                                                    
                    let debut = {
                                    id_debut: form.elements.id_debut.value   
                                }                                 
                                                                                                                                                                                                                                                                                           
                    ajaxPost(this.urlPost, debut, function(response){                         
                    let data = JSON.parse(response); 
                    let success = data['valeur'];
                    alert(success);
                    });                                                   
             }.bind(this));             
            };               
            linkElt.appendChild(link2);            
            linkElt.appendChild(separateur)
            linkElt.appendChild(form);
            form.appendChild(id);
            form.appendChild(link);                              
         }.bind(this));        
}.bind(this));           
}   
return(){
    this.retour.addEventListener("click", function(){
       document.location.reload(true);                                                           
    });
}

}
