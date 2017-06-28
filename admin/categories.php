<?php
    
    ob_start();

    session_start();
    $pageTitle = 'Categories';
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
            $sort = 'ASC';
            $sortArr = array('ASC', 'DESC');
            if(isset($_GET['sort']) && in_array($_GET['sort'], $sortArr)){
                $sort = $_GET['sort'];
            }       
               
            // Select all users except the Admin
            $stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
            $stmt->execute();
            $rows = $stmt->fetchAll();
                echo '<h1 class="text-center">' . lang('Manage_Categories')  . '</h1>';
            if(!empty($rows)){
                ?>
                <div class="container">
                    <div class="table-responsive">
                        <table class="table table-bordered table-main text-center">
                            <tr>
                                <td>#ID</td>
                                <td><?php echo lang('Name'); ?></td>
                                <td><?php echo lang('Description'); ?></td>
                                <td><?php echo lang('Ordering'); ?>
                                    <span class="arrow">
                                        <a href="categories.php?do=Manage&sort=ASC"><span class="glyphicon glyphicon-chevron-down <?php if($sort == 'ASC'){echo 'activited';}; ?>" aria-hidden="true"></span></a>
                                        <a href="categories.php?do=Manage&sort=DESC"><span class="glyphicon glyphicon-chevron-up <?php if($sort == 'DESC'){echo 'activited';}; ?>" aria-hidden="true"></span></a>
                                    </span>
                                </td>
                                <td><?php echo lang('Total_Members'); ?></td>
                                <td><?php echo lang('Allow_Comment'); ?></td>
                                <td><?php echo lang('Allow_Ads'); ?></td>
                                <td><?php echo lang('Control'); ?></td>
                            </tr>
                            <?php
                                foreach($rows as $row){
                                    echo "<tr>";
                                        echo "<td>" . $row['ID'] . "</td>";
                                        echo "<td>" . $row['Name'] . "</td>";
                                        echo "<td>"; if(empty($row['Description'])) { 
                                                            echo "<span style='color:#95A5A6'>This is empty</span>";} 
                                                    else{ echo $row['Description'];}; 
                                        echo "</td>";
                                        echo "<td>" .$row['Ordering'] . "</td>";
                                        echo "<td>"; if($row['Visibility'] == 0){ 
                                                            echo "<span style='color:#3FC380'>YES</span>";} 
                                                    else{ echo "<span style='color:#C0392B'>NO</span>";}; 
                                        echo "</td>";
                                        echo "<td>"; if($row['Allow_Comment'] == 0){ 
                                                            echo "<span style='color:#3FC380'>YES</span>";} 
                                                    else{ echo "<span style='color:#C0392B'>NO</span>";}; 
                                        echo "</td>";
                                        echo "<td>"; if($row['Allow_Ads'] == 0){ 
                                                            echo "<span style='color:#3FC380'>YES</span>";} 
                                                    else{ echo "<span style='color:#C0392B'>NO</span>";}; 
                                        echo "</td>";   
                                        echo '<td>
                                                <a href="categories.php?do=Edit&ID=' .$row['ID']. '"class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="categories.php?do=Delete&ID=' .$row['ID']. '"class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
                                        echo '</td>';
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <a href='categories.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> New Category</a>
                </div>
            <?php
            } else{
                echo "<div class='container'>";
                        echo "<div class='alert alert-info'> There is no Categories to Show </div>";
                        echo "<a href='categories.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> New Category</a>";
                echo "</div>";
            }
                
        ?>
            
            
        <?php
        } elseif($do == 'Add'){
        ?>
            <h1 class="text-center">Add New Category</h1>
                <div class="container">
                    <form class="form-horizontal" action="categories.php?do=Insert" method="POST">
                        <!-- Satrt Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Category Name" required="required"/>
                            </div>
                        </div>
                        <!-- Satrt Description -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="description" class="form-control" placeholder="Description" />
                            </div>
                        </div>
                        <!-- Satrt Ordering -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Ordering</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="ordering" class="form-control" placeholder="Number to Arrange Category" required="required"/>
                            </div>
                        </div>
                        <!-- Satrt Visible -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Visible</label>
                            <div class="col-sm-10 col-md-4">
                                <div>
                                    <input id="vis-yes" type="radio" name="visiblility" value="0" checked />
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visiblility" value="1" />
                                    <label for="vis-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- Satrt Commenting -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Commenting</label>
                            <div class="col-sm-10 col-md-4">
                                <div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" checked />
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1" />
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- Satrt Allow Ads -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Ads</label>
                            <div class="col-sm-10 col-md-4">
                                <div>
                                    <input id="ads-yes" type="radio" name="ads" value="0" checked />
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="1" />
                                    <label for="ads-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- Save -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Category" class="btn btn-primary btn-lg"/>
                            </div>
                        </div>
                    </form>
                </div>
        <?php
        } elseif($do == 'Insert'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h1 class='text-center'>Add New Category</h1>";
                echo "<div class='container'>";
                // Take variables from the From
                $name   = $_POST['name'];
                $desc   = $_POST['description'];
                $order  = $_POST['ordering'];
                $visi   = $_POST['visiblility'];
                $comm   = $_POST['commenting'];
                $ads    = $_POST['ads'];
                
                if(empty($name)){
                    echo "<div class='alert alert-danger'>Name ahould not be empty<div>";    
                } elseif(!is_numeric($order)){
                    echo "<div class='alert alert-danger'>Ordering Should Be a Number<div>";    
                } else{
                    // Insert into the database
                    $check = checkItem("Name", "categories", $name);
                    if($check == 1){
                        $message = 'This Name is already taken';
                        redirecting('', $message, 6, 'categories.php?do=Add', 'danger');
                    } else{
                        $stmt = $con->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads) VALUES(:zname, :zdesc, :zorder, :zvisib, :zallowCom, :zallowAdd)");
                        $stmt->execute(array(
                            'zname' => $name,
                            'zdesc' => $desc,
                            'zorder' => $order,
                            'zvisib' => $visi,
                            'zallowCom' => $comm,
                            'zallowAdd' => $ads
                        ));

                        // Print message
                        $message = $stmt->rowCount() . " Record Inserted"; 
                        redirecting('', $message, 6, 'categories.php', 'success');
                    }
                }
            }else{
                $message = 'Sorry ... You can\'t access this page in this way';
                redirecting('', $message, 6, 'index.php', 'danger');
            }
        } elseif($do == 'Edit'){
            if(isset($_GET['ID']) && is_numeric($_GET['ID'])){
                $ID = intval($_GET['ID']);
            } else{
                $ID = 0;
            }
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID=? LIMIT 1");
            $stmt-> execute(array($ID)); // ? -> $username, ? -> $hashedPass
            $row = $stmt-> fetch();
            $count = $stmt->rowCount();
            // If count > 0, this mean the user is in the database
            if($count>0){
                ?>
                <h1 class="text-center">Edit Category</h1>
                <div class="container">
                    <form class="form-horizontal" action="categories.php?do=Update" method="POST">
                        <input type="hidden" name="ID" value="<?php echo $ID; ?>"/>
                        <!-- Satrt Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Category Name" required="required" value="<?php echo $row['Name'];?>"/>
                            </div>
                        </div>
                        <!-- Satrt Description -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="description" class="form-control" placeholder="Description" value="<?php echo $row['Description'];?>"/>
                            </div>
                        </div>
                        <!-- Satrt Ordering -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Ordering</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="ordering" class="form-control" placeholder="Number to Arrange Category" required="required" value="<?php echo $row['Ordering'];?>"/>
                            </div>
                        </div>
                        <!-- Satrt Visible -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Visible</label>
                            <div class="col-sm-10 col-md-4">
                                <div>
                                    <input id="vis-yes" type="radio" name="visiblility" value="0" <?php if($row['Visibility'] == '0'){echo 'checked';};?> />
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visiblility" value="1" <?php if($row['Visibility'] == '1'){echo 'checked';}; ?>/>
                                    <label for="vis-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- Satrt Commenting -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Commenting</label>
                            <div class="col-sm-10 col-md-4">
                                <div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" <?php if($row['Allow_Comment'] == '0'){echo 'checked';};?> />
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1" <?php if($row['Allow_Comment'] == '1'){echo 'checked';};?>/>
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- Satrt Allow Ads -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Ads</label>
                            <div class="col-sm-10 col-md-4">
                                <div>
                                    <input id="ads-yes" type="radio" name="ads" value="0" <?php if($row['Allow_Ads'] == '0'){echo 'checked';};?> />
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="1" <?php if($row['Allow_Ads'] == '1'){echo 'checked';};?>/>
                                    <label for="ads-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- Save -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Category" class="btn btn-primary btn-lg"/>
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
                echo "<h1 class='text-center'>Update Category</h1>";
                echo "<div class='container'>";
                // Take variables from the From
                $ID     = $_POST['ID'];
                $name   = $_POST['name'];
                $desc   = $_POST['description'];
                $order  = $_POST['ordering'];
                $visi   = $_POST['visiblility'];
                $comm   = $_POST['commenting'];
                $ads    = $_POST['ads'];
                
                // Check the input before modify the database
                
                if(empty($name)){
                    echo "<div class='alert alert-danger'>Name ahould not be empty<div>";    
                } elseif(!is_numeric($order)){
                    echo "<div class='alert alert-danger'>Ordering Should Be a Number<div>";    
                } else{
                    // Update the database
                    $stmt = $con->prepare("UPDATE categories SET Name=?, Description=?, Ordering=?, Visibility=?, Allow_Comment=?, Allow_Ads=? WHERE ID=?");
                    $stmt->execute(array($name, $desc, $order, $visi, $comm, $ads, $ID));
                    
                    // Print message
                    $message = $stmt->rowCount() . " Record Updated</div>"; 
                    redirecting('',$message, 6, 'categories.php', 'success');
                }
            }else{
                $message = 'Sorry ... You can\'t access this page in this way';
                redirecting('Update Page',$message, 6, 'index.php', 'danger');                
            }
        } elseif($do == 'Delete'){
            if(isset($_GET['ID']) && is_numeric($_GET['ID'])){
                $ID = intval($_GET['ID']);
            } else{
                $ID = 0;
            }
            $count = checkItem('ID', 'categories', $ID);
            // If count > 0, this mean the user is in the database
            if($count>0){
                $stmt = $con->prepare("DELETE FROM categories WHERE ID= :zuser");
                $stmt -> bindParam("zuser", $ID);
                $stmt-> execute();
                $message = $stmt->rowCount() . " Record Deleted</div>";
                redirecting('Delete Category',$message, 6, 'categories.php', 'success');
            } else{
                $message = 'There is no like this ID';
                redirecting('Delete Category',$message, 6, 'index.php', 'danger');    
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