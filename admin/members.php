<?php

    /*
    =====================================================
    == In this page you can Add | Delete | Edit members
    =====================================================
    */
    ob_start();

    session_start();
    $pageTitle = 'Members';
    if(isset($_SESSION['Username'])){
        include 'init.php';
        ?>
        <!DOCTYPE html>
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
        $do = '';
        if(isset($_GET['do'])){
            $do = $_GET['do'];
        } else{
            $do = 'Manage';
        }
        // Start Manage Section 
        if($do == 'Manage'){ 
            $query = '';
            if(isset($_GET['Page']) && $_GET['Page'] == 'Pending'){
                $query = 'AND RegStatus=0';
            }
            
            // Select all users except the Admin
            $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if($query == ''){
                echo '<h1 class="text-center">' . lang('Manage_Members')  . '</h1>';
            } else{
                echo '<h1 class="text-center">' . lang('Pending_Members')  . '</h1>';
            }
            
            if(!empty($rows)){
                ?>
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-bordered table-main text-center">
                                <tr>
                                    <td>#ID</td>
                                    <td><?php echo lang('Username'); ?></td>
                                    <td><?php echo lang('Email'); ?></td>
                                    <td><?php echo lang('Full_Name'); ?></td>
                                    <td><?php echo lang('Registration_Date'); ?></td>
                                    <td><?php echo lang('Control'); ?></td>
                                </tr>
                                <?php
                                    foreach($rows as $row){
                                        echo "<tr>";
                                            echo "<td>" . $row['UserID'] . "</td>";
                                            echo "<td>" . $row['Username'] . "</td>";
                                            echo "<td>" . $row['Email'] . "</td>";
                                            echo "<td>" . $row['Fullname'] . "</td>";
                                            echo "<td>" . $row['Date'] . "</td>";
                                            echo '<td>
                                                    <a href="members.php?do=Edit&userID=' .$row['UserID']. '"class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="members.php?do=Delete&userID=' .$row['UserID']. '"class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
                                                    if($row["RegStatus"] == 0){
                                                        echo '<a href="members.php?do=Activate&userID=' .$row['UserID']. '"class="btn btn-info active"><i class="fa fa-check"></i> Activate</a>';
                                                    }
                                                echo '</td>';
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </div>
                        <a href='members.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
                    </div>
                <?php
            } else{
                echo "<div class='container'>";
                        echo "<div class='alert alert-info'> There is no Members to Show </div>";
                        echo "<a href='members.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> New Member</a>";
                echo "</div>";
                
            }
        ?>
        <?php
        // Start Add Section 
        } elseif($do == 'Add'){
            ?>
            <h1 class="text-center">Add New Member</h1>
                <div class="container">
                    <form class="form-horizontal" action="members.php?do=Insert" method="POST">
                        <!-- Satrt Username -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Username" required="required"/>
                            </div>
                        </div>
                        <!-- Satrt Password -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="Password" required="required"/>
                                <i class="show-pass fa fa-eye fa-2x"></i>
                            </div>
                        </div>
                        <!-- Satrt Email -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="email" name="email" class="form-control" placeholder="Email" required="required"/>
                            </div>
                        </div>
                        <!-- Satrt Fullname -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="full" class="form-control" placeholder="Full Name" required="required"/>
                            </div>
                        </div>
                        <!-- Save -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add member" class="btn btn-primary btn-lg"/>
                            </div>
                        </div>
                    </form>
                </div>
            <?php
            
        // Start Insert Section 
        } elseif($do == 'Insert'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h1 class='text-center'>Add New Member</h1>";
                echo "<div class='container'>";
                // Take variables from the From
                $user   = $_POST['username'];
                $pass   = $_POST['password'];
                $email  = $_POST['email'];
                $name   = $_POST['full'];
                
                $shaPass = sha1($pass);
                
                // Check the input before modify the database
                $errorArray = array();
                if(empty($user))        { $errorArray[] = "Username can not be <b>empty</b>"; }
                if(empty($pass))        { $errorArray[] = "Password can not be <b>empty</b>"; }
                if(strlen($user)< 4)    { $errorArray[] = "Username should be <b>longer than 4</b>";}
                if(strlen($user)> 20)   { $errorArray[] = "Username should be <b>less than 20</b>";}
                if(empty($email))       { $errorArray[] = "Email can not be <b>empty</b>";}
                if(empty($name))        { $errorArray[] = "Full Name can not be <b>empty</b>";}
                
                foreach($errorArray as $error){
                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                }    
                
                if(empty($errorArray)){
                    // Insert into the database
                    $check = checkItem("Username", "users", $user);
                    if($check == 1){
                        $message = 'This Username is already taken';
                        redirecting('', $message, 6, 'members.php?do=Add', 'danger');
                    } else{
                        $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, Fullname, RegStatus, Date) VALUES(:zuser, :zpass, :zmail, :zname, 0, now())");
                        $stmt->execute(array(
                            'zuser' => $user,
                            'zpass' => $shaPass,
                            'zmail' => $email,
                            'zname' => $name
                        ));

                        // Print message
                        $message = $stmt->rowCount() . " Record Inserted"; 
                        redirecting('', $message, 6, 'members.php', 'success');
                    }
                }
            }else{
                $message = 'Sorry ... You can\'t access this page in this way';
                redirecting('', $message, 6, 'index.php', 'danger');
            }
        // Start Edit Section
        } elseif($do == 'Edit'){
            if(isset($_GET['userID']) && is_numeric($_GET['userID'])){
                $userID = intval($_GET['userID']);
            } else{
                $userID = 0;
            }
            $stmt = $con->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
            $stmt-> execute(array($userID)); // ? -> $username, ? -> $hashedPass
            $row = $stmt-> fetch();
            $count = $stmt->rowCount();
            // If count > 0, this mean the user is in the database
            if($count>0){
                ?>
                <h1 class="text-center">Edit Member</h1>
                <div class="container">
                    <form class="form-horizontal" action="members.php?do=Update" method="POST">
                        <input type="hidden" name="userid" value="<?php echo $userID; ?>"/>
                        <!-- Satrt Username -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="username" class="form-control" value="<?php echo $row['Username'];?>" autocomplete="off" placeholder="Username" required="required"/>
                            </div>
                        </div>
                        <!-- Satrt Password -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'];?>"/>
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Password"/>
                            </div>
                        </div>
                        <!-- Satrt Email -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="email" name="email" class="form-control" value="<?php echo $row['Email'];?>"placeholder="Email" required="required"/>
                            </div>
                        </div>
                        <!-- Satrt Fullname -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="full" class="form-control" value="<?php echo $row['Fullname'];?>" placeholder="Full Name" required="required"/>
                            </div>
                        </div>
                        <!-- Save -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg"/>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
            } else{
                $message = 'There is no such ID';
                redirecting('Edit Page',$message, 6, 'index.php', 'danger');
            }
            
        } elseif($do == 'Update'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h1 class='text-center'>Update Member</h1>";
                echo "<div class='container'>";
                // Take variables from the From
                $id     = $_POST['userid'];
                $user   = $_POST['username'];
                $email  = $_POST['email'];
                $name   = $_POST['full'];
                $pass   = '';
                
                // check if the password changed
                if(empty($_POST['newpassword'])){
                    $pass = $_POST['oldpassword'];
                } else{
                    $pass = sha1($_POST['newpassword']);
                }
                
                // Check the input before modify the database
                $errorArray = array();
                if(empty($user))        { $errorArray[] = "Username can not be <b>empty</b>"; }
                if(strlen($user)< 4)    { $errorArray[] = "Username should be <b>longer than 4</b>";}
                if(strlen($user)> 20)   { $errorArray[] = "Username should be <b>less than 20</b>";}
                if(empty($email))       { $errorArray[] = "Email can not be <b>empty</b>";}
                if(empty($name))        { $errorArray[] = "Full Name can not be <b>empty</b>";}
                
                foreach($errorArray as $error){
                    echo "<div class='alert alert-danger'>". $error ."</div>";
                }    
                
                if(empty($errorArray)){
                    $stmt1 = $con->prepare("SELECT * FROM users WHERE Username=? AND UserID!=?");
                    $stmt1-> execute(array($user, $id)); 
                    $row1 = $stmt1-> fetch();
                    $count = $stmt1->rowCount();
                    if($count == 1){
                        $message = 'Sorry ... This User is exist';
                        redirecting('',$message, 6, 'members.php', 'danger'); 
                    } else{
                        // Update the database
                        $stmt = $con->prepare("UPDATE users SET Username=?, Password=?, Email=?, Fullname=? WHERE userID=?");
                        $stmt->execute(array($user, $pass, $email, $name, $id));

                        // Print message
                        $message = $stmt->rowCount() . " Record Updated</div>"; 
                        redirecting('',$message, 6, 'members.php', 'success');
                    }
                }
            }else{
                $message = 'Sorry ... You can\'t access this page in this way';
                redirecting('Update Page',$message, 6, 'index.php', 'danger');                
            }
        } elseif($do == 'Delete'){
            if(isset($_GET['userID']) && is_numeric($_GET['userID'])){
                $userID = intval($_GET['userID']);
            } else{
                $userID = 0;
            }
            $count = checkItem('UserID', 'users', $userID);
            // If count > 0, this mean the user is in the database
            if($count>0){
                $stmt = $con->prepare("DELETE FROM users WHERE UserID= :zuser");
                $stmt -> bindParam("zuser", $userID);
                $stmt-> execute();
                $message = $stmt->rowCount() . " Record Deleted</div>";
                redirecting('Delete Member',$message, 6, 'members.php', 'success');
            } else{
                $message = 'There is no like this ID';
                redirecting('Delete Member',$message, 6, 'index.php', 'danger');    
            }
            
        } elseif( $do = 'Activate'){
            if(isset($_GET['userID']) && is_numeric($_GET['userID'])){
                $userID = intval($_GET['userID']);
            } else{
                $userID = 0;
            }
            $count = checkItem('UserID', 'users', $userID);
            // If count > 0, this mean the user is in the database
            if($count>0){
                $stmt = $con->prepare("UPDATE users SET RegStatus=1 WHERE userID=$userID");
                $stmt-> execute();
                $message = $stmt->rowCount() . " Record Activated</div>";
                redirecting('Activated Member',$message, 6, 'members.php', 'success');
            } else{
                $message = 'There is no like this ID';
                redirecting('Activated Member',$message, 6, 'index.php', 'danger');    
            }
        } else{
            $message = 'There is no like this page';
            redirecting('Error',$message, 6, 'indxe.php', 'danger');    
        }
        
        ?>
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
        
    } else{
        header('location: index.php');
        exit();
    }

    ob_end_flush();
?>