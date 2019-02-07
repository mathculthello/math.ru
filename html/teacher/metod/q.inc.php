<?php
$forums = array(
	19 => 'Общие вопросы по математике',
	20 => 'Общие вопросы методики преподавания математики',
	21 => 'Методика углубленного и профильного обучения математике',
	22 => 'Подготовка к олимпиадам и конкурсам по математике',
	27 => 'Проведение выпускных и вступительных экзаменов',
	23 => 'Прочие вопросы',
);

$forums_translit = array(
	19 => 'Obshie voprosi po matematike',
	20 => 'Obshie voprosi prepodavaniya matematiki',
	21 => 'Metodika uglublennogo i profilnogo obucheniya matematike',
	22 => 'Podgotovka k olimpiadam i konkursam po matematike',
	27 => 'Provedeniye vipusknih i vstupitelnih ekzamenov',
	23 => 'Prochiye voprosi',
);

$_SMARTY->assign('forum_options', $forums);
$_SMARTY->assign('show_author_options', array('-1' => '', '1' => 'да', '0' => 'нет'));
?>
