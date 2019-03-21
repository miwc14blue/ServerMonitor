<script src="../js/js-makeUserForm.js"></script>
<DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Nieuwe gebruiker</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="stylesheet" type="text/css" href="../css/styles-makeUserForm.css">
    </head>

    <body>

        <nav id="navHeader">
            <img class="logo" src="../img/logo.png">
            <a href="systeemOverzichtAdm.php">Systeem Overzicht</a>
            <a class="active" href="../userListOverview.php">Gebruikers</a>
            <a class="uitloggen" href="../logout.php">Uitloggen</a>
        </nav>

        <div class='form-container'>
          <h1>Nieuwe gebruiker aanmaken</h1>

        <form method="POST" action="../API/createUser.php">
            <div>
                <p>
                    <label>Gebruikersnaam</label>
                    <input name='userName' type="text" />
                </p>
                <p>
                    <label>Emailadres</label>
                    <input name='email' type="text" />
                </p>
                <p>
                    <label>Voornaam</label>
                    <input name='firstName' type="text" />
                </p>
                <p>
                    <label>Achternaam</label>
                    <input name='lastName' type="text" />
                </p>
                <br>
                <p>
                    <label>Wachtwoord</label>
                    <input name='password1' type="text" />
                </p>
                <p>
                    <label>Herhaal wachtwoord</label>
                    <input name='password2' type="text" />
                </p>
            </div>
            <div class="buttonsFromForm">

            <!-- <div class="dropdown">
                <button onclick="showContent()" class="dropbtn">Dropdown</button>
                <div id="myDropdown" class="dropdown-content">
                    <a href="#">User</a>
                    <a href="#">Admin</a>
                </div>
            </div> -->
            <div class="radioButton"><input name='role' type="radio" value="admin" /> Administrator </div>
            <div class="radioButton"><input name='role' type="radio" value="user" /> User </div>
                <div>
                    <input type="submit" value="Maak gebruiker aan" id="submitButton" />
                    <button type="reset" value="Reset" id="resetButton">Reset</button>
                </div>
            </div>
        </form>
        <button id="cancelbutton" onclick="location.href=`../userListOverview.php`"> Annuleren</button>

    </body>

    </html>
</DOCTYPE>
