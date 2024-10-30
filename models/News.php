<?php
class News {
    private $newId;
    private $newTitle;
    private $newBody;
    private $newTime;

    public function __construct($newId, $newTitle, $newBody, $newTime){
        $this->newId = $newId;
        $this->newTitle = $newTitle;
        $this->newBody = $newBody;
        $this->newTime = $newTime;
    }

    public function getNewId(){
        return $this->newId;
    }
    public function getNewTitle(){
        return $this->newTitle;
    }
    public function getNewBody(){
        return $this->newBody;
    }
    public function getNewTime(){
        return $this->newTime;
    }


}
?>