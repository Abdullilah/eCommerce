<?php

    /*
    =====================================================
    == In this page you can Delete | Edit Approve comment
    =====================================================
    */
    ob_start();

    session_start();
    $pageTitle = 'Comments';
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
                $query = 'Where C_Status=0';
            }
            // Select all users except the Admin
            $stmt = $con->prepare("SELECT comments.*, items.Name, users.Username FROM comments
                                    INNER JOIN items ON items.ItemID = comments.item_ID
                                    INNER JOIN users ON users.UserID = comments.user_ID ORDER BY C_ID DESC  $query");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!$query == ''){
                echo '<h1 class="text-center">' . lang('Pending_Comments')  . '</h1>';
            } else{
                echo '<h1 class="text-center">' . lang('Manage_Comments')  . '</h1>';
            }
            if(!empty($rows)){
                ?>
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-bordered table-main text-center">
                                <tr>
                                    <td>ID</td>
                                    <td><?php echo lang('Comment'); ?></td>
                                    <td><?php echo lang('Item_Name'); ?></td>
                                    <td><?php echo lang('User_Name'); ?></td>
                                    <td><?php echo lang('Add_Date'); ?></td>
                                    <td><?php echo lang('Control'); ?></td>
                                </tr>
                                <?php
                                    foreach($rows as $row){
                                        echo "<tr>";
                                            echo "<td>" . $row['C_ID'] . "</td>";
                                            echo "<td class='widthTable'>" . $row['C_Comment'] . "</td>";
                                            echo "<td>" . $row['Name'] . "</td>";
                                            echo "<td>" . $row['Username'] . "</td>";
                                            echo "<td>" . $row['C_Date'] . "</td>";
                                            echo '<td>
                                                    <a href="comments.php?do=Edit&commentID=' .$row['C_ID']. '"class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="comments.php?do=Delete&commentID=' .$row['C_ID']. '"class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
                                                    if($row["C_Status"] == 0){
                                                        echo '<a href="comments.php?do=Approve&commentID=' .$row['C_ID']. '"class="btn btn-info active"><i class="fa fa-check"></i> Approve</a>';
                                                    }
                                                echo '</td>';
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                <?php
            } else{
                echo "<div class='container'>";
                        echo "<div class='alert alert-info'> There is no Comments to Show </div>";
                echo "</div>";
            }
        ?>
            
            
        <?php
        // Start Add Section 
        } elseif($do == 'Edit'){
            if(isset($_GET['commentID']) && is_numeric($_GET['commentID'])){
                $commentID = intval($_GET['commentID']);
            } else{
                $commentID = 0;
            }
            $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID=? LIMIT 1");
            $stmt-> execute(array($commentID)); // ? -> $username, ? -> $hashedPass
            $row = $stmt-> fetch();
            $count = $stmt->rowCount();
            // If count > 0, this mean the user is in the database
            if($count>0){
                ?>
                <h1 class="text-center">Edit Comment</h1>
                <div class="container">
                    <form class="form-horizontal" action="comments.php?do=Update" method="POST">
                        <input type="hidden" name="commentid" value="<?php echo $commentID; ?>"/>
                        <!-- Satrt Username -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="comment"><?php echo $row['C_Comment']; ?></textarea>
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
                echo "<h1 class='text-center'>Update Comment</h1>";
                echo "<div class='container'>";
                // Take variables from the From
                $commentid     = $_POST['commentid'];
                $comment       = $_POST['comment'];
                
                $stmt = $con->prepare("UPDATE comments SET C_Comment=? WHERE C_ID=?");
                $stmt->execute(array($comment, $commentid));

                // Print message
                $message = $stmt->rowCount() . " Record Updated</div>"; 
                redirecting('',$message, 6, 'comments.php', 'success');
                
            }else{
                $message = 'Sorry ... You can\'t access this page in this way';
                redirecting('Update Page',$message, 6, 'index.php', 'danger');                
            }
        } elseif($do == 'Delete'){
            if(isset($_GET['commentID']) && is_numeric($_GET['commentID'])){
                $commentID = intval($_GET['commentID']);
            } else{
                $commentID = 0;
            }
            $count = checkItem('C_ID', 'comments', $commentID);
            // If count > 0, this mean the user is in the database
            if($count>0){
                $stmt = $con->prepare("DELETE FROM comments WHERE C_ID= :zcomm");
                $stmt -> bindParam("zcomm", $commentID);
                $stmt-> execute();
                $message = $stmt->rowCount() . " Record Deleted</div>";
                redirecting('Delete Comment',$message, 6, 'comments.php', 'success');
            } else{
                $message = 'There is no like this ID';
                redirecting('Delete Comment',$message, 6, 'index.php', 'danger');    
            }
            
        } elseif( $do = 'Approve'){
            if(isset($_GET['commentID']) && is_numeric($_GET['commentID'])){
                $commentID = intval($_GET['commentID']);
            } else{
                $commentID = 0;
            }
            $count = checkItem('C_ID', 'comments', $commentID);
            // If count > 0, this mean the user is in the database
            if($count>0){
                $stmt = $con->prepare("UPDATE comments SET C_Status=1 WHERE C_ID=$commentID");
                $stmt-> execute();
                $message = $stmt->rowCount() . " Record Approved</div>";
                redirecting('Approved Comment',$message, 6, 'comments.php', 'success');
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