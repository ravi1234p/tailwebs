<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- Include external CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    
    <!-- Include JS Libraries -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}

        .input-container {
            display: flex;
            width: 100%;
            margin-bottom: 15px;
        }

        .icon {
            padding: 10px;
            background: dodgerblue;
            color: white;
            min-width: 50px;
            text-align: center;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            outline: none;
        }

        .input-field:focus {
            border: 2px solid dodgerblue;
        }

        .btn {
            background-color: dodgerblue;
            color: white;
            padding: 15px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }


        .btn:hover {
            opacity: 1;
        }
    </style>
</head>
<body>

<div class="container">
<div class="container">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); // Clear the success message after displaying ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign in to continue</h1>
            <div class="account-wall">
                <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120" alt="">

                <!-- Login Form -->
                <form id="loginForm" class="form-signin" method="post" action="login_action.php">
                Email
                <div class="input-container">
                        
                        <i class="fa fa-user icon"></i>
                        <input type="text" id="email" class="input-field form-control" placeholder="Email" name="email" required>
                    </div>
                Password
                    <div class="input-container">
                        <i class="fa fa-lock icon"></i>
                        <input type="password" id="password" class="input-field form-control" placeholder="Password" name="password" required>
                    </div>

                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                    <div id="errorMessage" style="color: red; display: none;"></div>
                    <!-- <label class="checkbox pull-left">
                        <input type="checkbox" value="remember-me"> Remember me
                    </label> -->
                    <!-- <a href="#" class="pull-right need-help">Need help?</a>
                    <span class="clearfix"></span> -->
                </form>
            </div>
            <a href="#" class="text-center new-account">Create an account</a>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="row" id="registerForm" style="display:none;">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h2 class="text-center login-title">Register</h2>
            <form id="registrationForm" method="post" action="register_action.php">
          

            <div class="input-container">
                    <i class="fa fa-user icon"></i>
                    <input class="input-field" type="text" placeholder="name" name="name">
                </div>
                <div class="input-container">
                    <i class="fa fa-user icon"></i>
                    <input class="input-field" type="text" placeholder="Username" name="usrnm">
                </div>

                <div class="input-container">
                    <i class="fa fa-envelope icon"></i>
                    <input class="input-field" type="text" placeholder="Email" name="email">
                </div>

                <div class="input-container">
                    <i class="fa fa-key icon"></i>
                    <input class="input-field" type="password" placeholder="Password" name="psw">
                </div>

                <button type="submit" class="btn">Register</button>
            </form>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php echo $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>


<!-- Client-side Validation Script -->
<script>
    // Show the Register Form when "Create an account" link is clicked
    document.querySelector('.new-account').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('registerForm').style.display = 'block';
        document.getElementById('loginForm').style.display = 'none';
    });

    document.getElementById('loginForm').addEventListener('submit', function (event) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorMessage = document.getElementById('errorMessage');

        errorMessage.style.display = 'none'; // Hide error message by default

        // Email validation
        if (!validateEmail(email)) {
            event.preventDefault(); // Prevent form submission
            errorMessage.textContent = 'Please enter a valid email address';
            errorMessage.style.display = 'block';
        } 
        // Password validation
        else if (password.trim() === '') {
            event.preventDefault(); // Prevent form submission
            errorMessage.textContent = 'Password cannot be empty';
            errorMessage.style.display = 'block';
        }
    });

    // Email validation function
    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(email);
    }
</script>

</body>
</html>
