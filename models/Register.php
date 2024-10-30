<?php

require_once("ClassCredit.php");
require_once("User.php");

class Register {
  private int $registerId;      // Unique identifier for the registration
  private ClassCredit $classCredit; // The credit class for which the registration is made
  private User $user;           // The user who registered
  private DateTime $registerTime;  // The date and time of registration

  public function __construct(int $registerId,ClassCredit $classCredit, User $user, DateTime $registerTime) {
    $this->registerId = $registerId;
    $this->classCredit = $classCredit;
    $this->user = $user;
    $this->registerTime = $registerTime;
  }

  public function getRegisterId(): int {
    return $this->registerId;
  }

  public function getClassCredit(): ClassCredit {
    return $this->classCredit;
  }

  public function getUser(): User {
    return $this->user;
  }

  public function getRegisterTime(): DateTime {
    return $this->registerTime;
  }

  // Setter methods (optional, enable if needed for your application)
  public function setRegisterId(int $registerId): void {
    $this->registerId = $registerId;
  }

  public function setClassCredit(ClassCredit $classCredit): void {
    $this->classCredit = $classCredit;
  }

  public function setUser(User $user): void {
    $this->user = $user;
  }

  public function setRegisterTime(DateTime $registerTime): void {
    $this->registerTime = $registerTime;
  }
}

?>