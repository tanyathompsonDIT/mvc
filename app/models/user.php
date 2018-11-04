<?php
class User
{
    public $name;
    public $id;
    public $isLoggedIn;
    public $isConnected = false;
    public $pdo = null;
    public $errorMessage;

    public function __construct()
    {
        // for future use        
    }

    // Connect to the database
    protected function DBConnect()
    {
        // Load the script that will create a PDO Connection to the database
        require_once '../app/database.php';
        if (isset($pdo) && $pdo != null)
        {
            $this->pdo = $pdo;
            $this->isConnected = true;
            $this->errorMessage = $pdoMessage;
        }
    }

    // Login user, if matching user credentials are found
    public function loginUser($email, $password)
    {
        // Connect to the database
        $this->DBConnect();
        // If not connected get any error messages obtained
        if (!$this->isConnected)
        {
            $this->errorMessage = $pdoMessage;
            return false;
        }
        // prepare sql statement to get the details any user found with the email submitted
        try
        {
            $sql = 'SELECT id, firstname, email, password 
                    FROM tbluser 
                    WHERE email = :email LIMIT 1';
            $s = $this->pdo->prepare($sql);
            $s->bindParam(':email', $email);    
            $s->execute();
        }
        catch(PDOException $e)
        {
            // Return any error messages obtained on trying to get the user details
            $this->errorMessage = 'Unexpected error trigger on fetching your user details: ' . $e->getMessage();
            return false;
        }

        // Provide an error message if the email isn't found
        if ($s->rowCount() != 1)
        {
            $this->errorMessage = 'Invalid user credentials. Please try again.';
            return false;
        }
        
        // Get the user details found
        $row = $s->fetch();
        // Check to see if the submitted password matches the hashed value stored
        if (password_verify($password, $row['password'])) 
        {
            // Update the User model if the user credentials match
            $this->id = $row['id'];
            $this->name = $row['firstname'];
            $this->errorMessage = 'Successful login';
            return true;
        }
        else
        {
            // Provide an error message if the user credentials do not match
            $this->errorMessage = 'Invalid user credentials.';
            return false;
        }
    }

}

