<?php 

require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Check if the login form was submitted
    if (isset($_POST['signIn'])) {
        // Validate email and password fields
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // Hash the password using md5
            $password = md5($password);
            
            // SQL query to check if the user exists
            $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                session_start();
                $row = $result->fetch_assoc();
                
                // Save user data in session
                $_SESSION['email'] = $row['email'];
                header("Location: home.php");
                exit();
            } else {
                echo "Not Found, Incorrect Email or Password";
            }
        } else {
            echo "Please fill in both email and password.";
        }
    }

    // Check if the registration form was submitted
    if (isset($_POST['signUp'])) {
        // Handle user registration logic here
        $firstName = $_POST['fName'];
        $lastName = $_POST['lName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password);

        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkEmail);
        
        if ($result->num_rows > 0) {
            echo "Email Address Already Exists!";
        } else {
            $insertQuery = "INSERT INTO users(firstName, lastName, email, password)
                            VALUES ('$firstName', '$lastName', '$email', '$password')";
            if ($conn->query($insertQuery) === TRUE) {
                header("location: index.php");
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}
?>
