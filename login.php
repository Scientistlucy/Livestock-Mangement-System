<?php
session_start();
// Include database connection and Farmer class
include 'Farmer.php';
include('includes/connect.php');




// Create Farmer instance
$farmer = new Farmer($con);

// Handle form submission for login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $farmer->login($email, $password);
    if ($user) {
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid login credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f0f5f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .forms-container {
            position: relative;
        }

        .form-section {
            transition: all 0.3s ease;
        }

        .form-section.hidden {
            display: none;
        }

        h1 {
            color: #2f855a;
            margin-bottom: 30px;
            text-align: center;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #48bb78;
            z-index: 1;
            font-size: 16px;
            pointer-events: none;
        }

        .input-group label + .input-icon {
            top: calc(50% + 12px);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 500;
        }

        input, select {
            width: 100%;
            padding: 12px 12px 12px 35px;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #48bb78;
            outline: none;
            box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.2);
        }

        input:hover, select:hover {
            border-color: #48bb78;
        }

        .password-requirements {
            font-size: 12px;
            color: #718096;
            margin-top: 5px;
        }

        .terms-container {
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .terms-container input[type="checkbox"] {
            width: auto;
            padding: 0;
        }

        .terms-container label {
            margin: 0;
            cursor: pointer;
        }

        .terms-container a {
            color: #38a169;
            text-decoration: none;
        }

        button {
            background: #2f855a;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }

        button:hover {
            background: #38a169;
        }

        .switch-form {
            text-align: center;
            margin-top: 20px;
            color: #4a5568;
        }

        .switch-form a {
            color: #2f855a;
            text-decoration: none;
            font-weight: 500;
            margin-left: 5px;
        }

        .switch-form a:hover {
            text-decoration: underline;
        }

        .required {
            color: #e53e3e;
            margin-left: 3px;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #2f855a;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <!-- Login Form -->
            <div class="form-section" id="loginForm">
                <h1>Farmer Login</h1>
                <form method="POST" action="login.php">
                    <div class="input-group">
                        <label>Email Address<span class="required">*</span></label>
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" placeholder="Enter your email address" required>
                    </div>

                    <div class="input-group">
                        <label>Password<span class="required">*</span></label>
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <div class="forgot-password">
                        <a href="#">Forgot Password?</a>
                    </div>

                    <button type="submit" name="login">Login</button>
                    
                    <div class="switch-form">
                        Don't have an account? <a href="registration.php">Register here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>