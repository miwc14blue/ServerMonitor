<?php

class Validator
{

  public $userName, $email, $firstName, $lastName, $password1, $password2, $role;

  public $errors = Array(
      'userName' => Array(),
      'email' => Array(),
      'firstName' => Array(),
      'lastName' => Array(),
      'password1' => Array(),
      'password2' => Array(),
      'role' => Array()
  );

  public function __construct() {
  }

  public function validate(){

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        // Http request method must be 'POST'
        return false;
    }

    $this->userName = $this->sanitize($_POST['userName']);
    $this->email = $this->sanitize($_POST['email']);
    $this->firstName = $this->sanitize($_POST['firstName']);
    $this->lastName = $this->sanitize($_POST['lastName']);
    $this->password1 = $this->sanitize($_POST['password1']);
    $this->password2 = $this->sanitize($_POST['password2']);
    $this->role = $this->sanitize($_POST['role']);

    if(!$this->checkRequired()){
        return false;
    }

    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
        array_push($this->errors['email'], 'This is not a valid email address');
        return false;
    }

    if(!$this->checkLength($this->userName, 5)){
        array_push($this->errors['userName'], 'The username must contain at least 5 characters');
        return false;
    }

    // if(check db username exists){
    //     array_push($errors['userName'], 'This username already exists');
    // }

    if(!$this->checkLength($this->firstName, 2)){
        array_push($this->errors['firstName'], 'The first name must contain at least 2 characters');
        return false;
    }

    if(!$this->checkLength($this->lastName, 2)){
        array_push($this->errors['lastName'], 'The last name must contain at least 2 characters');
        return false;
    }

    if(!$this->checkPassword()){
        array_push($this->errors['password1'], 'The password must contain at least 8 characters of which 1 uppercase letter, 1 lowercase letter and 1 number');
        return false;
    }

    if($this->password1 != $this->password2){
        array_push($this->errors['password2'], 'The passwords do not match');
        return false;
    }

    return true;
  }

  private function checkLength($str, $len){
    return strlen($str) >= $len;
  }
  
  private function checkRequired(){
      return $this->checkFieldRequired($this->userName, 'userName')
      && $this->checkFieldRequired($this->email, 'email')
      && $this->checkFieldRequired($this->firstName, 'firstName')
      && $this->checkFieldRequired($this->lastName, 'lastName')
      && $this->checkFieldRequired($this->password1, 'password1')
      && $this->checkFieldRequired($this->password2, 'password2')
      && $this->checkFieldRequired($this->role, 'role');
  }
  
  private function checkFieldRequired($val, $field){
        $exists = isset($val);
        if(!$exists){
            array_push($errors[$field], 'This field is required');
        }
      return $exists;
  }
  
  private function checkPassword(){
      return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $this->password1);
    
  }
  
  private function checkRole(){
      return $this->role == 'admin' || $this->role == 'user' ;
  }

  private function sanitize($val) {
    $val = trim($val);
    $val = stripslashes($val);
    $val = htmlspecialchars($val);
    return $val;
  }
}

?>


        <h1>Nieuwe gebruiker aanmaken</h1>
<p><span class="error">* required field</span></p>
        <form method="POST" action="makeUserForm.php">
            <p>
                <label>
                    Gebruikersnaam
                    <input name='userName' type="text"  value="<?php echo $userName;?>" />
                    <span  class="error">* <?php echo $errors[$userNameErr];?></span>
                </label>
            </p>
            <p>
                <label>
                    Voornaam
                    <input name='firstName' type="text" value="<?php echo $firstName;?>"/>
                    <span class="error">* <?php echo $errors['firstName'];?></span>
                </label>
            </p>
            <p>
                <label>
                    Achternaam
                    <input name='lastName' type="text" value="<?php echo $lastName;?>" />
                    <span class="error">* <?php echo $lastNameErr;?></span>
                </label>
            </p>
            <p>
                <label>
                    Wachtwoord
                    <input name='password1' type="text" value="<?php echo $password1;?>"/>
                    <span class="error">* <?php echo $password1Err;?></span>
                </label>
            </p>
            <p>
                <label>
                    Herhaal wachtwoord
                    <input name='password2' type="text" value="<?php echo $password2;?>"/>
                    <span class="error">* <?php echo $password2Err;?></span>
                </label>
            </p>
            <label>
                <input name='role' type="radio" value="admin" /> Administrator
                <span class="error">* <?php echo $roleErr;?></span>
            </label>
            <label>
                <input name='role' type="radio" value="user" /> Gebruiker
                <span class="error">* <?php echo $roleErr;?></span>
            </label>
            <p>
                <input type="submit" value="Maak gebruiker aan" />
                <button type="reset" value="Reset">Reset</button>

            </p>
        </form>
        <button onclick="location.href=`userListOverview.php`">Annuleren</button>

    </body>

    </html>