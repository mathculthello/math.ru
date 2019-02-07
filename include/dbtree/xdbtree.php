<?php

/*
 * Created on 18.01.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

require_once 'database.php';
require_once 'dbtree.php';

class XDBTree extends CDBTree {

	var $adodb;

	/**
	 * The name of column in a Nested Sets table 
	 * specifying the order of sibling nodes.
	 * 
	 * Siblings could be ordered by the $left column 
	 * but in that case operation of moving nodes is much more comlicated.
	 * 
	 * @var string
	 */
	var $order = 'cat_order';

	function XDBTree(& $adodb, $tableName, $itemId, $fieldNames = array ()) {
		$db = new CDatabase($adodb->database, $adodb->host, $adodb->user, $adodb->password);
		$this->CDBTree($db, $tableName, $itemId, $fieldNames);
		$this->adodb = $adodb;
	}

	/**
	 * @param int $nodeId id of node to move
	 * @return int new value of $order column for moved node
	 * @access public
	 */
	function moveUp($nodeId) {
        $sql = 'SELECT t1.'.$this->parent.' AS parent, t1.'.$this->order.' AS ord, MAX(t2.'.$this->order.') AS neworder FROM '.$this->table.' t1,'.$this->table.' t2 WHERE t1.'.$this->id.'='.$nodeId.' AND t2.'.$this->parent.'=t1.'.$this->parent.' AND t2.'.$this->order.'<t1.'.$this->order.' GROUP BY t1.'.$this->id;
        if ($data = $this->adodb->GetRow($sql)) {
            $sql = 'UPDATE '.$this->table.' SET '.$this->order.'='.$data['ord'].' WHERE '.$this->parent.'='.$data['parent'].' AND '.$this->order.'='.$data['neworder'];
            $this->adodb->Execute($sql);
            $sql = 'UPDATE '.$this->table.' SET '.$this->order.'='.$data['neworder'].' WHERE id='.$nodeId;
            $this->adodb->Execute($sql);
        } else {
            // –аздел стоит выше всех среди своих соседей
            $sql = 'SELECT t1.'.$this->parent.' As parent, t2.'.$this->parent.' AS grandpa FROM '.$this->table.' t1,'.$this->table.' t2 WHERE t1.'.$this->id.'='.$nodeId;
            $data = $this->adodb->GetRow($sql); 
            if ($data['grandpa'])  {
                // ѕереносим его на уровень выше
                $this->moveAll($nodeId, $data['grandpa']);
                $this->moveBefore($nodeId, $data['parent']);
            }
        }
	}

	function moveDown($nodeId) {
		$sql = 'SELECT t1.'.$this->parent.' AS parent, t1.'.$this->order.' AS ord, MIN(t2.'.$this->order.') AS neworder FROM '.$this->table.' t1,'.$this->table.' t2 WHERE t1.'.$this->id.'='.$nodeId.' AND t2.'.$this->parent.'=t1.'.$this->parent.' AND t2.'.$this->order.'>t1.'.$this->order.' GROUP BY t1.'.$this->id;
		if ($data = $this->adodb->GetRow($sql)) {
			$sql = 'UPDATE '.$this->table.' SET '.$this->order.'='.$data['ord'].' WHERE '.$this->parent.'='.$data['parent'].' AND '.$this->order.'='.$data['neworder'];
			$this->adodb->Execute($sql);
			$sql = 'UPDATE '.$this->table.' SET '.$this->order.'='.$data['neworder'].' WHERE id='.$nodeId;
			$this->adodb->Execute($sql);
        } else {
            // –аздел стоит ниже всех среди своих соседей
            $sql = 'SELECT t1.'.$this->parent.' As parent, t2.'.$this->parent.' AS grandpa FROM '.$this->table.' t1,'.$this->table.' t2 WHERE t1.'.$this->id.'='.$nodeId;
            $data = $this->adodb->GetRow($sql); 
            if ($data['grandpa'])  {
                // ѕереносим его на уровень выше
                $this->moveAll($nodeId, $data['grandpa']);
                $this->moveAfter($nodeId, $data['parent']);
            }
        }
	}

    function moveBefore($node, $beforeNode) {
    }

    function moveAfter($node, $afterNode) {
    }


    function insertAfter($ID, $data) {
        if(!(list($leftId, $rightId, $level, $parent) = $this->getNodeInfo($ID))) die("phpDbTree error: ".$this->db->error());

        // preparing data to be inserted
        if(sizeof($data)) {
            $fld_names = implode(',', array_keys($data)).',';
            $fld_values = '\''.implode('\',\'', array_values($data)).'\',';
        }
        $fld_names .= $this->parent.','.$this->left.','.$this->right.','.$this->level;
        $fld_values .= $parent.','.($rightId+1).','.($rightId+2).','.($level);

        // creating a place for the record being inserted
        if($ID) {
            $this->sql = 'UPDATE IGNORE '.$this->table.' SET '
                . $this->left.'=IF('.$this->left.'>'.$rightId.','.$this->left.'+2,'.$this->left.'),'
                . $this->right.'='.$this->right.'+2 '
                . 'WHERE '.$this->right.'>'.$rightId;
            if(!($this->db->query($this->sql))) die("phpDbTree error: ".$this->db->error());
        }

        // inserting new record
        $this->sql = 'INSERT INTO '.$this->table.'('.$fld_names.') VALUES('.$fld_values.')';
        if(!($this->db->query($this->sql))) die("phpDbTree error: ".$this->db->error());

        return $this->db->insert_id();
    }

    function insertBefore($ID, $data) {
        if(!(list($leftId, $rightId, $level, $parent) = $this->getNodeInfo($ID))) die("phpDbTree error: ".$this->db->error());

        // preparing data to be inserted
        if(sizeof($data)) {
            $fld_names = implode(',', array_keys($data)).',';
            $fld_values = '\''.implode('\',\'', array_values($data)).'\',';
        }
        $fld_names .= $this->parent.','.$this->left.','.$this->right.','.$this->level;
        $fld_values .= $parent.','.($leftId).','.($leftId+1).','.($level);

        // creating a place for the record being inserted
        if($ID) {
            $this->sql = 'UPDATE IGNORE '.$this->table.' SET '
                . $this->left.'=IF('.$this->left.'>='.$leftId.','.$this->left.'+2,'.$this->left.'),'
                . $this->right.'='.$this->right.'+2 '
                . 'WHERE '.$this->right.'>='.$rightId.' OR '.$this->left.'>='.$leftId;
            if(!($this->db->query($this->sql))) die("phpDbTree error: ".$this->db->error());
        }

        // inserting new record
        $this->sql = 'INSERT INTO '.$this->table.'('.$fld_names.') VALUES('.$fld_values.')';
        if(!($this->db->query($this->sql))) die("phpDbTree error: ".$this->db->error());

        return $this->db->insert_id();
    }

}
?>
