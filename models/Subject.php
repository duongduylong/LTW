<?php
class Subject {
  private int $subjectId;
  private string $subjectCode;
  private string $subjectName;
  private int $credit;
  private int $priceCredit;

  public function __construct($subjectId,$subjectCode, $subjectName, $credit, $priceCredit) {
    $this->subjectId = $subjectId;
    $this->subjectCode = $subjectCode;
    $this->subjectName = $subjectName;
    $this->credit = $credit;
    $this->priceCredit = $priceCredit;
  }

  public function getSubjectId(): int {
    return $this->subjectId;
  }

  public function getSubjectCode(): string {
    return $this->subjectCode;
  }

  public function getSubjectName(): string {
    return $this->subjectName;
  }

  public function getCredit(): int {
    return $this->credit;
  }

  public function getPriceCredit(): int {
    return $this->priceCredit;
  }

}

?>