<?php

class KipStudy {
  private int $kipStudyId;  // Unique identifier for the study session
  private DateTime $timeStart;  // Starting time of the study session
  private int $timeStudy;     // Duration of the study session in minutes (consider using a time interval for flexibility)

  public function __construct(int $kipStudyId, DateTime $timeStart, int $timeStudy) {
    $this->kipStudyId = $kipStudyId;
    $this->timeStart = $timeStart;
    $this->timeStudy = $timeStudy;
  }

  public function getKipStudyId(): int {
    return $this->kipStudyId;
  }

  public function getTimeStart(): DateTime {
    return $this->timeStart;
  }

  public function getTimeStudy(): int {
    return $this->timeStudy;
  }

  public function setKipStudyId(int $kipStudyId): void {
    $this->kipStudyId = $kipStudyId;
  }


  public function setTimeStudy(int $timeStudy): void {
    $this->timeStudy = $timeStudy;
  }
}
