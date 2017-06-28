<?php

    function lang( $phrase ){
        
        static $lang = array(
            // Dashbar page
            'ADMIN' => 'الصفحة الرئيسية',
            'Categories' => 'الأقسام',
            'Comments'      => 'التعليقات',
            'Items'         => 'العناصر',
            'Members'       => 'الأعضاء',
            'Statistics'    => 'الإحصاء',
            'Visit_Shop'      => 'زيارة التسوق',
            'Edit_Profile' => 'تعديل الحساب',
            'Logout' => 'تسجيل الخروج',
            'Dashbord'          => 'القائمة الرئيسية',
            'Total_Members'     =>'جميع الأعضاء',
            'Pending_Members'   =>'الأعضاء المنتظرين',
            'Total_Items'       =>'جميع العناصر',
            'Total_Comments'    =>'جميع التعليقات',
            'Manage_Categories' =>'إدارة الأقسام',
            'Name'              =>'الاسم',
            'Description'       =>'التوصيف',
            'Ordering'          =>'الترتيب',
            'Visibility'        =>'متوفر',
            'Allow_Comment'     =>'التعليق ممكن',
            'Allow_Ads'         =>'الاعلان ممكن',
            'Control'           =>'التحكم',
            'Pending_Comments'  =>'التعليقات بانتظار التفعيل',
            'Manage_Comments'   =>'إدارة التعليقات',
            'Comment'           =>'التعليق',
            'Item_Name'         =>'اسم المنتج',
            'User_Name'         =>'اسم العميل',
            'Add_Date'          =>'تاريخ الإضافة',
            'Price'             =>'السعر',
            'Status'            =>'الحالة',
            'Adding_Date'       =>'تاريخ الإضافة',
            'Category'          =>'الفئة',
            'Owner'             =>'المالك',
            'Manage_Items'      =>'إدارة المنتجات',
            'Pending_Items'     =>'المنتجات بانتظار التفعيل',
            'Manage_Items'      =>'إدارة المنتجات',
            'Pending_Items'     =>'المنتجات بانتظار التفعيل',
            'Manage_Members'    =>'إداة الأعضاء',
            'Pending_Members'   =>'الأعضاء بانتظار التفعيل',
            'Username'          =>'اسم المستخدم',
            'Email'             =>'الايميل',
            'Full_Name'         =>'الاسم الكامل',
            'Registration_Date' =>'تاريخ التسجيل'    
        );
        
        return $lang[$phrase];
    }
?>
