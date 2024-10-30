
<?php

require_once("User.php");

class Email {
  private int $emailId;  // Unique identifier for the email
  private User $user;    // User associated with the email
  private string $email;  // Email address

  public function __construct(int $emailId,User $user, string $email) {
    $this->emailId = $emailId;
    $this->user = $user;
    $this->email = $email;
  }

  public function getEmailId(): int {
    return $this->emailId;
  }

  public function getUser(): User {
    return $this->user;
  }

  public function getEmail(): string {
    return $this->email;
  }
}
?>