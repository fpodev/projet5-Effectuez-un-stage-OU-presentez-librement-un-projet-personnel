/*
Author: fpodev (fpodev@gmx.fr)
Effect.js (c) 2020
Desc: Gestion de divers dynamique des pages.
Created:  2020-05-13T15:42:37.533Z
Modified: !date!
*/

class Effect{
    constructor(){        
        this.add = document.getElementById("add");        
        this.ajout = document.getElementById("ajout");  
        this.actifBlock = document.getElementById("actifBlock");  
        this.formAjout = document.getElementById("formAjout");  
        this.formModification = document.getElementById("formModif");
        this.form_nom = document.getElementById("form_nom");   
        this.erreur = document.getElementById('erreur'); 
        this.responsive();
        this.formAdd(); 
        this.formModif();                    
      }
    responsive(){
        var x = document.getElementById("myTopnav"); 
      document.getElementById("burger").addEventListener("click", function(){        
       
  if (x.className === "nav") {
    x.className += " responsive";
  } else {
    x.className = "nav";
  } 
    }.bind(this));
  }
  //formulaire ajout/modif des actifs et affichage d'entrée de valeurs
    formAdd(){
       this.add.addEventListener("click", function(){  
           if(this.ajout.style.display = "none"){                    
              this.ajout.style.display = "block";
              this.actifBlock.style.display ="none" ;
              this.verifAjout();            
           }          
        }.bind(this));
    };
    formModif(){
      let form_nom = document.getElementById('form_nom').value;         
       if(form_nom != false){         
        this.ajout.style.display = "block";
        this.actifBlock.style.display ="none"
        this.verifModif();
       }
    }
    verifAjout(){         
      this.formAjout.onsubmit = function(){        
        if(this.form_nom.value == "" || this.erreur == true){
          alert("Vous devez remplir le champs");
          return false;
        }
         return true;                
      };
     }
     verifModif(){         
      this.formModification.onsubmit = function(){        
        if(this.form_nom.value == "" || this.erreur == true){
          alert("Vous devez remplir le champs");
          return false;
        }
         return true;                
      };
     } 
  //fin formulaire  
}