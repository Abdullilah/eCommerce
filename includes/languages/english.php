<?php

    function lang( $phrase ){
        
        static $lang = array(
            // Dashbar page
            'ADMIN'         => 'Home',
            'Categories'    => 'Categories',
            'Comments'      => 'Comments',
            'Items'         => 'Items',
            'Members'       => 'Members',
            'Statistics'    => 'Statistics',
            'Logs'          => 'Logs',
            'Edit_Profile'  => 'Edit Profile',
            'Settings'      => 'Settings',
            'Logout'        => 'Logout'
        );
        
        return $lang[$phrase];
    }
?>
