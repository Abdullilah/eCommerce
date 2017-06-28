<?php 
    session_start();
    $pageTitle = "Home";
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
        <div class="container">
            <h1 class="text-center">All Items</h1>
            <div class="row">
                <?php 
                    $stmt = $con->prepare("SELECT * FROM items");
                    $stmt->execute();
                    $rows = $stmt->fetchAll();
                    if(!empty($rows)){
                        foreach($rows as $cat){
                            echo "<div class='col-sm-6 col-md-3'>";
                                echo "<div class='thumbnail item-box'>";
                                    echo "<span class='dateAd'>" . $cat['Add_Date'] . "</span>";
                                    echo "<span class='price-tag'>$" . $cat['Price']. "</span>";
                                    if($cat['Approve'] == 0){
                                        echo "<p class='waiting'>Wait Admin Agreement</p>";
                                    }
                                    echo "<img class='img-responsive' src='layout/images/image.png' alt='' />";
                                    echo "<div class='caption'>";
                                    $stmt1 = $con->prepare("SELECT * FROM categories WHERE ID=?");
                                    $stmt1->execute(array($cat['Cat_ID']));
                                    $rows1 = $stmt1->fetchAll();
                                    foreach($rows1 as $cat1){
                                        echo "<a 
                                        href='items.php?itemID=".$cat['ItemID']."'>
                                        <h3 class='itemTi'>" . $cat['Name'] . " | " . $cat1['Name'] . "</h3>
                                        </a>";
                                    }
                                    echo "<p>" . $cat['Description'] . "</p>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        }
                    } else{
                        echo "<div class='container'>";
                            echo "<div class='alert alert-info'> There is no Items to Show </div>";
                        echo "</div>";
                }
            ?>
            </div>
        </div>
        <div class="footer">
        </div>
        <script src="layout/js/jquery-1.12.4.min.js"></script>
        <script src="layout/js/jquery-ui.min.js"></script>
        <script src="layout/js/bootstrap.min.js"></script>
        <script src="layout/js/jquery.selectBoxIt.min.js"></script>
        <script src="layout/js/frontend.js"></script>
    </body>
</html>