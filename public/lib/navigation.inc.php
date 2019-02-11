<?php
$sql = 'SELECT c1.id, c1.pid, c1.path, c1.name, c1.lft, COUNT(*) AS level FROM lib_catalog c1, lib_catalog c2 WHERE c1.pid!=0 AND c1.lft BETWEEN c2.lft AND c2.rgt GROUP BY c1.id ORDER BY c1.lft';
$navigation['subjects'] = $_ADODB->GetAll($sql);
$sql = 'SELECT id, path, name FROM lib_rubr';
$navigation['rubricator'] = $_ADODB->GetAll($sql);
$sql = 'SELECT s.id,s.path,s.name,COUNT(b.id) AS cnt FROM lib_series s LEFT JOIN lib_book b ON b.series=s.id GROUP BY s.id ORDER BY s.ord';
$navigation['series'] = $_ADODB->GetAll($sql);
$navigation['types'] = array('book' => 'Книги', 'magazin' => 'Журналы', 'textbook' => 'Учебники', 'encycl' => 'Словари и энциклопедии');
$navigation['_menu'] = array(
    array('path' => '/lib/cat/', 'title' => 'Полный список'),
    array('path' => '/lib/search', 'title' => 'Поиск'),
    array('path' => '/lib/formats', 'title' => 'О форматах и правах'),
    array('path' => '/lib/suggest', 'title' => 'Обратная связь'),
    array('path' => '/lib/thanks', 'title' => 'Благодарности')
);
$navigation['rus_letters'] = array(
192 => 'А', 
193 => 'Б',
194 => 'В',
195 => 'Г',
196 => 'Д',
197 => 'Е',
198 => 'Ж',
199 => 'З',
200 => 'И',
202 => 'К',
203 => 'Л',
204 => 'М',
205 => 'Н',
206 => 'О',
207 => 'П',
208 => 'Р',
209 => 'С',
210 => 'Т',
211 => 'У',
212 => 'Ф',
213 => 'Х',
214 => 'Ц',
215 => 'Ч',
216 => 'Ш',
217 => 'Щ',
221 => 'Э',
222 => 'Ю',
223 => 'Я',
);
$navigation['lat_letters'] = array(
1065 => 'A',
1066 => 'B',
1067 => 'C',
1068 => 'D',
1069 => 'E',
1070 => 'F',
1071 => 'G',
1072 => 'H',
1073 => 'I',
1074 => 'J',
1075 => 'K',
1076 => 'L',
1077 => 'M',
1078 => 'N',
1079 => 'O',
1080 => 'P',
1081 => 'Q',
1082 => 'R',
1083 => 'S',
1084 => 'T',
1085 => 'U',
1086 => 'V',
1087 => 'W',
1088 => 'X',
1089 => 'Y',
1090 => 'Z',

);

if ($_GET['cd']) {
	while (list($k, $v) = each($navigation['rus_letters'])) {
		$navigation['rus_letters'][$k] = iconv('windows-1251', 'UTF-8', $v);
	}
	while (list($k, $v) = each($navigation['_menu'])) {
		$navigation['_menu'][$k] = iconv('windows-1251', 'UTF-8', $v);
	}
	while (list($k, $v) = each($navigation['types'])) {
		$navigation['types'][$k] = iconv('windows-1251', 'UTF-8', $v);
	}
	while (list($k, $v) = each($navigation['subjects'])) {
		while (list($k1, $v1) = each($navigation['subjects'][$k])) {
			$navigation['subjects'][$k][$k1] = iconv('windows-1251', 'UTF-8', $v1);
		}
	}
	while (list($k, $v) = each($navigation['rubricator'])) {
		while (list($k1, $v1) = each($navigation['rubricator'][$k]))
			$navigation['rubricator'][$k][$k1] = iconv('windows-1251', 'UTF-8', $v1);
	}
	while (list($k, $v) = each($navigation['series'])) {
		while (list($k1, $v1) = each($navigation['series'][$k])) {
			$navigation['series'][$k][$k1] = iconv('windows-1251', 'UTF-8', $v1);
		}
	}
}

$sql = 'SELECT DISTINCT p.letter,p.letter AS l FROM h_person p,lib_b2a a WHERE a.author=p.id';
$navigation['href_letters'] = $_ADODB->GetAssoc($sql);
?>