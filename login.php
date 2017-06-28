<?php
    session_start();
    $pageTitle = 'Login';
    $errorsArray = array();
    $message = '';
    if(isset($_SESSION['NormalUser'])){
        header('location: index.php');
    }

    include "init.php";

    // Check if the user is aomming from http POST request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST["login"])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashedPass = sha1($password);

            // Check if the user exist in the database
            $stmt = $con->prepare("SELECT UserID, Username, Password FROM users WHERE Username=? AND Password=?");
            $stmt-> execute(array($username,$hashedPass)); // ? -> $username, ? -> $hashedPass
            $get = $stmt->fetch();
            $count = $stmt->rowCount();
            // If count > 0, this mean the user is in the database
            if($count>0){
                $_SESSION['NormalUser'] = $username;
                $_SESSION['uID'] = $get['UserID'];
                header('location: index.php');
                exit();
            }
        } else{
            // Valid Username
            if(isset($_POST["username"])){
                $filteredName = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
                if(strlen($filteredName) < 4){
                    $errorsArray[] = "Username Must be Longer Than 4";
                }
            }
            // Valid Password
            if(isset($_POST["password1"]) && isset($_POST["password2"])){
                if(empty($_POST["password1"])){
                    $errorsArray[] = "Password can\'t be empty";
                }
                $pass1 = sha1($_POST["password1"]);
                $pass2 = sha1($_POST["password2"]);
                if($pass1 !== $pass2){
                    $errorsArray[] = "Your Password is not match";
                }
            }
            // Vaild email
            if(isset($_POST["email"])){
                $filteredEamil = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
                if(filter_var($filteredEamil, FILTER_VALIDATE_EMAIL) != true){
                    $errorsArray[] = "This Email Is Not Valid";
                }
            }
            
            if(empty($errorsArray)){
                    // Insert into the database
                    $check = checkItem("Username", "users", $filteredName);
                    if($check == 1){
                        $message = "<div class='alert alert-danger'>This Username is already taken</div>";
                    } else{
                        $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, Fullname, RegStatus, Date) VALUES(:zuser, :zpass, :zmail, :zname, 0, now())");
                        $stmt->execute(array(
                            'zuser' => $filteredName,
                            'zpass' => $pass1,
                            'zmail' => $filteredEamil,
                            'zname' => $_POST["fullname"]
                        ));

                        // Print message
                        $message = "<div class='alert alert-success'>The process is done!</div>";
                    }
            }else{
                $message = 'Sorry ... You can\'t access this page in this way';
                redirecting('', $message, 6, 'index.php', 'danger');
            }
        }
        
    }
?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="layout/css/bootstrap.css"/>
        <link rel="stylesheet" href="layout/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="layout/css/jquery-ui.css"/>
        <link rel="stylesheet" href="soso.css"/>
        <title><?php getTitle();?></title>
    </head> 
    <body>
        <div class="container loginSignUp">
            <h1 class="text-center">
                <span class="login active1">Login</span> | <span class="signup">Signup</span>
            </h1>
            <!-- Start login form -->
            <form action="" method="POST" class="loginForm" action="<?php echo $_SERVER['PHP_SELF']?>">
                <div class="forms">
                    <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type your username" required>
                </div>
                <div class="forms">
                    <input class="form-control" type="password" name="password" 
                       autocomplete="new-password" placeholder="Type your password" required>
                </div>
                <input class="btn btn-block btn-primary" type="submit" value="Log in" name="login">
            </form>
            <!-- End login form -->
            <!-- Start signup form -->
            <form action="" method="POST" class="signupForm" action="<?php echo $_SERVER['PHP_SELF']?>">
                <!-- The min length should be 4 -->
                <div class="forms">
                    <input class="form-control" 
                           pattern=".{4,}"
                           title="Username should be nore than 4 charts"
                           type="text" 
                           name="username" 
                           autocomplete="off" 
                           placeholder="Type your username" 
                           required>
                </div>
                <div class="forms">
                    <input class="form-control" 
                           type="text" 
                           name="fullname" 
                           autocomplete="off" 
                           placeholder="Type your Full name" >
                </div>
                <div class="forms">
                    <input class="form-control" 
                           pattern=".{4,}"
                           title="Password should be nore than 4 charts"
                           type="password" 
                           name="password1" 
                           autocomplete="new-password" 
                           placeholder="Type your password" 
                           required>
                </div>
                <div class="forms">
                    <input class="form-control" 
                           pattern=".{4,}"
                           title="Password should be nore than 4 charts"
                           type="password" 
                           name="password2" 
                           autocomplete="new-password" 
                           placeholder="Repeat your password"
                           required>
                </div>
                <div class="forms">
                    <input class="form-control"
                           type="email" 
                           name="email" 
                           autocomplete="off" 
                           placeholder="Type your email" 
                           required>
                </div>
                <input class="btn btn-block btn-success" type="submit" value="Sign up" name="signup">
            </form>
            <!-- End signup form -->
        </div>
        <div class="error text-center">
            <div class="container">
                <?php
                    foreach($errorsArray as $error){
                        echo "<div class='alert alert-danger'>" . $error ."</div>";
                    }
                  echo $message;
                ?>
            </div>
        </div>
        <div class="footer">
        </div>
        <script src="layout/js/jquery-1.12.4.min.js"></script>
        <script src="layout/js/jquery-ui.min.js"></script>
        <script src="layout/js/bootstrap.min.js"></script>
        <script src="layout/js/frontend.js"></script>
    </body>
</html>