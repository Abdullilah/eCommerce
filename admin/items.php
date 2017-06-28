<?php
    
    ob_start();

    session_start();
    $pageTitle = 'Items';
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
            if(isset($_GET['Page']) && $_GET['Page'] == 'Approving'){
                $query = 'WHERE Approve=0';
            }
            // Select all users except the Admin
            $stmt = $con->prepare("SELECT items.*, categories.Name AS cate_name, users.Username AS owner_name FROM items
                                    INNER JOIN categories ON categories.ID = items.Cat_ID
                                    INNER JOIN users ON users.UserID = items.Member_ID ORDER BY ItemID DESC $query");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if($query == ''){
                echo '<h1 class="text-center">' . lang('Manage_Items')  . '</h1>';
            } else{
                echo '<h1 class="text-center">' . lang('Pending_Items')  . '</h1>';
            }
            if(!empty($rows)){
                ?>
                <div class="container">
                    <div class="table-responsive">
                        <table class="table table-bordered table-main text-center">
                            <tr>
                                <td>#ID</td>
                                <td><?php echo lang('Name'); ?></td>
                                <td><?php echo lang('Description'); ?></td>
                                <td><?php echo lang('Price'); ?></td>
                                <td><?php echo lang('Status'); ?></td>
                                <td><?php echo lang('Adding_Date'); ?></td>
                                <td><?php echo lang('Category'); ?></td>
                                <td><?php echo lang('Owner'); ?></td>
                                <td><?php echo lang('Control'); ?></td>
                            </tr>
                            <?php
                                foreach($rows as $row){
                                    echo "<tr>";
                                        echo "<td>" . $row['ItemID'] . "</td>";
                                        echo "<td>" . $row['Name'] . "</td>";
                                        echo "<td>" . $row['Description'] . "</td>";
                                        echo "<td>" . $row['Price'] . "</td>";
                                        echo "<td>";
                                            if($row['Status'] == 1){ echo "New" ;}
                                            elseif($row['Status'] == 2){echo "Like New" ;}
                                            elseif($row['Status'] == 3){echo "Used" ;}
                                            elseif($row['Status'] == 4){echo "Old" ;}
                                            else{ echo "...";}
                                        echo "</td>";
                                        echo "<td>" . $row['Add_Date'] . "</td>";
                                        echo "<td>" . $row['cate_name'] . "</td>";
                                        echo "<td>" . $row['owner_name'] . "</td>";
                                        echo '<td>
                                                <a href="items.php?do=Edit&itemID=' .$row['ItemID']. '"class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="items.php?do=Delete&itemID=' .$row['ItemID']. '"class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
                                                if($row["Approve"] == 0){
                                                    echo '<a href="items.php?do=Approve&itemID=' .$row['ItemID']. '"class="btn btn-info active"> <i class="fa fa-check"></i> Approve</a>';
                                                }
                                        echo '</td>';

                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <a href='items.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>
                </div>
            <?php
            } else{
                echo "<div class='container'>";
                        echo "<div class='alert alert-info'> There is no Items to Show </div>";
                        echo "<a href='items.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> New Item</a>";
                echo "</div>";
            }
        ?>
            
            
        <?php
        } elseif($do == 'Add'){
            ?>
            <h1 class="text-center">Add New Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="items.php?do=Insert" method="POST">
                        <!-- Satrt Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="Item Name" required="required"/>
                            </div>
                        </div>
                        <!-- Description Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="description" class="form-control" placeholder="Item Description" required="required"/>
                            </div>
                        </div>
                        <!-- Price Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="price" class="form-control" placeholder="Item Price in USD $" required="required"/>
                            </div>
                        </div>
                        <!-- Country Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="country" class="form-control" placeholder="Item Country Name" required="required"/>
                            </div>
                        </div>
                        <!-- Status Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-md-4">
                                <select name ="status">
                                    <option value='0'>...</option>
                                    <option value='1'>New</option>
                                    <option value='2'>Like New</option>
                                    <option value='3'>Used</option>
                                    <option value='4'>Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- Member Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10 col-md-4">
                                <select name ="member">
                                    <option value='0'>...</option>
                                    <?php
                                        $stat = $con->prepare("SELECT * FROM users");
                                        $stat->execute();
                                        $users = $stat->fetchAll();
                                        foreach($users as $user){
                                            echo "<option value='". $user["UserID"] ."'>" . $user["Username"] . "</option>";
                                        }
            
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Category Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10 col-md-4">
                                <select name ="category">
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
        <?php
        } elseif($do == 'Insert'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h1 class='text-center'>Add New Item</h1>";
                echo "<div class='container'>";
                // Take variables from the From
                $name   = $_POST['name'];
                $desc   = $_POST['description'];
                $pric   = $_POST['price'];
                $coun   = $_POST['country'];
                $stat   = $_POST['status'];
                $memb   = $_POST['member'];
                $cate   = $_POST['category'];
                
                // Check the input before modify the database
                $errorArray = array();
                if(empty($name))     { $errorArray[] = "Name can not be <b>empty</b>"; }
                if(empty($desc))     { $errorArray[] = "Description can not be <b>empty</b>"; }
                if(empty($pric))     { $errorArray[] = "Price can not be <b>empty</b>";}
                if(empty($coun))     { $errorArray[] = "Country Name can not be <b>empty</b>";}
                if($stat == 0)       { $errorArray[] = "Status Name can not be <b>empty</b>";}
                if(empty($memb))     { $errorArray[] = "Member Name can not be <b>empty</b>";}
                if(empty($cate))     { $errorArray[] = "Category Name can not be <b>empty</b>";}
                
                foreach($errorArray as $error){
                    echo "<div class='alert alert-danger'>" . $error . "<div>";
                }    
                
                if(empty($errorArray)){
                    
                    $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Add_Date, Country_Name, Status, Cat_ID, Member_ID) 
                                VALUES(:zname, :zdesc, :zprice, now(), :zcoun, :zstatus, :zcat, :zmemb)");
                    $stmt->execute(array(
                        'zname'     => $name,
                        'zdesc'     => $desc,
                        'zprice'    => $pric,
                        'zcoun'     => $coun,
                        'zstatus'   => $stat,
                        'zcat'      => $cate,
                        'zmemb'     => $memb
                    ));

                    // Print message
                    $message = $stmt->rowCount() . " Record Inserted"; 
                    redirecting('', $message, 6, 'items.php', 'success');
                }
                
            }else{
                $message = 'Sorry ... You can\'t access this page in this way';
                redirecting('', $message, 6, 'index.php', 'danger');
            }
        } elseif($do == 'Edit'){
            if(isset($_GET['itemID']) && is_numeric($_GET['itemID'])){
                $itemID = intval($_GET['itemID']);
            } else{
                $itemID = 0;
            }
            $stmt = $con->prepare("SELECT * FROM items WHERE ItemID=? LIMIT 1");
            $stmt-> execute(array($itemID)); // ? -> $username, ? -> $hashedPass
            $row = $stmt-> fetch();
            $count = $stmt->rowCount();
            // If count > 0, this mean the user is in the database
            if($count>0){
                ?>
            <h1 class="text-center">Edit New Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="items.php?do=Update" method="POST">
                        <input type="hidden" name="itemID" value="<?php echo $itemID; ?>"/>
                        <!-- Satrt Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="Item Name" required="required" 
                                       value="<?php echo $row['Name']; ?>"/>
                            </div>
                        </div>
                        <!-- Description Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="description" class="form-control" placeholder="Item Description" required="required"
                                       value="<?php echo $row['Description']; ?>"/>
                            </div>
                        </div>
                        <!-- Price Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="price" class="form-control" placeholder="Item Price" required="required"
                                       value="<?php echo $row['Price']; ?>"/>
                            </div>
                        </div>
                        <!-- Country Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="country" class="form-control" placeholder="Item Country Name" required="required"
                                       value="<?php echo $row['Country_Name']; ?>"/>
                            </div>
                        </div>
                        <!-- Status Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-md-4">
                                <select name ="status">
                                    <option value='1' <?php if($row['Status'] == 1){ echo 'selected';} ?>>New</option>
                                    <option value='2' <?php if($row['Status'] == 2){ echo 'selected';} ?>>Like New</option>
                                    <option value='3' <?php if($row['Status'] == 3){ echo 'selected';} ?>>Used</option>
                                    <option value='4' <?php if($row['Status'] == 4){ echo 'selected';} ?>>Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- Member Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10 col-md-4">
                                <select name ="member">
                                    <option value='0'>...</option>
                                    <?php
                                        $stat = $con->prepare("SELECT * FROM users");
                                        $stat->execute();
                                        $users = $stat->fetchAll();
                                        foreach($users as $user){
                                            echo "<option value='";
                                            echo $user["UserID"] ."'"; 
                                            if($row['Member_ID'] == $user["UserID"]){ echo "selected";};
                                            echo ">";
                                            echo $user["Username"] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Category Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10 col-md-4">
                                <select name ="category">
                                    <option value='0'>...</option>
                                    <?php
                                        $stat2 = $con->prepare("SELECT * FROM categories");
                                        $stat2->execute();
                                        $cats = $stat2->fetchAll();
                                        foreach($cats as $cat){
                                            echo "<option value='";
                                            echo $cat["ID"] ."'"; 
                                            if($row['Cat_ID'] == $cat["ID"]){ echo "selected";};
                                            echo ">";
                                            echo $cat["Name"] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Save -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save Item" class="btn btn-primary btn-md"/>
                            </div>
                        </div>
                    </form>
                </div>
            <?php
                $stmt = $con->prepare("SELECT comments.*, users.Username FROM comments
                                        INNER JOIN users ON users.UserID = comments.user_ID WHERE item_ID=?");
                $stmt->execute(array($itemID));
                $rows = $stmt->fetchAll();
                if(!empty($rows)){
                        echo '<h1 class="text-center">Manage Comments</h1>';
                    ?>
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-bordered table-main text-center">
                                <tr>
                                    <td>Comment</td>
                                    <td>User Name</td>
                                    <td>Add Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php
                                    foreach($rows as $row){
                                        echo "<tr>";
                                            echo "<td>" . $row['C_Comment'] . "</td>";
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
                    }
        // Start Add Section 
                 
            } else{
            $message = 'There is no such ID';
            redirecting('Edit Page',$message, 6, 'index.php', 'danger');
            }
        } elseif($do == 'Update'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h1 class='text-center'>Update Item</h1>";
                echo "<div class='container'>";
                // Take variables from the From
                $itemID = $_POST['itemID'];
                $name   = $_POST['name'];
                $desc   = $_POST['description'];
                $price  = $_POST['price'];
                $count  = $_POST['country'];
                $stat   = $_POST['status'];
                $membe  = $_POST['member'];
                $categ  = $_POST['category'];
                
                // Check the input before modify the database
                $errorArray = array();
                if(empty($name))     { $errorArray[] = "Item Name can not be <b>empty</b>"; }
                if(empty($desc))     { $errorArray[] = "Item Description can not be <b>empty</b>";}
                if(empty($price))    { $errorArray[] = "Item Price can not be <b>empty</b>";}
                if(empty($count))    { $errorArray[] = "Item Country can not be <b>empty</b>"; }
                if(empty($stat))     { $errorArray[] = "Item Status can not be <b>empty</b>";}
                if(empty($membe))    { $errorArray[] = "Item Member can not be <b>empty</b>";}
                if(empty($categ))    { $errorArray[] = "Item Category can not be <b>empty</b>";}
                
                foreach($errorArray as $error){
                    echo "<div class='alert alert-danger'>". $error ."</div>";
                }    
                
                if(empty($errorArray)){
                    // Update the database
                    $stmt = $con->prepare("UPDATE items SET 
                                            Name=?, Description=?, Price=?, Country_Name=?, Status=?, Cat_ID=?, Member_ID=? 
                                            WHERE ItemID=?");
                    $stmt->execute(array($name, $desc, $price, $count, $stat, $categ, $membe, $itemID));

                    // Print message
                    $message = $stmt->rowCount() . " Record Updated</div>"; 
                    redirecting('',$message, 6, 'items.php', 'success');
                }
            }else{
                $message = 'Sorry ... You can\'t access this page in this way';
                redirecting('Update Page',$message, 6, 'index.php', 'danger');                
            }
        } elseif($do == 'Delete'){
            if(isset($_GET['itemID']) && is_numeric($_GET['itemID'])){
                $itemID = intval($_GET['itemID']);
            } else{
                $itemID = 0;
            }
            $count = checkItem('ItemID', 'items', $itemID);
            // If count > 0, this mean the user is in the database
            if($count>0){
                $stmt = $con->prepare("DELETE FROM items WHERE ItemID= :zuser");
                $stmt -> bindParam("zuser", $itemID);
                $stmt-> execute();
                $message = $stmt->rowCount() . " Record Deleted</div>";
                redirecting('Delete Item',$message, 6, 'items.php', 'success');
            } else{
                $message = 'There is no like this ID';
                redirecting('Delete Item',$message, 6, 'index.php', 'danger');    
            }
        } elseif($do ='Approve'){
            if(isset($_GET['itemID']) && is_numeric($_GET['itemID'])){
                $itemID = intval($_GET['itemID']);
            } else{
                $itemID = 0;
            }
            $count = checkItem('ItemID', 'items', $itemID);
            // If count > 0, this mean the user is in the database
            if($count>0){
                $stmt = $con->prepare("UPDATE items SET Approve=1 WHERE ItemID=$itemID");
                $stmt-> execute();
                $message = $stmt->rowCount() . " Record Approved</div>";
                redirecting('Approved Item',$message, 6, 'items.php', 'success');
            } else{
                $message = 'There is no like this ID';
                redirecting('Approved Item',$message, 6, 'index.php', 'danger');    
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
        


?>