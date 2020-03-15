<?php
$titre = 'Ajout utilisateur';
require ('Librairies/Templates/head.php');

?>
<body id="CreatePage">        
 <p>page de connexion</p>
    <div class='Create'>
        <form action="index.php?login" method="post">
            <p>
                <label for="Nom">Nom:</label></br>
                <input type="text" name='Nom'/></br>

                <label for="Prenom">Prenom:</label></br>
                <input type="text" name='Prenom'/></br>

                <label for="Email">Email:</label></br>
                <input type="email" name='Email'/></br>

                <label for="lieu">Lieu:</label></br>
                <input type="text" name='Nom'/></br>

                <label for="Niveau">Niveau:</label></br>
                <input type="radio" name='niveau'value='admin'/>admin
                <input type="radio" name='niveau'value='1'/>1
                <input type="radio" name='niveau'value='2'/>2
                <input type="radio" name='niveau'value='3'/>3
                <input type="radio" name='niveau'value='4'/>4</br>
                <input type="submit" name="création" value="Valider" />         
            </p>
        </form>
    </div>          
</body>
</html> 