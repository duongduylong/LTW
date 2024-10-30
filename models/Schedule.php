<?php

require_once("KipStudy.php");
require_once("Week.php");
require_once("ClassRoom.php");
class Schedule {
  private int $scheduleId; 
  private int $scheduleCode; // Unique identifier for the schedule entry
  private KipStudy $kipStudy;  // The associated study session
  private int $dayStudy; 
  private string $category; 
  private Week $week;
  private Week $weekEnd;
  private ClassRoom $classRoom;
     // Day of the week for the study session (consider using an enum for weekdays)

  public function __construct(int $scheduleId,int $scheduleCode, KipStudy $kipStudy, int $dayStudy,string $category,Week $week, Week $weekEnd,$classRoom) {
    $this->scheduleId = $scheduleId;
    $this->scheduleCode = $scheduleCode;
    $this->kipStudy = $kipStudy;
    $this->dayStudy = $dayStudy;
   $this->category = $category;
    $this->week = $week;
    $this->weekEnd=$weekEnd;
    $this->classRoom = $classRoom;
  }

  public function getScheduleId(): int {
    return $this->scheduleId;
  }
  public function getScheduleCode(): int {
    return $this->scheduleCode;
  }
  

  public function getKipStudy(): KipStudy {
    return $this->kipStudy;
  }
  public function getClassRoom(): ClassRoom {
    return $this->classRoom;
  }
  public function getWeek(): Week {
    return $this->week;
  }
  public function getWeekEnd(): Week {
    return $this->weekEnd;
  }

  public function getDayStudy(): int {
    return $this->dayStudy;
  }
  public function getCategory(): string {
    return $this->category;
  }


  // Optional setter methods (consider adding if needed)
  public function setScheduleId(int $scheduleId): void {
    $this->scheduleId = $scheduleId;
  }

  public function setKipStudy(KipStudy $kipStudy): void {
    $this->kipStudy = $kipStudy;
  }

  // Consider using an enum for dayStudy if you need strong type checking for weekdays
  public function setDayStudy(int $dayStudy): void {
    $this->dayStudy = $dayStudy;
  }
}

