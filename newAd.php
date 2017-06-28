<?php 
    session_start();
    $pageTitle = 'Profile';
    include "init.php";
    $message = '';
    $errorsArray = array();
    if(isset($_SESSION['NormalUser'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name           = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $description    = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $price          = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            $country        = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
            $status         = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
            $category       = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

            if(strlen($name) < 4)           { $errorsArray[] = "The Name Should Be Larger Than 4";}
            if(strlen($description) < 10)   { $errorsArray[] = "The Description Should Be Larger Than 10";}
            if(strlen($country) < 2)        { $errorsArray[] = "The Country Should Be Larger Than 2";}
            if(empty($country))     { $errorsArray[] = "The Price Must not be empty";}
            if(empty($status))      { $errorsArray[] = "The Status Must not be empty";}
            if(empty($category))    { $errorsArray[] = "The Category Must not be empty";}

            if(empty($errorsArray)){
                $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Add_Date, Country_Name, Status, Cat_ID, Member_ID) 
                                VALUES(:zname, :zdesc, :zprice, now(), :zcoun, :zstatus, :zcat, :zmemb)");
                $stmt->execute(array(
                    'zname'     => $name,
                    'zdesc'     => $description,
                    'zprice'    => $price,
                    'zcoun'     => $country,
                    'zstatus'   => $status,
                    'zcat'      => $category,
                    'zmemb'     => $_SESSION['uID']
                ));
                if($stmt){
                    $message = "<div class='alert alert-success'> The Item was Added </div>";
                }
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
            <link rel="stylesheet" href="layout/css/jquery.selectBoxIt.css"/>
            <link rel="stylesheet" href="soso.css"/>
            <title><?php getTitle();?></title>
        </head>
        <body>
            <?php
                if(isset($_SESSION['NormalUser'])){
                    $stmt = $con->prepare("SELECT * FROM users WHERE Username=?");
                    $stmt-> execute(array($_SESSION['NormalUser']));
                    $info = $stmt->fetch();
            ?>
                    <h1 class="text-center">New Item</h1>
                    <div class="information">
                        <div class="container">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Add New Item</div>
                                <div class="panel-body">
                                    <div class='col-sm-6 col-md-9'>
                                        <form class="form-horizontal newAdFrom" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                                            <!-- Satrt Name -->
                                            <div class="form-group form-group-lg">
                                                <label class="col-sm-2 control-label">Name</label>
                                                <div class="col-sm-10 col-md-8">
                                                    <input pattern=".{4,}" title="The Name Should Be at Least 4 Letters" type="text" name="name" class="form-control nameForm" placeholder="Item Name" required="required"/>
                                                </div>
                                            </div>
                                            <!-- Description Name -->
                                            <div class="form-group form-group-lg">
                                                <label class="col-sm-2 control-label">Description</label>
                                                <div class="col-sm-10 col-md-8">
                                                    <input pattern=".{10,}" title="The Description Should Be at Least 10 Letters" type="text" name="description" class="form-control descForm" placeholder="Item Description" required="required"/>
                                                </div>
                                            </div>
                                            <!-- Price Name -->
                                            <div class="form-group form-group-lg">
                                                <label class="col-sm-2 control-label">Price</label>
                                                <div class="col-sm-10 col-md-8">
                                                    <input pattern= "[0-9]{1,9}"  title= "Just Numbers And Less Than 9 Digits" type="text" name="price" class="form-control priceForm" placeholder="Item Price" required="required"/>
                                                </div>
                                            </div>
                                            <!-- Country Name -->
                                            <div class="form-group form-group-lg">
                                                <label class="col-sm-2 control-label">Country</label>
                                                <div class="col-sm-10 col-md-8">
                                                    <input pattern=".{2,}" title="The Country Should Be at Least 2 Letters" type="text" name="country" class="form-control" placeholder="Item Country Name" required="required"/>
                                                </div>
                                            </div>
                                            <!-- Status Name -->
                                            <div class="form-group form-group-lg">
                                                <label class="col-sm-2 control-label">Status</label>
                                                <div class="col-sm-10 col-md-8">
                                                    <select name ="status" required>
                                                        <option value='0'>...</option>
                                                        <option value='1'>New</option>
                                                        <option value='2'>Like New</option>
                                                        <option value='3'>Used</option>
                                                        <option value='4'>Old</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Category Field -->
                                            <div class="form-group form-group-lg">
                                                <label class="col-sm-2 control-label">Category</label>
                                                <div class="col-sm-10 col-md-8">
                                                    <select name ="category" required>
                                                        <option value='0'>...</option>
                                                        <?php
                                                            $stat2 = $con->prepare("SELECT * FROM categories");
                                                            $stat2->execute();
                                                            $cats = $stat2->fetchAll();
                                                            foreach($cats as $cat){
                                                                echo "<option value='". $cat["ID"] ."'>" . $cat["Name"] . "</option>";
                                                            }

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Save -->
                                            <div class="form-group form-group-lg">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <input type="submit" value="Add Item" class="btn btn-primary btn-md"/>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class='col-sm-6 col-md-3'>
                                        <div class='thumbnail item-box'>
                                            <span class='price-tag priceLive'>$0</span>
                                            <img class='img-responsive' src='layout/images/image.png' alt='' />
                                            <div class='caption'>
                                                <h3 class="nameLive">Title</h3>
                                                <p class="descLive">Description</p>
                                            </div>
                                        </div>
                                    </div>
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
            <script src="layout/js/jquery.selectBoxIt.min.js"></script>
            <script src="layout/js/backend.js"></script>
            <script src="layout/js/frontend.js"></script>
            <script src="layout/js/frontend1.js"></script>
        </body>
</html>
<?php 
    ob_end_flush();
?>