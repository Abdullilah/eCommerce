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
      <a class="navbar-brand" href="dashbord.php?lang=<?php echo $_SESSION['Languages']; ?>"><?php echo lang('ADMIN'); ?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php?lang=<?php echo $_SESSION['Languages']; ?>"><?php echo lang('Categories'); ?></a></li>
        <li><a href="items.php?lang=<?php echo $_SESSION['Languages']; ?>"><?php echo lang('Items'); ?></a></li>
        <li><a href="members.php?lang=<?php echo $_SESSION['Languages']; ?>"><?php echo lang('Members'); ?></a></li>
        <li><a href="comments.php?lang=<?php echo $_SESSION['Languages']; ?>"><?php echo lang('Comments'); ?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['Username'] ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=Edit&userID=<?php echo $_SESSION['ID'];?>"><?php echo lang('Edit_Profile'); ?></a></li>
            <li><a href="../index.php"><?php echo lang('Visit_Shop'); ?></a></li>
            <li><a href="logout.php"><?php echo lang('Logout'); ?></a></li>
          </ul>
        </li>
        <li>
            <div class="flags">
                <a href="dashbord.php?lang=english"><img src="layout/images/en.png"></a>
                <a href="dashbord.php?lang=arabic"><img src="layout/images/ar.jpg"></a>
            </div>
        </li>
      </ul>
      
        
    </div>
  </div>
</nav>