<?php

// Include the database connection file (assuming it's in "connect.php").
require_once("./connect.php");

class SignupConfig
{
    // Private class properties
    private $id;
    private $firstname;
    private $lastname;
    private $address;
    
    // Protected database connection property
    protected $dbCnx;

    // Public class property (with default value)
    public $start = 0;

    // Public class property
    public $rows_per_page = 4;

    // Constructor method
    public function __construct($id = 0, $firstname = "", $lastname = "", $address = "")
    {
        // Initialize class properties
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->address = $address;

        // Access global database connection variables
        global $DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS;

        // Create a new PDO database connection
        $this->dbCnx = new PDO($DB_TYPE . ":host=" . $DB_HOST . ";dbname=" . $DB_NAME, $DB_USER, $DB_PASS, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    }

    // Set the start property
    public function setStart($start)
    {
        $this->start = $start;
    }

    // Get the start property
    public function getStart()
    {
        return $this->start;
    }

    // Set the id property
    public function setId($id)
    {
        $this->id = $id;
    }

    // Get the id property
    public function getId()
    {
        return $this->id;
    }

    // Set the firstname property
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    // Get the firstname property
    public function getFirstname()
    {
        return $this->firstname;
    }

    // Set the lastname property
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    // Get the lastname property
    public function getLastname()
    {
        return $this->lastname;
    }

    // Set the address property
    public function setAddress($address)
    {
        $this->address = $address;
    }

    // Get the address property
    public function getAddress()
    {
        return $this->address;
    }

    // Insert data into the database
    public function insertData()
    {
        try {
            $stm = $this->dbCnx->prepare("INSERT INTO users(firstname, lastname, address) values(?,?,?)");
            $stm->execute([$this->firstname, $this->lastname, $this->address]);
            echo "<script>
            alert('Data successfully inserted'); document.location='index.php'
            </script>";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Pagination method
    public function page()
    {
        if (isset($_GET['page-nr'])) {
            $page = $_GET['page-nr'] - 1;
            $this->setStart($page * $this->rows_per_page);
        }
        try {
            $stm = $this->dbCnx->prepare("SELECT * FROM users");
            $stm->execute();

            // Fetch all the results
            $results = $stm->fetchAll(PDO::FETCH_ASSOC);
            $rowCount = $stm->rowCount();
            $pages = ceil($rowCount / $this->rows_per_page);

            // Return data including results, row count, and number of pages
            return array('results' => $results, 'rows' => $rowCount, 'pages' => $pages);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Fetch all records based on pagination
    public function fetchAll()
    {
        try {
            $stm = $this->dbCnx->prepare("SELECT * FROM users LIMIT $this->start, $this->rows_per_page");
            $stm->execute();
            return $stm->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Fetch a single record by ID
    public function fetchOne()
    {
        try {
            $stm = $this->dbCnx->prepare("SELECT * FROM users where id=?");
            $stm->execute([$this->id]);
            return $stm->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Update a record
    public function update()
    {
        try {
            $stm = $this->dbCnx->prepare("UPDATE users SET firstname=?, lastname=?, address=? WHERE id=?");
            $stm->execute([$this->firstname, $this->lastname, $this->address, $this->id]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Delete a record
    public function delete()
    {
        try {
            $stm = $this->dbCnx->prepare("DELETE FROM users WHERE id=?");
            $stm->execute([$this->id]);
            echo "<script>
            alert('Data successfully deleted'); document.location='index.php'
            </script>";
            return $stm->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function search($key)
    {
        // Check if $key is set and not empty
        if (isset($key) && !empty($key)) {
            try {
                $stm = $this->dbCnx->prepare("SELECT * FROM users WHERE firstname LIKE :keyword OR lastname LIKE :keyword ORDER BY firstname");
                $stm->bindValue(':keyword', '%' . $key . '%', PDO::PARAM_STR);
                $stm->execute();

                // Fetch all the results
                $results = $stm->fetchAll(PDO::FETCH_ASSOC);
                $rowCount = $stm->rowCount();

                // Return both the results and the row count in an array
                return array('results' => $results, 'rows' => $rowCount);
            } catch (PDOException $e) {
                // Handle the exception or log the error here
                echo "Error: " . $e->getMessage();
                return null; // Return null or handle the error gracefully as needed
            }
        } else {
            // Handle the case when $key is not set or empty
            echo "Search keyword is not provided.";
            return null; // Return null or handle the case gracefully as needed
        }
    }
}
