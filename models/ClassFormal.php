<?php
require_once("Branch.php");
class ClassFormal {
  private int $classFormalId;
  private int $classNumber;  // Đã sửa tên biến thành classNumber
  private Branch $department;
  private int $classCourse;
  private int $teacherId;

  public function __construct(
      int $classFormalId, 
      int $classNumber, 
      int $classCourse,
      Branch $department,
      int $teacherId
  ) {
    $this->classFormalId = $classFormalId;
    $this->classNumber = $classNumber;
    $this->department = $department;
    $this->classCourse = $classCourse;
    $this->teacherId = $teacherId;
  }

  public function getClassFormalId(): int {
    return $this->classFormalId;
  }

  public function getClassNumber(): int {  // Đã sửa tên hàm thành getClassNumber
    return $this->classNumber;
  }

  public function getBranch(): Branch{
    return $this->department;
  }

  public function getClassCourse(): int {
    return $this->classCourse;
  }
  public function getTeacherId(): int {
    return $this->teacherId;
  }

}

?>
