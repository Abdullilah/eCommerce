<?php 
    ob_start();
    session_start();
    $noNavBar = '';
    $pageTitle = 'Login';
    include "init.php";
    ?>
    <html>
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" href="layout/css/bootstrap.css"/>
            <link rel="stylesheet" href="layout/css/font-awesome.min.css"/>
            <link rel="stylesheet" href="layout/css/jquery-ui.css"/>
            <link rel="stylesheet" href="layout/css/jquery.selectBoxIt.css"/>
            <link rel="stylesheet" href="layout/css/backend.css"/>
            <title><?php getTitle();?></title>
        </head>
        <body>
    <?php
    if(isset($_SESSION['Username'])){
        header('location: dashbord.php');
    }

    // Check if the user is aomming from http POST request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);
        
        // Check if the user exist in the database
        $stmt = $con->prepare("SELECT UserID, Username, Password FROM users WHERE Username=? AND Password=? AND GroupID=1 LIMIT 1");
        $stmt-> execute(array($username,$hashedPass)); // ? -> $username, ? -> $hashedPass
        $row = $stmt-> fetch();
        $count = $stmt->rowCount();
        // If count > 0, this mean the user is in the database
        if($count>0){
            $_SESSION['Username'] = $username;
            $_SESSION['ID'] = $row[UserID];
            header('location: dashbord.php');
            exit();
        }
    }
?>
    
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <h3 class="text-center">Admin Login</h3>
        <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off"/>
        <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password"/>
        <input class="btn btn-primary btn-block" type="submit" value="Login" />
    </form>
    <div class="footer">
    </div>
        <script src="layout/js/jquery-1.12.4.min.js"></script>
        <script src="layout/js/jquery-ui.min.js"></script>
        <script src="layout/js/bootstrap.min.js"></script>
        <script src="layout/js/jquery.selectBoxIt.min.js"></script>
        <script src="layout/js/backend.js"></script>
    </body>
</html>
<?php 
    ob_end_flush();
?>