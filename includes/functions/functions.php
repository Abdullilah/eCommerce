<?php
    
    function getTitle(){
        global $pageTitle;
        if(isset($pageTitle)){
            echo $pageTitle;
        } else{
            echo "Defult";
        }
    }
    
    /* Function for all calling From the Database */
//    function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderField, $ordering = 'DESC'){
//        global $con;
//        $getAll = $con-> prepare("SELECT $field FROM $table $where $and ORDER BY $orderField $ordering");
//        $getAll -> execute();
//        $all = $getAll -> fetchAll();
//        return $all;
//    }
//    EX: getAllFrom('*', 'users', 'WHERE Username={}', 'AND Approve=1', 'userID', 'DESC')


    /*
        Redirect function to the Home page
        This function accep two values:
        1st: the error message
        2nd: the seconds before redirecting
    */
    function redirecting($title ='', $message, $secNum = 3, $url = null, $class){
        if($url == null){
            $url = 'index.php';
//        } else{ //To redirect to the previous page if it is founded
//            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
//                $url = $_SERVER['HTTP_REFERER'];
//            } else{
//                $url = 'index.php';
//            }
        }
        echo "<h1 class='text-center'>$title</h1>";
        echo "<div class='container'>";
            echo "<div class='text-center'>";
                echo "<div class='alert alert-$class'>$message</div>";
                echo "<div class='alert alert-info'>You will be redirected to the Home page after $secNum seconds</div>";
            echo "</div>";
        echo "</div>";
        header("refresh:$secNum;url=$url");
        exit();
    }

    /*
        Check if the item is in the database
        $select : the item which we want to select
        $from   : the table which contain the item
        $value  : the value which we want to catch
    */

    function checkItem($select, $from, $value){
        global $con;
        $statement = $con->prepare("SELECT $select FROM $from WHERE $select=?");
        $statement->execute(array($value));
        $count = $statement->rowCount();
        return $count;
    }

    /*
        Count the number of Rows in the database
    */
    function countMembers($item, $table, $where){
        global $con;
        $stmt = $con-> prepare("SELECT COUNT($item) FROM $table WHERE GroupID = 0 $where");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    function countItems($item, $table){
        global $con;
        $stmt = $con-> prepare("SELECT COUNT($item) FROM $table");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /* 
        Select the last items from the database
    */
    function getLatest($select, $table, $order, $limit = 5){
        global $con;
        $stmt = $con-> prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
?>