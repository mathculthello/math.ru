<?php
require_once '../set_env.inc.php';
require_once 'courses.inc.php';
//$_ADODB->debug=true;
if (!$_LU->isLoggedIn()) {
	exit;
}

if (isset($_GET['id']) && $_user_status == 'user') {
	exit;
}

if (isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	$id = $_user_id;
}

$sql = "SELECT m.*, u.email FROM user_mioo m, user u WHERE m.id = " . $id . " AND u.id = m.id"; 
$data = $_ADODB->GetRow($sql);

$anketa = file_get_contents('anketa.rtf');

$data['it'] = array();
if ($data['it_internet']) {
	$data['it'][] = 'Интернет';
}
if ($data['it_email']) {
	$data['it'][] = 'Электронная почта';
}
if ($data['it_learning']) {
	$data['it'][] = 'Использую в своем предмете';
}

$search_replace = array(
'@@fio@@' => $data['lname'] . ' ' . $data['fname'] . ' ' . $data['sname'],
'@@birthday@@' => date('d.m.Y', strtotime($data['birthdate'])),
'@@passport@@' => ( 
$data['document'] == 'passport' ? 
'Паспорт ' . $data['passport_ser'] . ' ' . $data['passport_num'] . ' выдан ' . $data['passport_day'] . '.' . $data['passport_month'] . '.' . $data['passport_year'] . ' ' . $data['passport_org'] . ' ' . $data['passport_orgcode1'] . '-' . $data['passport_orgcode2'] . ' ' . $data['passport_orgname'] :
($data['document'] == 'other' ? $data['passport_type'] : '') . ' ' . $data['passport_sernum']. ' выдан ' . $data['passport_other_org'] . ' ' . $data['passport_other_day'] . '.' . $data['passport_other_month'] . '.' . $data['passport_other_year']
),
'@@edu@@' => $edu_options[$data['edu']],
'@@edu_school@@' => $data['edu_school'],
'@@edu_spec@@' => $data['edu_spec'],
'@@edu_qual@@' => $data['edu_qual'],
'@@sex@@' => ($data['sex'] == 'm' ? 'М' : 'Ж'),
'@@school@@' => $school_options[$data['school_type']] . ' ' . $data['school_num'] . ' ' . $data['school_name'],
'@@school_addr@@' => $data['school_addr_zip'] . ' ' . $data['school_addr_city'] . ' ' . $data['school_addr_txt'] . ' ' . $dist_options[$data['school_addr_dist']],
'@@school_pos@@' => $data['school_pos'],
'@@school_exp_teacher@@' => $data['school_exp_teacher'],
'@@school_exp_director@@' => $data['school_exp_director'],
'@@school_cat_num@@' => $data['school_cat_num'],
'@@school_lastcourse_subj@@' => $data['school_lastcourse_subj'],
'@@school_lastcourse_period@@' => $data['school_lastcourse_period'],
'@@school_lastcourse_place@@' => $data['school_lastcourse_place'],
'@@school_lastcourse_doc@@' => $data['school_lastcourse_doc'],
'@@school_courses@@' => $data['school_courses'],
'@@school_met@@' => $data['school_met'],
'@@school_exp@@' => $data['school_exp'],
'@@school_met_role@@' => $data['school_met_role'],
'@@contact_phone@@' => $data['contact_phone'],
'@@work_phone@@' => $data['work_phone'],
'@@mobile_phone@@' => $data['mobile_phone'],
'@@email@@' => $data['email'],
'@@degree@@' => $degree_options[$data['degree']],
'@@rank@@' => $data['rank'],
'@@zaslugi@@' => $data['zaslugi'],
'@@nagrady@@' => $data['nagrady'],
'@@konkursy@@' => $data['konkursy'],
'@@it@@' => implode(',', $data['it']),
'@@extra_info@@' => $data['extra_info'],

);

$anketa = str_replace(array_keys($search_replace), array_values($search_replace), $anketa); 

header('Content-Type: text/rtf');
header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Content-Disposition: attachment; filename=anketa.rtf');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');  

echo $anketa;
?>
