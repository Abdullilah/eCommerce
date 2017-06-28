<?php 
    session_start();
    $pageTitle = 'Items';
    include "init.php";
    
    
?>
    <html>
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" href="layout/css/bootstrap.css"/>
            <link rel="stylesheet" href="layout/css/font-awesome.min.css"/>
            <link rel="stylesheet" href="layout/css/jquery-ui.css"/>
            <link rel="stylesheet" href="layout/css/jquery.selectBoxIt.css"/>
            <link rel="stylesheet" href="layout/css/frontEnd.css"/>
            <title><?php getTitle();?></title>
        </head>
        <body>
            <?php
                if(isset($_GET['itemID']) && is_numeric($_GET['itemID'])){
                    $itemID = intval($_GET['itemID']);
                } else{
                    $itemID = 0;
                }
            
                $stmt = $con->prepare("SELECT items.*, 
                                            categories.Name AS categoriesName, 
                                            users.Username AS userName
                                            FROM items 
                                            INNER JOIN categories
                                            ON categories.ID = items.Cat_ID
                                            INNER JOIN users
                                            ON users.UserID = items.Member_ID
                                            WHERE ItemID=?
                                            AND Approve=1");
                $stmt->execute(array($itemID));
                $count = $stmt->rowCount();
                if($count > 0){
                    $item = $stmt->fetch();
                    ?>
                        <h1 class="text-center"><?php echo $item["Name"]; ?></h1>
                        <div class="information">
                            <div class="container">
                                <div class="row">
                                    <div class='col-sm-6 col-md-3'>
                                        <div class='img-thumbnail'>
                                            <img class='img-responsive' src='layout/images/image.png' alt='' />
                                        </div>
                                    </div>
                                    <div class='col-sm-6 col-md-9 info-item'>
                                        <h2><?php echo $item["Name"]; ?></h2>
                                        <ul class="list-unstyled">
                                            <li>
                                                <i class="fa fa-book fa-fw"></i>
                                                <span><?php echo $item["Description"]; ?></span>
                                            </li>
                                            <li>
                                                <i class="fa fa-calendar fa-fw"></i>
                                                <span>Added Date: <?php echo $item["Add_Date"]; ?></span>
                                            </li>
                                            <li>
                                                <i class="fa fa-money fa-fw"></i>
                                                <span>Price: $<?php echo $item["Price"]; ?></span>
                                            </li>
                                            <li>
                                                <i class="fa fa-industry fa-fw"></i>
                                                <span>Made in: <?php echo $item["Country_Name"]; ?></span>
                                            </li>
                                            <li>
                                                <i class="fa fa-briefcase fa-fw"></i>
                                                <span>Category: <a href="categories.php?catID=<?php echo $item['Cat_ID'];?>&catName=<?php echo $item["categoriesName"];?>"><?php echo $item["categoriesName"]; ?></a></span>
                                            </li>
                                            <li>
                                                <i class="fa fa fa-user-o fa-fw"></i>
                                                <span>Added By: <a href="#"><?php echo $item["userName"]; ?></a></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dashedLine"></div>
                        <div class="addComm">
                            <div class="container">
                                <div class="row">
                                    <div class='col-sm-6 col-md-3'></div>
                                    <div class='col-sm-6 col-md-9'>
                                        <h2>Add New Comment</h2>
                                        <?php
                                            if(isset($_SESSION['NormalUser'])){
                                                ?>
                                                <form action="items.php?itemID=<?php echo $item["ItemID"];?>" method="POST">
                                                    <textarea name="comment" required></textarea>
                                                    <input class="btn btn-primary" type="submit" value="Add Comment">
                                                </form>
                                                <?php 
                                                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                                        if(!empty($_POST["comment"])){
                                                            $comm = filter_var($_POST["comment"], FILTER_SANITIZE_STRING);
                                                            $user = $_SESSION['uID'];
                                                            $item =  $item["ItemID"];

                                                            $stmt1 = $con->prepare("INSERT INTO comments
                                                            (C_Comment, C_Status, C_Date, item_ID, user_ID) VALUES
                                                            (:zcomm, 0, now(), :zitemID, :zuserID )");
                                                            $stmt1->execute(array(
                                                                'zcomm' => $comm,
                                                                'zitemID' => $item,
                                                                'zuserID' => $user
                                                            ));
                                                            if($stmt1){
                                                                echo "<div class='alert alert-success'>Comment Added</div>";
                                                            }
                                                        } else{
                                                            echo "<div class='alert alert-danger'>Comment Must Not Be Empty </div>";
                                                        }
                                                        
                                                    }
                                            } else{
                                                echo "To Add Comment <a href='login.php'>Log-in</a> or <a href='login.php'>Sign-in</a>";
                                            }
                                        ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dashedLine"></div>
                        <div class="commItems">
                            <div class="container">
                                    <h2 class="col-md-offset-2">Activited Comments</h2>
                                    <?php
                                    $stmt2 = $con->prepare("SELECT comments.*, users.Username AS Member
                                                            FROM comments 
                                                            INNER JOIN users
                                                            ON users.UserID = comments.user_ID
                                                            WHERE item_ID=? 
                                                            AND C_Status=1");
                                    $stmt2->execute(array($itemID));
                                    $count2 = $stmt2->rowCount();
                                    if($count2 > 0){
                                        $commnts = $stmt2->fetchAll();
                                        foreach($commnts as $comm){
                                            ?>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <div class="row">
                                                        <div class='col-sm-6 col-md-2'>
                                                            <img class='img-responsive img-thumbnail img-circle' src='layout/images/image.png' alt='' />
                                                        </div>
                                                        <div class='col-sm-6 col-md-10 comm-item'>
                                                            <!-- We can Add transparent in CSS to make it like a comments -->
                                                            <p class="nameCom"><?php echo $comm['Member']; ?></p>
                                                            <p><?php echo $comm['C_Comment']; ?></p>
                                                        </div>   
                                                    </div>
                                                </li>
                                            </ul>
                                            <?php
                                        }
                                    } else{
                                        echo "<div class='alert alert-info'> 
                                                    There is no Comments to Show ...
                                            </div>";
                                    }
                                    ?>
                                
                            </div>
                        </div>

                    <?php
                } else{
                    ?>
                        <div class="container">
                            <h3 class="text-center alert alert-danger">There is no such an item or This Item Still Not Approved by the Admin</h3>
                        </div>
                        
                    <?php
                }
            ?>
            <div class="footer">
            </div>
            <script src="layout/js/jquery-1.12.4.min.js"></script>
            <script src="layout/js/jquery-ui.min.js"></script>
            <script src="layout/js/bootstrap.min.js"></script>
            <script src="layout/js/jquery.selectBoxIt.min.js"></script>
            <script src="layout/js/backend.js"></script>
            <script src="layout/js/frontend.js"></script>
            <script src="layout/js/frontend1.js"></script>
        </body>
</html>
<?php 
    ob_end_flush();
?>