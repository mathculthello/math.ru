<?php
require_once '../set_env.inc.php';
require_once 'Spreadsheet/Excel/Writer.php';
require_once '../../teacher/courses.inc.php';

$sql_where = array("1 = 1");
if (!empty($_GET['sch_year'])) {
	$sql_where[] .= "sch_year = '" . addslashes($_GET['sch_year']) . "'";
}
if (!empty($_GET['course'])) {
	$sql_where[] .= "course = '" . addslashes($_GET['course']) . "'";
}

$sql = "
	SELECT 
		* 
	FROM 
		user_mioo
	WHERE
		" . implode(" AND ", $sql_where) . "
	ORDER BY 
		lname
";
$mioo_user = $_ADODB->GetAll($sql);

switch ($_GET['format']) {
	case 'csv':
		$csv = '';
		while (list($k, $v) = each($mioo_user)) {
			$csv .= $v['lname'] . ";";
			$csv .=  $v['fname'] . ";";
			$csv .=  $v['sname'] . ";";
			$csv .=  $v['school_num'] . ";";
			$csv .=  $dist_options[$v['school_addr_dist']] . ";";
			$csv .=  $v['school_name'];
			$csv .= "\r\n";
		}
		header("Content-Disposition: attachment; filename=\"Курсы МИОО.csv\"");
		header("Content-type: application/csv");
		echo $csv;
		break;
	case 'xls':
		$workbook = new Spreadsheet_Excel_Writer();
		
		$workbook->send('Курсы МИОО.xls');
		
		$worksheet =& $workbook->addWorksheet('Курсы МИОО');
		
		$worksheet->setInputEncoding('cp1251');
		
		$worksheet->write(0, 0, 'Фамилия');
		$worksheet->write(0, 1, 'Имя');
		$worksheet->write(0, 2, 'Отчество');
		$worksheet->write(0, 3, 'Номер образовательного учреждения');
		$worksheet->write(0, 4, 'Округ');
		$worksheet->write(0, 5, 'Название образовательного учреждения');
		//var_dump($mioo_user);
		while (list($k, $v) = each($mioo_user)) {
			$worksheet->write($k + 1, 0, $v['lname']);
			$worksheet->write($k + 1, 1, $v['fname']);
			$worksheet->write($k + 1, 2, $v['sname']);
			$worksheet->write($k + 1, 3, $v['school_num']);
			$worksheet->write($k + 1, 4, $dist_options[$v['school_addr_dist']]);
			$worksheet->write($k + 1, 5, $v['school_name']);
		}
		
		$workbook->close();

}
?>
