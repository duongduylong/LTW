<?php

class Department {
  private int $departmentId; // Unique identifier (integer)
  private string $departmentCode; // Department code (string)
  private string $departmentName; // Department name (string)

  public function __construct(int $departmentId,string $departmentCode, string $departmentName) {
    $this->departmentId = $departmentId;
    $this->departmentCode = $departmentCode;
    $this->departmentName = $departmentName;

  }

  public function getDepartmentId(): int {
    return $this->departmentId;
  }

  public function getDepartmentCode(): string {
    return $this->departmentCode;
  }

  public function getDepartmentName(): string {
    return $this->departmentName;
  }

  

  // Optional setter methods (consider adding if needed)
  public function setDepartmentId(int $departmentId): void {
    $this->departmentId = $departmentId;
  }

  public function setDepartmentCode(string $departmentCode): void {
    $this->departmentCode = $departmentCode;
  }

  public function setDepartmentName(string $departmentName): void {
    $this->departmentName = $departmentName;
  }

}
