<?php 
    session_start();
    $pageTitle = 'Categories';
    include "init.php";
?>
    <!DOCTYPE html>
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
            <h1 class="text-center"><?php echo str_replace('-',' ',$_GET['catName']); ?></h1>
            <div class="row">
                <?php 
                    $catID = $_GET['catID'];
                    $stmt = $con->prepare("SELECT * FROM items WHERE Cat_ID=$catID");
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
                                        echo "<a href='items.php?itemID=" . $cat['ItemID'] . "'><h3>" . $cat['Name'] . "</h3></a>";
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