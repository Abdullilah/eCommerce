<?php
    
    $do = '';
    if(isset($_GET['do'])){
        $do = $_GET['do'];
    } else{
        $do = 'Manage';
    }
    
    if($do == 'Manage'){
        echo "Welcome in Manage";
    } elseif($do == 'Add'){
        echo "Welcome in Add<br>";
        echo "<a href='page.php?do=Insert'>+</a>";
    } elseif($do == 'Insert'){
        echo "Welcome in Insert";
    } elseif($do == 'Delete'){
        echo "Welcome in Delete";
    } else{
        echo "There is no like this page";
    }

?>