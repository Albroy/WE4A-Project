<div class="blurring">

</div>

<form class="login" action="./index.php" method="post">
  <fieldset>
  <legend>Connexion</legend>
   
      <label for="username">Nom d'utilisateur :</label>
      <input id="username" type="text" placeholder="Username" required>
      <label for="password">Mot de passe :</label>
      <input id="password" type="password" placeholder="Password" required>
  </fieldset>
    <button type="submit">Se connecter</button>

   <a href="./Signup.php"> <button type="button">Créer un compte</button> </a>
   <?php var_dump($_SESSION['user']);
   ?>
</form>

