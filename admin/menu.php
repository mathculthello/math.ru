<?php
require_once 'set_env.inc.php';
if ($_user_status == 'editor')
{
$_menu = array (
array (
    'title' => 'Библиотека',
    'items' => array (
        array('path' => 'lib/book_list.php?all=1', 'title' => 'Книги'),
        array('path' => 'history/person_list.php?all=1', 'title' => 'Авторы'),
//        array('path' => 'lib/ad_list.php?all=1', 'title' => 'Ссылки'),
    ),
),
array ( 
    'title' => 'Пользователь '.$_user_login,
    'items' => array (
        array('path' => '/auth/profile.php', 'title' => 'Персональная информация', 'target' => '_top'),
        array('path' => '/auth/login.php?logout=1', 'title' => 'Выход', 'target' => '_top'),
    ),
),
);

} elseif ($_user_status == 'dic_editor') {
$_menu = array (
array (
    'title' => 'Словарь',
    'items' => array (
        array('path' => 'dic/term_list.php?all=1', 'title' => 'Понятия'),
        array('path' => 'dic/term_list.php?type=fact', 'title' => 'Факты'),
        array('path' => 'dic/term_list.php?type=formula', 'title' => 'Формулы'),
        array('path' => 'dic/src_list.php?all=1', 'title' => 'Источники'),
    ),
)
);
} elseif ($_user_status == 'teacher_editor') {
$_menu = array (
array (
    'title' => 'Учительская',
    'items' => array (
        array('path' => 'teacher/question_list.php', 'title' => 'Вопросы'),
        array('path' => 'teacher/mioo_list.php', 'title' => 'Курсы МИОО'),
        array('path' => 'teacher/doc_list.php', 'title' => 'Документы'),
        array('path' => 'teacher/article_list.php', 'title' => 'Статьи'),
        array('path' => '/forum/admin/', 'title' => 'Администрирование форума', 'target' => '_top'),
        array('path' => '/auth/login.php?logout=1', 'title' => 'Выход', 'target' => '_top'),
    ),
)
);

} else {
$_menu = array (
array (
    'title' => 'Словарь',
    'items' => array (
        array('path' => 'dic/term_list.php?all=1', 'title' => 'Понятия'),
        array('path' => 'dic/term_list.php?type=fact', 'title' => 'Факты'),
        array('path' => 'dic/term_list.php?type=formula', 'title' => 'Формулы'),
        array('path' => 'dic/src_list.php?all=1', 'title' => 'Источники'),
    ),
),
array (
    'title' => 'Библиотека',
    'items' => array (
        array('path' => 'lib/book_list.php?all=1', 'title' => 'Книги'),
        array('path' => 'history/person_list.php?all=1', 'title' => 'Авторы'),
        array('path' => 'lib/series_list.php', 'title' => 'Серии книг'),
        array('path' => 'lib/rubr_list.php', 'title' => 'Рубрикатор'),
        array('path' => 'lib/catalog_list.php', 'title' => 'ТК'),
        array('path' => 'lib/suggest_list.php', 'title' => '"Обратная связь"'),
//        array('path' => 'lib/ad_list.php?all=1', 'title' => 'Ссылки'),
        array('path' => 'cd/', 'title' => 'CD'),
        array('path' => 'lib/ilib_contents.php', 'title' => 'Содержания'),
    ),
),
array (
    'title' => 'Медиатека',
    'items' => array (
        array('path' => 'media/lecture_list.php?all=1', 'title' => 'Видео лекции'),
    ),
),
array (
    'title' => 'История математики',
    'items' => array (
        array('path' => 'history/person_list.php?mode=person', 'title' => 'Люди'),
        array('path' => 'history/story_list.php', 'title' => 'Сюжеты'),
        array('path' => 'history/tree.php', 'title' => 'Древо Лузина'),
        array('path' => 'history/tree_new.php', 'title' => 'Добавления'),
        array('path' => 'history/tree_edit.php', 'title' => 'Изменения'),
    ),
),
array (
    'title' => 'Учительская',
    'items' => array (
        array('path' => 'teacher/question_list.php', 'title' => 'Вопросы'),
        array('path' => 'teacher/mioo_list.php', 'title' => 'Курсы МИОО'),
        array('path' => 'teacher/doc_list.php', 'title' => 'Документы'),
        array('path' => 'teacher/cat_list.php', 'title' => 'Разделы'),
        array('path' => 'teacher/article_list.php', 'title' => 'Статьи'),
    ),
),
//array (
//    'title' => 'База задач',
//    'items' => array (
//        array('path' => 'pb/problems_list.php?all=1', 'title' => 'Задачи problems.ru'),
//        array('path' => 'section_tree.php', 'title' => 'Разделы'),
//        array('path' => 'subject_tree.php', 'title' => 'Тематический каталог'),
//        array('path' => 'pb_message_list.php', 'title' => 'Форум'),
//    ),
//),
array (
    'title' => 'TeX',
    'items' => array (
        array('path' => 'tex2png/tex2png.php', 'title' => 'TeX->png'),
        array('path' => 'tex2mathml.php', 'title' => 'TeX->MathML'),
    ),
),

array ( 
    'title' => 'Сайт',
    'items' => array (
        array('path' => 'auth/user_list.php?all=1', 'title' => 'Пользователи'),
        array('path' => 'news/', 'title' => 'Новости'),
        array('path' => '/', 'title' => 'Главная страница', 'target' => '_top'),
        array('path' => '/forum/admin/', 'title' => 'Администрирование форума', 'target' => '_top'),
    ),
),
array ( 
    'title' => 'Пользователь',
    'items' => array (
        array('path' => '/auth/profile.php', 'title' => 'Персональная информация', 'target' => '_top'),
        array('path' => '/auth/login.php?logout=1', 'title' => 'Выход', 'target' => '_top'),
    ),
),

);

}

$_SMARTY->assign('_menu', $_menu);
$_SMARTY->display('menu.tpl');
?>