<?php

require_once("User.php");

class PhoneNumber {
  private int $phoneNumberId;   // Unique identifier for the phone number
  private User $user;           // User associated with the phone number
  private string $phoneNumber;  // Phone number (represented as a string for flexibility)

  public function __construct(int $phoneNumberId,User $user, string $phoneNumber) {
    $this->phoneNumberId = $phoneNumberId;
    $this->user = $user;
    $this->phoneNumber = $phoneNumber;
  }

  public function getPhoneNumberId(): int {
    return $this->phoneNumberId;
  }

  public function getUser(): User {
    return $this->user;
  }

  public function getPhoneNumber(): string {
    return $this->phoneNumber;
  }

  // Setter methods (consider adding if needed for your specific use cases)
  public function setPhoneNumberId(int $phoneNumberId): void {
    $this->phoneNumberId = $phoneNumberId;
  }

  public function setUser(User $user): void {
    $this->user = $user;
  }

  public function setPhoneNumber(string $phoneNumber): void {
    $this->phoneNumber = $phoneNumber;
  }
}

?>