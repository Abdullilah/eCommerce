<?php

    function lang( $phrase ){
        
        static $lang = array(
            // Dashbar page
            'ADMIN' => 'الصفحة الرئيسية',
            'Categories' => 'الأقسام',
            'Items'         => 'العناصر',
            'Members'       => 'الأعضاء',
            'Statistics'    => 'الإحصاء',
            'Logs'          => 'التسجيل',
            'Edit_Profile' => 'تعديل',
            'Settings' => 'الإعدادات',
            'Logout' => 'تسجيل الخروج'
        );
        
        return $lang[$phrase];
    }
?>
