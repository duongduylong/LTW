<?php

class ClassRoom {
  private int $classRoomId;
  private string $classRoomName;
  private string $building;

  public function __construct(int $classRoomId, string $classRoomName, string $building) {
    $this->classRoomId = $classRoomId;
    $this->classRoomName = $classRoomName;
    $this->building = $building;
  }

  public function getClassRoomId(): int {
    return $this->classRoomId;
  }

  public function getClassRoomName(): string {
    return $this->classRoomName;
  }

  public function getBuilding(): string {
    return $this->building;
  }
}

?>