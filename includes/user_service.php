<?php
    /**
      * Deze class wordt gebruikt voor het registreren en inloggen van een gebruiker
      * Pas de code aan naar eigen wens, voeg zelf extra functionaliteit toe!
      */

    class UserService
    {
        /**
         * @var string het username van de gebruiker
         * afschermen voor gebruik  buiten deze class
         */
        protected $username;

        /**
         * @var string het wachtwoord van de gebruiker
         * afschermen voor gebruik  buiten deze class
         */
        protected $password;

        /**
         * @var string het wachtwoord van de gebruiker
         * afschermen voor gebruik  buiten deze class
         */
        protected $passwordConfirm;
        
        /**
         * @var string het wachtwoord van de gebruiker
         * afschermen voor gebruik  buiten deze class
         */
        protected $errors;

        /**
         * @var string het database connectie object
         * afschermen voor gebruik  buiten deze class
         */
        protected $db;       // stores the database handler
        protected $user;     // stores the user data

        /**
         * @param object db
         * @param string username
         * @param string password
         * De constructor functie voor de initialisatie van het object
         */
        public function __construct(PDO $db, $userinfo)
        {
           $this->db = $db;
           $this->username = $userinfo['username'];
           $this->password = $userinfo['password'];
           if(isset($userinfo['passwordConfirm'])){$this->passwordConfirm = $userinfo['passwordConfirm'];}
           $this->errors = array();
        }

        /**
         * Deze functie controleert de inloggegevens
         * @return integer|boolean Deze functie retourneert het gebruiker id - of false indien er een fout optreed
         */
        protected function checkCredentials()
        {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ?');
            $stmt->execute(array($this->username));
            if ($stmt->rowCount() != 0){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if(password_verify($this->password, $result['password'])){
                return $result;
                } else {
                    $this->errors['password_err'] = "Wachtwoord is niet juist";
                    return false;
                }
            } else {
                $this->errors['username_err'] = "Gebruikersnaam niet gevonden";
                return false;
            }
        }

        /**
         * Deze functie probeert de gebruiker in te loggen
         * @return integer|boolean
         */
        public function login()
        {
            if(empty(trim($this->username))){
                $this->errors['username_err'] = "Vul aub een gebruikersnaam in";
            }
            if(empty(trim($this->password))){
                $this->errors['password_err'] = "Vul aub een wachtwoord in";
            }
            
            if(empty($this->errors)){ 
                $user = $this->checkCredentials();
            } else {
                $this->errors['username'] = $this->username;
                return $this->errors;
            }

            if ($user) {
                $this->user = $user; // store it so it can be accessed later
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['account_type'] = $user['type'];
                return $user['id'];
            } else {
                    $this->errors['username'] = $this->username;
                    return $this->errors;
            }

            return false;
        }

        /**
         * Deze functie registreert een nieuwe gebruiker
         * @return integer|boolean retourneer de nieuwe gebruiker id of retourneer false bij fout
         */
        public function registerNewUser()
        {
            if(empty(trim($this->username))){
                $this->errors['username_err'] = "Vul aub een gebruikersnaam in";
            }
            if(empty(trim($this->password))){
                $this->errors['password_err'] = "Vul aub een wachtwoord in";
            }
            if(empty(trim($this->passwordConfirm))){
                $this->errors['passwordConfirm_err'] = "Bevestig uw wachtwoord";
            }
            if(trim($this->password) !== trim($this->passwordConfirm)){
                $this->errors['passwordConfirm_err'] = "Uw wachtwoord komt niet overeen";
            }
            if(empty($this->errors)){
                $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ?');
                $stmt->execute(array($this->username));
                if ($stmt->rowCount() == 0){
                    $stmt = $this->db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
                    $stmt->execute(array($this->username, password_hash($this->password, PASSWORD_DEFAULT)));

                    return $this->db->lastInsertId();
                } else {
                    $this->errors['username_err'] = "Deze gebruikersnaam bestaat al";
                    $this->errors['username'] = $this->username;
                    return $this->errors;
                }
            } else {
                $this->errors['username'] = $this->username;
                return $this->errors;
            }
        }

        /**
         * @return string Deze functie geeft het usernameadres terug
         */
        public function getusernameAddress()
        {
            return $this->username;
        }
        
        public function logout()
        {
            // Unset all of the session variables
            $_SESSION = array();
 
            // Destroy the session.
            session_destroy();
            return true;
        }

        /**
         * @return string Deze functie stelt het usernameadres in
         */
        public function setusernameAddress($username)
        {
            $this->username = $username;
        }

        /**
         * @return string Deze functie reset het wachtwoord van de desbetreffende user
         */
        public function resetPassword()
        {
            // vul hier je eigen code in
        }
    }
?>
