<?php
/*
Author: fpodev (fpodev@gmx.fr)
userView.php (c) 2020
Desc: Page de confirmation envoyé par mail à la création d'un nouvel utilisateur
Created:  2020-05-24T13:56:04.768Z
Modified: !date!
*/
?>
<!DOCTYPE html>
<html lang="Fr">
<head>
      <meta charset="UTF-8">      
</head>
<html>  
<body>
<?php
echo "<p>Bonjour " .$prenom. "</p></br>
      <p>Voici votre identifiant et votre mot de passe pour vous connecter à l'application GMAO.</p></br>
      <p>Identifiant:  ".$destinataire." </p></br>
      <p>Mot de passe: ".$pass." </p></br></br>
      <p>Nous vous rappellons qu'il est important de changer votre mot de passe réguliérement</p></b></br>
      <p>Cordialement.</p> </br>
      <p> Votre administrateur GMAO </p>"
?>
</body>
</html>