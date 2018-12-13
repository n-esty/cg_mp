<?php
    class AdService
    {

        protected $ad_id;
        protected $user_id;
        protected $title;
        protected $description;
        protected $askingPrice;
        protected $errors;

        /**
         * @var string het database connectie object
         * afschermen voor gebruik  buiten deze class
         */
        protected $db;       // stores the database handler
        protected $user;     // stores the user data

        public function __construct(PDO $db, $adinfo)
        {
           $this->db = $db;
           $this->user_id = $_SESSION['user_id'];
           if(isset($adinfo['title'])){$this->title = $adinfo['title'];}
           if(isset($adinfo['description'])){$this->description = $adinfo['description'];}
           if(isset($adinfo['askingPrice'])){$this->askingPrice = $adinfo['askingPrice'];}
           if(isset($_GET['ad'])){$this->ad_id = $_GET['ad'];}
           $this->errors = array();
        }

        /**
         * Deze functie controleert de inloggegevens
         * @return integer|boolean Deze functie retourneert het gebruiker id - of false indien er een fout optreed
         */
        public function showAd()
        {
            $stmt = $this->db->prepare('SELECT * FROM ads WHERE id = ?');
            $stmt->execute(array($this->ad_id));
            if ($stmt->rowCount() != 0){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            } else {
                $result = "Advertentie niet gevonden";
                return $result;
            }
        }        
        
        public function adList()
        {
            $order_col = "created_at";
            $order_dir = "DESC";
            if(isset($_GET['dir']) && ($_GET['dir'] == "ASC" || $_GET['dir'] == "DESC")){
                $order_dir = $_GET['dir'];
            }
            if(isset($_GET['by']) && ($_GET['by'] == "asking_price" || $_GET['by'] == "title" || $_GET['by'] == "description")){
                $order_col = $_GET['by'];
            }
            $where = "";
            if(isset($_GET['user']) && intval($_GET['user'])>0){
                $where = "WHERE user_id=" . $_GET['user'];
            }
            $stmt = $this->db->prepare("SELECT * FROM ads $where ORDER BY $order_col $order_dir");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $json = json_encode($result);
            foreach($result as $row){  
                
            }
            return $json;
        }

        /**
         * Deze functie registreert een nieuwe gebruiker
         * @return integer|boolean retourneer de nieuwe gebruiker id of retourneer false bij fout
         */
        public function submitNewAd()
        {
            if(empty(trim($this->title))){
                $this->errors['title_err'] = "Vul aub een titel in";
            }
            if(empty(trim($this->description))){
                $this->errors['description_err'] = "Vul aub een omschrijving in";
            }
            if(empty(trim($this->askingPrice))){
                $this->errors['askingPrice_err'] = "Vul aub een prijs in";
            }            
            if(floatval($this->askingPrice) < 0.01){
                $this->errors['askingPrice_err'] = "Vul aub een geldige prijs in, minimaal 0.01";
            }
            if(empty($this->errors)){
                    $stmt = $this->db->prepare('INSERT INTO ads (user_id, title, description, asking_price) VALUES (?, ?, ?, ?)');
                    $stmt->execute(array($this->user_id, $this->title, $this->description, $this->askingPrice));

                    return $this->db->lastInsertId();
            } else {
                $this->errors['title'] = $this->title;
                $this->errors['description'] = $this->description;
                $this->errors['askingPrice'] = $this->askingPrice;
                return $this->errors;
            }
        }
    }
?>
