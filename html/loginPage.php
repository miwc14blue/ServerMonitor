<html>

<head>
    <title>Login Page</title>
    <link rel='stylesheet' href='css/styles.css' />
    <link rel='stylesheet' href='css/styles-login.css' />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>
    <div id="login">
        <h1 id="boxheader">Server Monitor</h1>
        <form action="" method="POST">
            <span class="error" id="combiErr"><?php echo $_SESSION['combiErr']; ?></span>
            <label>Gebruikersnaam:
                <span class="error"><?php echo $_SESSION['nameErr']; ?></span>
                <input type="text" name="username" class="login-field" value="<?php echo $_SESSION['postUsername']; ?>" />
            </label>
            <label>Wachtwoord:
                <span class="error"><?php echo $_SESSION['passErr']; ?></span>
                <input type="password" name="password" class="login-field" value="" />
            </label>
            <input class="btn btn-inloggen" type="submit" value="Inloggen"/>
        </form>
    </div>
</body>

</html>
