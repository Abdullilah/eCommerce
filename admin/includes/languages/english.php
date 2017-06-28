<?php

    function lang( $phrase ){
        
        static $lang = array(
            // Dashbar page
            'ADMIN'             => 'Home',
            'Categories'        => 'Categories',
            'Comments'          => 'Comments',
            'Items'             => 'Items',
            'Members'           => 'Members',
            'Edit_Profile'      => 'Edit Profile',
            'Visit_Shop'        => 'Visit Shop',
            'Logout'            => 'Logout',
            'Dashbord'          => 'Dashbord',
            'Total_Members'     =>'Total Members',
            'Pending_Members'   =>'Pending Members',
            'Total_Items'       =>'Total Items',
            'Total_Comments'    =>'Total Comments',
            'Manage_Categories' =>'Manage Categories',
            'Name'              =>'Name',
            'Description'       =>'Description',
            'Ordering'          =>'Ordering',
            'Visibility'        =>'Visibility',
            'Allow_Comment'     =>'Allow_Comment',
            'Allow_Ads'         =>'Allow_Ads',
            'Control'           =>'Control',
            'Pending_Comments'  =>'Pending Comments',
            'Manage_Comments'   =>'Manage Comments',
            'Comment'           =>'Comment',
            'Item_Name'         =>'Item Name',
            'User_Name'         =>'User Name',
            'Add_Date'          =>'Add Date',
            'Price'             =>'Price',
            'Status'            =>'Status',
            'Adding_Date'       =>'Adding Date',
            'Category'          =>'Category',
            'Owner'             =>'Owner',
            'Manage_Items'      =>'Manage Items',
            'Pending_Items'     =>'Pending Items',
            'Manage_Members'    =>'Manage Members',
            'Pending_Members'   =>'Pending Members',
            'Username'          =>'Username',
            'Email'             =>'Email',
            'Full_Name'         =>'Full Name',
            'Registration_Date' =>'Registration Date'          
        );
        
        return $lang[$phrase];
    }
?>
