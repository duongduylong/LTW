<?php
require_once ("ClassFormal.php");
class User
{
  private int $userId;
  private ClassFormal $classFormal;
  private string $userName;
  private string $passWord; // Consider using a hashed password for security
  private string $fullName;

  private int $userRole;
  private int $status;
  private string $dateOfBirth;
  private int $gender;
  private string $birthplace;
  private string $currentAddress;
  private string $avatarImagePath;
  private string $linkSocial;
  private string $descriptionText;
  private int $passwordLatest;
  private int $passwordLatestTime;
  private int $loginFailed = 0;

  public function __construct(
    int $userId,
    ClassFormal $classFormal,
    string $userName,
    string $passWord,
    string $fullName,

    int $userRole,
    int $status,
    string $dateOfBirth,
    int $gender,
    string $birthplace,
    string $currentAddress,
    string $avatarImagePath = "",
    string $linkSocial = "",        // Optional default value
    string $descriptionText = ""   // Optional default value
  ) {
    $this->userId = $userId;

    $this->classFormal = $classFormal;
    $this->userName = $userName;
    $this->passWord = $passWord;
    $this->fullName = $fullName;

    $this->userRole = $userRole;
    $this->status = $status;
    $this->dateOfBirth = $dateOfBirth;
    $this->gender = $gender;
    $this->birthplace = $birthplace;
    $this->currentAddress = $currentAddress;
    $this->avatarImagePath = $avatarImagePath;
    $this->linkSocial = $linkSocial;
    $this->descriptionText = $descriptionText;
  }


  // Getter methods
  public function getUserId(): int
  {
    return $this->userId;
  }
  public function getPassWord(): string
  {
    return $this->passWord;
  }



  public function getClassFormal(): ClassFormal
  {
    return $this->classFormal;
  }

  public function getUserName(): string
  {
    return $this->userName;
  }


  public function getFullName(): string
  {
    return $this->fullName;
  }


  public function getUserRole(): int
  {
    return $this->userRole;
  }

  public function getStatus(): string
  {
    return $this->status;
  }

  public function getDateOfBirth(): string
  {
    return $this->dateOfBirth;
  }

  public function getGender(): string
  {
    return $this->gender;
  }

  public function getBirthplace(): string
  {
    return $this->birthplace;
  }

  public function getCurrentAddress(): string
  {
    return $this->currentAddress;
  }

  public function getAvatarImagePath(): string
  {
    return $this->avatarImagePath;
  }

  public function getLinkSocial(): string
  {
    return $this->linkSocial;
  }

  public function getDescriptionText(): string
  {
    return $this->descriptionText;
  }

  public function getPasswordLatest(): ?string
  {
    return $this->passwordLatest;
  }

  public function getPasswordLatestTime(): int
  {
    return $this->passwordLatestTime;
  }

  public function getLoginFailed(): int
  {
    return $this->loginFailed;
  }
  public function setPassWord($newpassword)
  {
    $this->passWord = $newpassword;
  }
  public function setUserName($newpassword)
  {
    $this->userName = $newpassword;
  }
  public function setUserRole($newpassword)
  {
    $this->userRole = $newpassword;
  }
  public function setFullName(string $fullName): void
  {
    $this->fullName = $fullName;
  }


  public function setStatus(int $status): void
  {

    $this->status = $status;
  }

  public function setDateOfBirth(string $dateOfBirth): void
  {

    $this->dateOfBirth = $dateOfBirth;
  }

  public function setGender(int $gender): void
  {


    $this->gender = $gender;
  }

  public function setBirthplace(string $birthplace): void
  {
    $this->birthplace = $birthplace;
  }

  public function setCurrentAddress(string $currentAddress): void
  {
    $this->currentAddress = $currentAddress;
  }

  public function setAvatarImagePath(string $avatarImagePath): void
  {

    $this->avatarImagePath = $avatarImagePath;
  }

  public function setLinkSocial(string $linkSocial): void
  {

    $this->linkSocial = $linkSocial;
  }
}



?>