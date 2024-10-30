<?php 
require_once("Department.php");
class Branch {

private $branchId;
private $branchCode;
private $branchName;
private Department $departmentId;

public function __construct($branchId, $branchCode, $branchName,  Department $departmentId) {
    $this->branchId = $branchId;
    $this->branchCode = $branchCode;
    $this->branchName = $branchName;
    $this->departmentId = $departmentId;
}

public function getBranchId() {
    return $this->branchId;
}

public function setBranchId($branchId) {
    $this->branchId = $branchId;
}

public function getBranchCode() {
    return $this->branchCode;
}

public function setBranchCode($branchCode) {
    $this->branchCode = $branchCode;
}

public function getBranchName() {
    return $this->branchName;
}

public function setBranchName($branchName) {
    $this->branchName = $branchName;
}

public function getDepartmentId(): Department {
    return $this->departmentId;
}}


?>
