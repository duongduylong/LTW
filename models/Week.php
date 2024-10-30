<?php

class Week {

    private int $weekId;
    private int $weekName;
    private Datetime $startTime;
    private Datetime $endTime;

    // Constructor (optional for flexibility)
    public function __construct(int $weekId ,int  $weekName ,Datetime $startTime ,Datetime $endTime) {
        $this->weekId = $weekId;
        $this->weekName = $weekName;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    // Getters and Setters
    public function getWeekId() {
        return $this->weekId;
    }

 

    public function getWeekName() {
        return $this->weekName;
    }

    public function setWeekName($weekName) {
        $this->weekName = $weekName;
    }

    public function getStartTime() {
        return $this->startTime;
    }

    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    public function getEndTime() {
        return $this->endTime;
    }

    public function setEndTime($endTime) {
        $this->endTime = $endTime;
    }
}
?>