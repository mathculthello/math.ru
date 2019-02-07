<?php
class User {

    var $status = 'UNCKNOWN';
    var $id = 0;
    var $login = '';
    var $db;
    var $table;

    function User($db, $table)
    {
        $this->db = $db;
        $this->table = $table;
//        session_start();
        if(isset($_SESSION['user']['status'])) {
            $this->status = $_SESSION['user']['status'];
        }
        if(isset($_SESSION['user']['id'])) {
            $this->id = $_SESSION['user']['id'];
        }        
        if(isset($_SESSION['user']['login'])) {
            $this->login = $_SESSION['user']['login'];
        }        
    }

    function login($login, $password)
    {
        $this->logout();

        $rs = $this->db->Execute('SELECT id,login,password,status FROM '.$this->table.' WHERE login=\''.$login.'\' AND password=\''.$password.'\'');
        $info = $rs->FetchRow();

        if(!$info) {
            $this->status = 'ERROR';
            return false;
        }
        $this->status = $info['status'];
        $this->id = $info['id'];
        $this->login = $info['login'];
        $_SESSION['user']['status'] = $info['status'];
        $_SESSION['user']['id'] = $info['id'];
        $_SESSION['user']['login'] = $info['login'];
        
        return true;
    }

    function logout()
    {
        unset($_SESSION['user']);
        $this->status = 'UNCKNOWN';
        $this->id = 0;
        $this->login = '';
    }    
    
    function exists($name) {
        $sql = 'SELECT id FROM '.$this->table.' WHERE login=\''.$name.'\'';
        $rs = $this->db->Execute($sql);
        if($rs->RecordCount() > 0)
            return true;
        return false;
    }
}
?>