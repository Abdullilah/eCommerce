<?php
    ob_start();
    session_start();
    if(isset($_SESSION['Username'])){
        $pageTitle = 'Dashbord';
        include 'init.php';
        
        $stmt = $con-> prepare("SELECT COUNT(UserID) FROM users");
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

        <div class="container text-center home-stats">
            <h1><?php echo lang('Dashbord'); ?></h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        <i class="fa fa-users"></i>
                        <div class="info">
                            <h4><?php echo lang('Total_Members'); ?></h4>
                            <span><a href="members.php"><?php echo countMembers('UserID', 'users',''); ?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pendings">
                        <i class="fa fa-plus"></i>
                        <div class="info">
                            <h4><?php echo lang('Pending_Members'); ?></h4>
                            <span><a href="members.php?do=Manage&Page=Pending"><?php echo countMembers('UserID', 'users','AND RegStatus=0');?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items">
                        <i class="fa fa-tag"></i>
                        <div class="info">
                            <h4><?php echo lang('Total_Items'); ?></h4>
                            <span><a href="items.php?do=Manage"><?php echo countItems('ItemID', 'items','');?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">
                        <i class="fa fa-comment"></i>
                        <div class="info">
                            <h4><?php echo lang('Total_Comments'); ?></h4>
                            <span><a href="comments.php?do=Manage"><?php echo countItems('C_ID', 'comments','');?></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container latest">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <?php 
                            $latestNum = 5; 
                            $latestItems = 5; 
                        ?>
                        <div class="panel-heading">
                            <i class="fa fa-users"></i> Latest <?php echo $latestNum; ?> Registerd Members
                            <?php 
                                $stmt = $con->prepare("SELECT * FROM users WHERE RegStatus=0");
                                $stmt-> execute(); 
                                $row = $stmt-> fetch();
                                $count = $stmt->rowCount();
                                // If count > 0, 
                                if($count>0){
                                    echo '<a href="members.php?do=Manage&Page=Pending" class="btn btn-info act pull-right"> Activate</a>';
                                }
                            ?>
                            <i class="fa fa-plus plus"></i>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                            <?php 
                                $arr = getLatest('*', 'users', 'UserID', $latestNum);
                                if(!empty($arr)){
                                    foreach($arr as $user){
                                        echo "<li>" . $user['Username'] . "<a href='members.php?do=Edit&userID=". $user['UserID']. "'><span class='btn btn-success pull-right'><i class='fa fa-edit'></i> Edit</span></a>";
                                        if($user["RegStatus"] == 0){
                                                    echo '<a href="members.php?do=Activate&userID=' .$user['UserID']. '"class="btn btn-info pull-right active"><i class="fa fa-check"></i> Activate</a>';
                                                }
                                        echo "</li>";
                                    } 
                                }else{
                                       echo "There is no Members to Show";
                                }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i> Latest <?php echo $latestNum; ?> Registerd Items 
                            <?php 
                                $stmt = $con->prepare("SELECT * FROM items WHERE Approve=0");
                                $stmt-> execute(); 
                                $row = $stmt-> fetch();
                                $count = $stmt->rowCount();
                                // If count > 0, 
                                if($count>0){
                                    echo '<a href="items.php?do=Manage&Page=Approving" class="btn btn-info act pull-right"> Approve</a>';
                                }
                            ?>
                            <i class="fa fa-plus plus"></i>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                            <?php 
                                $arr = getLatest('*', 'items', 'ItemID', $latestItems);
                                if(!empty($arr)){
                                    foreach($arr as $item){
                                        echo "<li>" . $item['Name'] . "<a href='items.php?do=Edit&itemID=". $item['ItemID']. "'><span class='btn btn-success pull-right'><i class='fa fa-edit'></i> Edit</span></a>";
                                        if($item["Approve"] == 0){
                                                    echo '<a href="items.php?do=Approve&itemID=' .$item['ItemID']. '"class="btn btn-info pull-right active"><i class="fa fa-check"></i> Approve</a>';
                                                }
                                        echo "</li>";
                                    }
                                } else{
                                    echo "There is no Items to Show";
                                }
                                
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container latest">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <?php 
                            $latestCom = 5;
                        ?>
                        <div class="panel-heading">
                            <i class="fa fa-comments"></i> Latest <?php echo $latestCom; ?> Registerd Comments
                            <?php 
                                $stmt = $con->prepare("SELECT * FROM comments WHERE C_Status=0");
                                $stmt-> execute(); 
                                $row = $stmt-> fetch();
                                $count = $stmt->rowCount();
                                // If count > 0, 
                                if($count>0){
                                    echo '<a href="comments.php?do=Manage&Page=Pending" class="btn btn-info act pull-right"> Approve</a>';
                                }
                            ?>
                            <i class="fa fa-plus plus"></i>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                            <?php 
                                $stmt = $con->prepare("SELECT comments.*, users.Username FROM comments 
                                        INNER JOIN users ON users.UserID = comments.user_ID ORDER BY C_ID DESC LIMIT $latestCom");
                                $stmt->execute();
                                $rows = $stmt->fetchAll();
                                if(!empty($rows)){
                                    foreach($rows as $comm){
                                        echo "<span class='nameCom'>" . $comm['Username'] ."</span>";
                                        echo "<li  class='comCom'>";
                                            echo "<p>".$comm['C_Comment'] . "</p>";
                                            echo "<div class='com-btns'>";
                                                echo "<a href='comments.php?do=Edit&commentID=". $comm['C_ID']. "'><span class='btn btn-success pull-right'><i class='fa fa-edit'></i> Edit</span></a>";
                                                if($comm["C_Status"] == 0){
                                                    echo '<a href="comments.php?do=Approve&commentID=' .$comm['C_ID']. '"class="btn btn-info pull-right active"><i class="fa fa-check"></i> Approve</a>';
                                                }
                                            echo "</div>";
                                        echo "</li>";
                                    }
                                } else{
                                    echo "There is no Comments to Show";
                                }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

