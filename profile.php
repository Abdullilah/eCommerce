<?php 
    session_start();
    $pageTitle = 'Profile';
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
                if(isset($_SESSION['NormalUser'])){
                    $stmt = $con->prepare("SELECT * FROM users WHERE Username=?");
                    $stmt-> execute(array($_SESSION['NormalUser']));
                    $info = $stmt->fetch();
                    ?>
                        <h1 class="text-center">My Profile</h1>
                        <div class="information">
                            <div class="container">
                                <?php
                                    if($info['avatar'] != null){
                                    ?><div class="my-profImg">
                                            <img class="img-thumbnail img-circle" 
                                               src="admin\layout\uploads\<?php echo $info['avatar']; ?>" alt="">
                                      </div><?php
                                    }
                                ?>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">My information</div>
                                    <div class="panel-body">
                                        <div class="info">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <i class="fa fa-unlock-alt fa-fw"></i>
                                                    <span>Login Name:</span> <?php echo $info["Username"]; ?>
                                                </li>
                                                <li>
                                                    <i class="fa fa-envelope-o fa-fw"></i>
                                                    <span>Email:</span><?php echo $info["Email"]; ?>
                                                </li>
                                                <li>
                                                    <i class="fa fa-user fa-fw"></i>
                                                    <span>Full Name:</span><?php echo $info["Fullname"]; ?>
                                                </li>
                                                <li>
                                                    <i class="fa fa-calendar fa-fw"></i>
                                                    <span>Registrater Date:</span><?php echo $info["Date"]; ?>
                                                </li>
                                                <li>
                                                    <i class="fa fa-tags fa-fw"></i>
                                                    <span>Favourite Category:</span>
                                                </li>
                                            </ul> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="information">
                            <div class="container">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">My Items</div>
                                    <div class="panel-body">
                                        <?php 
                                            $membID = $info["UserID"];
                                            $stmt0 = $con->prepare("SELECT * FROM items WHERE Member_ID=$membID");
                                            $stmt0->execute();
                                            $rows0 = $stmt0->fetchAll();
                                            if(!empty($rows0)){
                                                foreach($rows0 as $item){
                                                    echo "<div class='col-sm-6 col-md-3'>";
                                                        echo "<div class='thumbnail item-box'>";
                                                        echo "<span class='dateAd'>" . $item['Add_Date'] . "</span>";
                                                            echo "<span class='price-tag'>$" . $item['Price']. "</span>";
                                                            if($item['Approve'] == 0){
                                                                echo "<p class='waiting'>Wait Admin Agreement</p>";
                                                            }
                                                            echo "<img class='img-responsive' src='layout/images/image.png' alt='' />";
                                                            echo "<div class='caption'>";
                                                                $catID = $item["Cat_ID"];
                                                                $stmt1 = $con->prepare("SELECT * FROM categories WHERE ID=$catID");
                                                                $stmt1->execute();
                                                                $rows1 = $stmt1->fetchAll();
                                                                foreach($rows1 as $cat1){
                                                                    echo "<a 
                                                                    href='items.php?itemID=".$item['ItemID']."'>
                                                                    <h3 class='itemTi'>" . $item['Name'] . " | " . $cat1['Name'] . "</h3>
                                                                    </a>";
                                                                }
                                                                echo "<p>" . $item['Description'] . "</p>";
                                                            echo "</div>";
                                                        echo "</div>";
                                                    echo "</div>";
                                                }
                                            } else{
                                                 echo "<div class='alert alert-info'> 
                                                            There is no Items to Show ...
                                                            <a href='newAd.php'> Create New Ad</a>
                                                    </div>";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="information">
                            <div class="container">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">My Comments</div>
                                    <div class="panel-body">
                                        <?php 
                                            $userID = $info["UserID"];
                                            $stmt2 = $con->prepare("SELECT * FROM comments WHERE user_ID=$userID");
                                            $stmt2->execute();
                                            $rows2 = $stmt2->fetchAll();
                                            if(!empty($rows2)){  
                                                foreach($rows2 as $comm){
                                                    $itemID = $comm["item_ID"];
                                                    $stmt4 = $con->prepare("SELECT * FROM items WHERE ItemID=$itemID");
                                                    $stmt4->execute();
                                                    $rows4 = $stmt4->fetchAll();
                                                    echo "<ul class='list-unstyled'>";
                                                    foreach($rows4 as $items){
                                                        echo "<li><span>" . $items['Name'] . "</span>" . $comm["C_Comment"] . "</li>";
                                                    }
                                                    echo "</ul>";
                                                }
                                            } else{
                                                 echo "<div class='alert alert-info'> There is no Comments to Show </div>";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                } else{
                    header('location: login.php');
                    exit();
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
    ob_end_flush();
?>