<?php
session_start();

if(!isset($_SESSION['username']) || !($_SESSION['role']=='admin')){
   header("Location:../login.php");
}
?>

<!DOCTYPE html>

    <html>

    <head>
        <meta charset="utf-8">
        <title>Gebruiker bewerken</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="stylesheet" type="text/css" href="../css/styles-updateUserForm.css">
    </head>

    <body>
      <?php
          require_once('menu.php');
      ?>

        <div class="form-container">
          <h1>Gebruiker bewerken</h1>

          <form method="POST" action="../API/createUser.php">
              <div id="fields">
                  <p>
                      <label>Gebruikersnaam
                          <input name='userName' type="text" class="input"/>
                      </label>
                  </p>

                  <div id="containerLinks">
                      <p class="next">
                          <label>Wachtwoord
                              <input name='password1' type="text" class="input"/>
                          </label>
                      </p>
                      <p>
                          <label>Voornaam
                              <input name='firstName' type="text" class="input1"/>
                          </label>
                      </p>
                      <p>
                          <label>Rol
                              <input list="rol" name="Rol" class="input"/>
                              <datalist id="rol">
                                  <option value="User">
                                  <option value="Administrator">
                              </datalist>
                          </label>
                      </p>
                  </div>

                  <div id="containerRechts">
                      <p id="rechts" >
                          <label>Achternaam
                              <input class="rechts" name='lastName' type="text" class="input1"/>
                          </label>
                      </p>
                      <p id="rechts" class="next">
                          <label>Herhaal wachtwoord
                              <input name='password2' type="text" class="input"/>
                          </label>
                      </p>
                      <p id="rechts" class="next">
                          <label>Email-adres
                              <input name='email' type="text" class="input"/>
                          </label>
                      </p>
                  </div>
              </div>

              <div id="buttons">
                  <button id="cancelbutton" class="buttons" onclick="location.href=`userListOverview.php`"> Annuleren</button>
                  <input type="submit" value="Gebruiker verwijderen" class="buttons" id="buttenGVerwijderen" />

                  <input type="submit" value="Gebruiker opslaan" class="buttons" id="buttenGOpslaan" />
              </div>
          </form>
        </div>
    </body>

    </html>
