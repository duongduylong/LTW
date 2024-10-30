<?php

require_once("Subject.php");
require_once("Branch.php");

class SubjectSemester {
  private int $subjectSemesterId;     // Unique identifier for the subject semester
  private string $subjectSemesterName; // Name of the semester (e.g., Spring 2024)
  private Subject $subject;           // The associated subject
  private Branch $department;     // The department offering the subject

  public function __construct(int $subjectSemesterId,string $subjectSemesterName, Subject $subject, Branch $department) {
    $this->subjectSemesterId = $subjectSemesterId;
    $this->subjectSemesterName = $subjectSemesterName;
    $this->subject = $subject;
    $this->department = $department;
  }

  public function getSubjectSemesterId(): int {
    return $this->subjectSemesterId;
  }

  public function getSubjectSemesterName(): string {
    return $this->subjectSemesterName;
  }

  public function getSubject(): Subject {
    return $this->subject;
  }

  public function getBranch(): Branch {
    return $this->department;
  }

  // Optional setter methods (consider adding if needed)
  public function setSubjectSemesterId(int $subjectSemesterId): void {
    $this->subjectSemesterId = $subjectSemesterId;
  }

  public function setSubjectSemesterName(string $subjectSemesterName): void {
    $this->subjectSemesterName = $subjectSemesterName;
  }

  public function setSubject(Subject $subject): void {
    $this->subject = $subject;
  }

 
}

?>