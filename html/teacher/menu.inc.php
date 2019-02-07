<?php
$_menu = array(
    array('path' => '/teacher/doc/', 'title' => 'Документы'),
    array('path' => '/teacher/metod/', 'title' => 'Методические консультации'),
    array('path' => '/teacher/db/', 'title' => 'База данных методических материалов'),
    array('path' => '/teacher/consp/', 'title' => 'Конспекты разработок&nbsp;уроков'),
    array('path' => '/teacher/article/', 'title' => 'Статьи'),
//    array('path' => '/teacher/iso/', 'title' => 'Педагогические инициативы. Проект ИСО'),
    array('path' => '/teacher/insem/', 'title' => 'Интернет семинар'),
    array('path' => '/teacher/conf/', 'title' => 'Семинары и конференции'),
    array('path' => '/teacher/profile/', 'title' => 'Профильное обучение'),
);
$_courses_menu = array(
    array('path' => '/teacher/courses.php', 'title' => 'Регистрация'),
);
$_SMARTY->assign('_courses_menu', $_courses_menu);
$_SMARTY->assign('_menu', $_menu);

?>