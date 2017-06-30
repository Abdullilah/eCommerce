<div class="upper-bar">
    <div class="container">
        <?php
            if(isset($_SESSION['NormalUser'])){
                $stmt = $con->prepare("SELECT * FROM users WHERE UserID=?");
                $stmt-> execute(array($_SESSION['uID']));
                $row = $stmt-> fetch();
                $count = $stmt->rowCount();
                if($count == 1){
                    if($row['avatar'] == null){
                        ?><img class='my-image img-circle' src='admin\layout\images\image.png' alt='' /><?php
                    } else{
                        ?><img class='my-image img-circle' src='admin\layout\uploads\<?php echo $row['avatar']; ?>' alt='' /><?php
                    }
                    ?>
                        <div class="btn-group myinfo">
                            <span class="btn btn-defult dropdown-toggle" data-toggle="dropdown">
                                <?php echo $_SESSION['NormalUser']; ?>
                                <span class="caret"></span>
                            </span> 
                            <ul class="dropdown-menu">
                                <li><a href='profile.php'>My Profile</a></li>
                                <li><a href='newAd.php'>New Item</a></li>
                                <li><a href='logout.php'>log-out</a></li>
                            </ul>
                        </div>
                    <?php
                } else{
                    echo "Sorry but this user is not valid";
                    header("refresh:1;url=login.php");
                }
            } else{
                echo '
                <a href="login.php">
                    <span class="pull-right">Login | Signup</span>
                </a>';
            }
        ?>
    </div>
</div>


<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><?php echo lang('ADMIN'); ?></a>
    </div>
    <div class="collapse navbar-collapse navbar-right" id="app-nav">
      <ul class="nav navbar-nav ">
        <?php 
            $stmt = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach($rows as $cat){
                echo "<li><a href='categories.php?catID=". $cat['ID'] . "&catName=". str_replace(' ','-',$cat['Name']) ."'>". $cat['Name'] . "</a></li>";
            }
          ?>
      </ul>
    </div>
  </div>
</nav>