<html>

<head>
    <title>Login Page</title>
    <link rel='stylesheet' href='css/styles.css' />
    <link rel='stylesheet' href='css/styles-login.css' />
</head>

<body>
    <div id="login">
        <h1 id="boxheader">Server Monitor</h1>
        <form action="" method="POST">
            <span class="error" id="combiErr"><?php echo $_SESSION['combiErr']; ?></span>
            <span class="error"><?php echo $_SESSION['nameErr']; ?></span>
            <label>Gebruikersnaam: <input type="text" name="username" class="field" value="<?php echo $_SESSION['postUsername']; ?>" /></label>
            <span class="error"><?php echo $_SESSION['passErr']; ?></span>
            <label>Wachtwoord: <input type="password" name="password" class="field" value="" /></label>
            <input id="button" type="submit" value="Inloggen" />
        </form>
    </div>
</body>

</html>
