<?php

class Poll {

    function getQuestions($name) {
    	
    	global $_ADODB;
    	
		$poll['question'] = $_ADODB->GetAll("
			SELECT
				q.* 
			FROM 
				poll_question q, poll p 
			WHERE 
				p.name = 'opros_teorver' AND q.poll = p.id
			ORDER BY
				q.num
		");
		
		$answer = $_ADODB->GetAll("
			SELECT
				a.*
			FROM 
				poll_answer a, poll p 
			WHERE 
				p.name = 'opros_teorver' AND a.poll = p.id
			ORDER BY
				a.num
		");
		
		while (list($k, $v) = each($answer)) {
			$poll['answer'][$v['question']][] = $v;
		}
    	
    	return $poll;
    }
    
    function saveAnswers($poll_name, $answers, $uid, $ip = '') {

    	global $_ADODB;

		$values = '';
		$delim = '';
		$poll = $_ADODB->GetOne("SELECT id FROM poll WHERE name = '" . $poll_name . "'");
		while (list($q, $a) = each($answers)) {
			if (is_array($a)) {
				while (list(, $a1) = each($a)) {
					$values .= $delim . sprintf("('%d', INET_ATON('%s'), '%d', '%d', '%d')", $uid, $ip, $poll, $q, $a1);
					$delim = ',';
				}
			} else {
				$values .= $delim . sprintf("('%d', INET_ATON('%s'), '%d', '%d', '%d')", $uid, $ip, $poll, $q, $a);
				$delim = ',';
			}
		}
		
		if ($uid) {
			$_ADODB->Execute("
				INSERT
					poll_user (poll, uid, dt)
				VALUES
					(" . $poll . ", '" . addslashes($uid) . "', NOW())
				ON DUPLICATE KEY UPDATE
					dt = NOW()
			");
			$_ADODB->Execute("
				DELETE FROM
					poll_vote
				WHERE
					poll = " . $poll . " AND uid = " . $uid . "
			");
		} elseif ($ip) {
			$_ADODB->Execute("
				INSERT
					poll_ip (poll, ip, dt)
				VALUES
					(" . $poll . ", INET_ATON('" . addslashes($ip) . "'), NOW())
			");
		}
		
		$_ADODB->Execute("
			INSERT
				poll_vote (uid, ip, poll, question, answer)
			VALUES
				" . $values . "
		");
    	
    }
    
    function getResults($poll_name, $who = 'all', $id = '') {

    	global $_ADODB;

		switch ($who) {
			case 'user':
				if (!empty($id)) {
					$_where_id = " AND v.uid = " . $id;
				} else {
					$_where_id = " AND v.uid != 0";
				}
		    	$res = $_ADODB->GetAssoc("
					SELECT
						v.answer, COUNT(*) AS cnt
					FROM
						poll p, poll_vote v, poll_answer a
					WHERE
						p.name = '" . $poll_name . "' AND a.poll = p.id AND v.answer = a.id " . $_where_id . "
					GROUP BY
						v.answer
				");
				break;
			case 'ip':
		    	$res = $_ADODB->GetAssoc("
					SELECT
						v.answer, COUNT(*) AS cnt
					FROM
						poll p, poll_vote v, poll_answer a
					WHERE
						p.name = '" . $poll_name . "' AND a.poll = p.id AND v.answer = a.id AND v.uid = 0
					GROUP BY
						v.answer
				");
				break;
			default:
		    	$res = $_ADODB->GetAssoc("
					SELECT
						v.answer, COUNT(*) AS cnt
					FROM
						poll p, poll_vote v, poll_answer a
					WHERE
						p.name = '" . $poll_name . "' AND a.poll = p.id AND v.answer = a.id
					GROUP BY
						v.answer
				");
				break;
		}
		
		return $res;
    }
    
    function getVotesNum($poll_name, $who = 'all', $id = '') {
    	
    	global $_ADODB;
    	
    	$num = 0;
    	
    	if ($who == 'all') {
			$num += $_ADODB->GetOne("SELECT COUNT(*) FROM poll p, poll_user u WHERE p.name = '" . $poll_name . "' AND u.poll = p.id");    		
			$num += $_ADODB->GetOne("SELECT COUNT(*) FROM poll p, poll_ip a WHERE p.name = '" . $poll_name . "' AND a.poll = p.id");    		
    	}
    	
    	if ($who == 'user') {
    		if (!empty($id)) {
				$num += $_ADODB->GetOne("SELECT COUNT(*) FROM poll p, poll_user u WHERE p.name = '" . $poll_name . "' AND u.poll = p.id AND u.uid = '" . $id . "'");    		
    		} else {
				$num += $_ADODB->GetOne("SELECT COUNT(*) FROM poll p, poll_user u WHERE p.name = '" . $poll_name . "' AND u.poll = p.id");    		
    		}
    	}

    	if ($who == 'ip') {
    		if (!empty($id)) {
				$num += $_ADODB->GetOne("SELECT COUNT(*) FROM poll p, poll_ip a WHERE p.name = '" . $poll_name . "' AND a.poll = p.id AND a.ip = INET_ATON('" . addslashes($id) . "')");    		
    		} else {
				$num += $_ADODB->GetOne("SELECT COUNT(*) FROM poll p, poll_ip a WHERE p.name = '" . $poll_name . "' AND a.poll = p.id");    		
			}
    	}
    	
    	return $num;
    } 
}
?>