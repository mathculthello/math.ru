<?php
class Paginator {

    var $page;
    var $itemsPerPage;
    var $itemsPerPageOptions;
    var $itemsNumber;
    var $pagesPerScreen;
    var $order;
    var $orderBy;
    
    var $pagesNumber;
    var $pages;
    var $limit;
    var $nextPages;
    var $prevPages;
    
    var $itemsMessage;
    
    function Paginator($page = 1, $itemsPerPageOptions = array(0 => 'все', 10 => '10', 20 => '20', 50 => '50', 100 => '100'), $itemsPerPage = 10, $pagesPerScreen = 0, $order = 0, $orderBy = '') {
        if(empty($page)) 
            $this->page = 1;
        else
            $this->page = $page;
        $this->itemsPerPage = $itemsPerPage;
        $this->itemsPerPageOptions = $itemsPerPageOptions;
        $this->pagesPerScreen = $pagesPerScreen;
        $this->order = $order;
        $this->orderBy = $orderBy;
        
        if($this->itemsPerPage > 0)
            $this->limit = ' LIMIT '.($this->itemsPerPage*($this->page - 1)).','.$this->itemsPerPage;
        else
            $this->limit = '';
    }
    
    /**
    * @return void
    * @param unknown $itemsNumber
    * @desc sets overall items number 
    */
    function setItemsNumber($itemsNumber) {
        $this->itemsNumber = $itemsNumber;
        if($this->itemsPerPage >= $itemsNumber || $this->itemsPerPage == 0) {
            $this->itemsPerPage = 0;
            $this->pagesNumber = 1;
            $this->pages = array();
            $this->nextPages = 0;
            $this->prevPages = 0;
        } else {
            $this->pagesNumber = ceil($this->itemsNumber / $this->itemsPerPage);
            if($this->pagesNumber <= $this->pagesPerScreen) {
                $firstpage = 1;
                $lastpage = $this->pagesNumber;
                $this->nextPages = 0;
                $this->prevPages = 0;
            } else {
                if($this->page > $this->pagesPerScreen/2) {
                    $firstpage = $this->page - floor($this->pagesPerScreen/2);
                    $this->prevPages = $firstpage - 1;
                } else {
                    $firstpage = 1;
                    $this->prevPages = 0;
                }
                if($this->page < $this->pagesNumber - $this->pagesPerScreen/2) {
                    $lastpage = $this->page + floor($this->pagesPerScreen/2);
                    $this->nextPages = $lastpage + 1;
                } else {
                    $lastpage = $this->pagesNumber;
                    $this->nextPages = 0;
                }
            } 
            $this->pages = range($firstpage, $lastpage);
        }
    }
}
?>