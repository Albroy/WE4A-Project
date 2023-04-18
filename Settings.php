<?php include("./Parties/head.php") ?>
<?php include("./Parties/Classes.php")?>
<?php include("./Parties/header.php"); ?>
<body>
<?php

$cook = new Cookie();

if(!$cook->CheckIntegrity()){
    header("Location: ./Index.php?PBINTEG");
    $cook->clean();
}else{
    
// Vérification si l'utilisateur est authentifié
if ($cook->IssetCookie()) {
    $authenticated = true;

    // Connexion à la base de données
    $conn = new SQLconn();
    
    // Récupération des données utilisateur à partir de la base de données
    $user_data = $conn->getUserData($cook->getUsername());
    $user_id = $user_data['user_id'];


    if (isset($_POST['ChangePassword'])){
 
        $OLDPASSWORD=htmlentities($_POST["oldpassword"]);
        $PASSWORD1=htmlentities($_POST["password1"]);
        $PASSWORD2=htmlentities($_POST["password2"]);

        $conn = new SQLconn();
        if($conn->CheckDB($cook->getUsername(), $OLDPASSWORD)){

            
            if($PASSWORD1==$PASSWORD2){
        
                
            
                $hash= EncryptedPassword($PASSWORD1);
                $conn->updatePassword($cook->getUsername(),$hash);
                $cook->UpdatePassword(EncryptedPassword($cook->getUsername()));
                
                
            }else{
                
                echo "mauvais mots de passe";
        
            }

            }else{
                echo "Ancien mot de passe incorrect!";
            }

    
    }

} else {
    $authenticated = false;
    header("Location: ./index.php");
    exit();
}
}


//var_dump(isset($_POST['ChangePassword']));


?>
    
<div class="center">
  <div class="settings">
  <h1>Paramètres</h1>
    <form method="post" class="set1" enctype="multipart/form-data" action="redirect.php" >
      <label for="user_email">Adresse email :</label>
      <input type="email" id="user_email" name="user_email" value="<?php echo !empty($user_data['user_email']) ? $user_data['user_email'] : ''; ?>" placeholder="<?php echo empty($user_data['user_email']) ? 'Non renseigné' : ''; ?>" required>
      
      <label for="user_pseudo">Pseudo :</label>
      <input type="text" id="user_pseudo" name="user_pseudo" value="<?php echo $user_data['user_pseudo']; ?>" disabled>
      
      <label for="user_name">Prénom :</label>
      <input type="text" id="user_name" name="user_name" value="<?php echo isset($user_data['user_name']) ? $user_data['user_name'] : ''; ?>"  placeholder="Entrez votre prénom">
      
      <label for="user_surname">Nom :</label>
      <input type="text" id="user_surname" name="user_surname" value="<?php echo isset($user_data['user_surname']) ? $user_data['user_surname'] : ''; ?>"  placeholder="Entrez votre nom de famille">
            
      <label for="user_desc">Descrition :</label>
      <input type="text" id="user_desc" name="user_desc" value="<?php echo isset($user_data['user_desc']) ? $user_data['user_desc'] : ''; ?>"  placeholder="Entrez votre Description">
            
      <fieldset>
        <legend>Profil</legend>
        <div class="img-upload">
            <label id="imgUpload">
                <input accept="image/*" type='file' id="imgInp" name="new_pp" />
            </label>
            <div class="img-container">
            <img id="blah" src="<?php echo (isset($user_data['user_pp']) && !empty($user_data['user_pp'])) ? $user_data['user_pp'] : './IMG/profilepic1.png'; ?>" alt="your image" />
            </div>
            <button class="btn button full" type="submit" name="save">Sauvegarder</button>
        </fieldset>
        // On envoie le path pour pouvoir revenir à la page d'origine
        <input type="hidden" name="path" value="<?php echo basename(__FILE__); ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="user_pp" value="<?php echo $user_data['user_pp']; ?>">
    
    </form>


    <form method="post" enctype="multipart/form-data" >
            <fieldset>
                <legend>Changer de Mot de passe</legend>
                <label for="oldpassword">Ancien mot de passe :
                    <input id="oldpassword" type="password" placeholder="Password" name="oldpassword" required>
                </label>
                <label for="password1">Nouveau Mot de passe :
                    <input id="password1" type="password" placeholder="Password" name="password2" required>
                </label>
                <label for="password2">Nouveau Mot de passe :
                    <input id="password2" type="password" placeholder="Password" name="password1" required>
                </label>
            </fieldset>
            <button type="submit" name="ChangePassword">Modifier</button>
        </form>
    </div>
</div>


<?php include("./Parties/footer.php"); ?>


<script src="./scripts.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        applyStyles(false);
      });
    </script>
</body>
</html>