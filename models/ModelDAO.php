<?php
require_once ("DAO.php");
require_once ('Branch.php');
require_once ('Department.php');
require_once ('ClassRoom.php');
require_once ('ClassCredit.php');
require_once ('ClassFormal.php');
require_once ('Email.php');
require_once ('KipStudy.php');
require_once ('PhoneNumber.php');
require_once ('Register.php');
require_once ('Schedule.php');
require_once ('News.php');
require_once ('Subject.php');
require_once ('SubjectSemester.php');
require_once ('User.php');
class ModelDepartment extends DAO
{

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM departments WHERE department_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return new Department(
          $result['department_id'],
          $result['department_code'],
          $result['department_name'],
        );

      }
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();
      return new Department(0, '1', '2');
    }

  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof Department) {
        $department = $object;
      }
      $sql = "INSERT INTO departments(department_code,department_name) VALUES (?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $department->getDepartmentCode(), PDO::PARAM_STR);
      $stmt->bindParam(2, $department->getDepartmentName(), PDO::PARAM_STR);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM departments WHERE department_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function updateObject($object): bool
  {
    try {
      if ($object instanceof Department) {
        $department = $object;
      }
      $sql = "UPDATE departments SET department_code = ?, department_name = ? WHERE department_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $department->getDepartmentCode(), PDO::PARAM_STR);
      $stmt->bindParam(2, $department->getDepartmentName(), PDO::PARAM_STR);
      $stmt->bindParam(3, $department->getDepartmentId(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
}



class ModelClassRoom extends DAO
{

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM class_rooms WHERE class_room_id = ?";
    try {

      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return new ClassRoom(
          $result['class_room_id'],
          $result['class_room_name'],
          $result['building'],
        );

      }
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }

  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof ClassRoom) {
        $classRoom = $object;
      }
      $sql = "INSERT INTO class_rooms(class_room_name,building) VALUES (?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $classRoom->getClassRoomName(), PDO::PARAM_STR);
      $stmt->bindParam(2, $classRoom->getBuilding(), PDO::PARAM_STR);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM class_rooms WHERE class_room_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function updateObject($object): bool
  {
    try {
      if ($object instanceof ClassRoom) {
        $classRoom = $object;
      }
      $sql = "UPDATE class_rooms SET class_room_name = ?, building = ? WHERE class_room_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $classRoom->getClassRoomName(), PDO::PARAM_STR);
      $stmt->bindParam(2, $classRoom->getBuilding(), PDO::PARAM_STR);
      $stmt->bindParam(3, $classRoom->getClassRoomId(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
}




class ModelClassCredit extends DAO
{
  public function getBySubject(int $name): array
  {
    $sql = "SELECT * FROM class_credits WHERE subject_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $name, PDO::PARAM_INT);

      $stmt->execute();
      $list = [];
      $modelListSchedule = new ModelSchedule();
      $modelSubject = new ModelSubject();

      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $listSchedule = $modelListSchedule->getByCode($result["schedule_code"]);
        $subject = $modelSubject->GetById($result["subject_id"]);


        array_push(
          $list,
          new ClassCredit(
            $result["class_credit_id"],
            $result["class_credit_name"],
            $subject,
            $result["group_class"],
            $listSchedule,
            $result["teacher_max"],
            $result["tutors_max"],
            $result["student_max"]

          )
        );
      }
      return $list;
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }

  }
  public function getAll (): array
  {
    $sql = "SELECT * FROM class_credits ORDER BY subject_id";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->execute();
      $list = [];
      $modelListSchedule = new ModelSchedule();
      $modelSubject = new ModelSubject();

      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $listSchedule = $modelListSchedule->getByCode($result["schedule_code"]);
        $subject = $modelSubject->GetById($result["subject_id"]);
        array_push(
          $list,
          new ClassCredit(
            $result["class_credit_id"],
            $result["class_credit_name"],
            $subject,
            $result["group_class"],
            $listSchedule,
            $result["teacher_max"],
            $result["tutors_max"],
            $result["student_max"]

          )
        );
      }
      return $list;
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }

  }

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM class_credits WHERE class_credit_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $modelSchedule = new ModelSchedule();
        $schedule = $modelSchedule->getByCode($result["schedule_code"]);
        $modelSubject = new ModelSubject();
        $subject = $modelSubject->GetById($result["subject_id"]);

        return new ClassCredit(
          $result["class_credit_id"],
          $result["class_credit_name"],
          $subject,
          $result["group_class"],
          $schedule,
          $result["teacher_max"],
          $result["tutors_max"],
          $result["student_max"]
        );

      }
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();
    }

  }


  public function addObject(object $object): bool
  {
    try {
      $name=$object->getClassCreditName();
      $subject=$object->getSubject()->getSubjectId();
      $groupclass=$object->getGroupClass();
      $schedule=$object->getListSchedule()[0]->getScheduleCode();
      $sql = "INSERT INTO class_credits (class_credit_name, subject_id, group_class, schedule_code) VALUES (?, ?, ?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $name, PDO::PARAM_STR);
      $stmt->bindParam(2, $subject, PDO::PARAM_INT);
      $stmt->bindParam(3, $groupclass, PDO::PARAM_INT);
      $stmt->bindParam(4, $schedule, PDO::PARAM_INT);

      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $modelRegister=new ModelRegister();
      $modelRegister->deleteByClassCredit($objectid);
      $sql = "DELETE FROM class_credits WHERE class_credit_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  
  public function updateObject($object): bool
  {
    try {
     
      $sql = "UPDATE class_credits SET class_credit_name = ?, subject_id = ?, group_class = ?, schedule_code = ?  WHERE class_credit_id = ?";
      $stmt = $this->link->prepare($sql);
      $name=$object->getClassCreditName();
      $subject=$object->getSubject()->getSubjectId();
      $groupclass=$object->getGroupClass();
      $schedule=$object->getListSchedule()[0]->getScheduleCode();
      $id=$object->getClassCreditId();
      $stmt->bindParam(1,  $name, PDO::PARAM_STR);
      $stmt->bindParam(2,$subject, PDO::PARAM_INT);
      $stmt->bindParam(3,$groupclass, PDO::PARAM_INT);
      $stmt->bindParam(4,  $schedule, PDO::PARAM_INT);
      $stmt->bindParam(5,$id , PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
    return false;
    }
  }
}


class ModelBranch extends DAO
{
  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM branchs WHERE branch_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $modelDepartment = new ModelDepartment();
        $department = $modelDepartment->getById($result["department_id"]);
        return new Branch(
          $result['branch_id'],
          $result['branch_code'],
          $result['branch_name'],
          $department

        );

      }
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();


    }

  }
  public function addObject(object $object): bool
  {

    return false;



  }
  public function deleteObject(int $objectid): bool
  {


    return false;


  }
  public function updateObject($object): bool
  {

    return false;

  }

}

class ModelClassFormal extends DAO
{

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM class_formals WHERE class_formal_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $modelBranch = new ModelBranch();
        $branch = $modelBranch->getById($result["branch_id"]);
        return new ClassFormal(
          $result['class_formal_id'],
          $result['class_number'],
          $result['class_course'],
          $branch,
          $result['teacher_id']
        );

      }
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();


    }

  }
  public function getAll(): array
  {
    $sql = "SELECT * FROM class_formals ";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->execute();
      $list = [];
      $modelBranch = new ModelBranch();
      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $branch = $modelBranch->getById($result["branch_id"]);
        array_push($list, new ClassFormal(
          $result['class_formal_id'],
          $result['class_number'],
          $result['class_course'],
          $branch,
          $result['teacher_id']
        )
        );

      }
      return $list;
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();


    }

  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof ClassFormal) {
        $classFormal = $object;
      }
      $sql = "INSERT INTO class_formals(class_number,class_course,branch_id, teacher_id) VALUES (?, ?, ?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $classFormal->getClassNumber(), PDO::PARAM_INT);
      $stmt->bindParam(2, $classFormal->getClassCourse(), PDO::PARAM_INT);
      $stmt->bindParam(3, $classFormal->getBranch()->getBranchId(), PDO::PARAM_INT);
      $stmt->bindParam(4, $classFormal->getTeacherId(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM class_formals WHERE class_formal_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function updateObject($object): bool
  {
    try {
      if ($object instanceof ClassFormal) {
        $classFormal = $object;
      }
      $sql = "UPDATE class_formals SET class_number = ?,  class_course = ? ,branch_id = ?, teacher_id= ? WHERE class_formal_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $classFormal->getClassNumber(), PDO::PARAM_INT);

      $stmt->bindParam(2, $classFormal->getClassCourse(), PDO::PARAM_INT);
      $stmt->bindParam(3, $classFormal->getBranch()->getBranchId(), PDO::PARAM_INT);
      $stmt->bindParam(4, $classFormal->getTeacherId(), PDO::PARAM_INT);
      $stmt->bindParam(5, $classFormal->getClassFormalId(), PDO::PARAM_INT);

      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
}

class ModelEmail extends DAO
{

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM emails WHERE email_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $modelUser = new ModelUser();
        $user = $modelUser->getById($result["user_id"]);
        return new Email(
          $result['email_id'],
          $user,
          $result['email'],
        );

      }
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();
    }

  }
  public function getByUserId(int $uid): object
  {
    $sql = "SELECT * FROM emails WHERE user_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $modelUser = new ModelUser();
        $user = $modelUser->getById($result["user_id"]);
        return new Email(
          $result['email_id'],
          $user,
          $result['email'],
        );

      }
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();
    }

  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof Email) {
        $email = $object;
      }
      $sql = "INSERT INTO emails(user_id,email) VALUES (?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $email->getUser()->getUserId(), PDO::PARAM_INT);
      $stmt->bindParam(2, $email->getEmail(), PDO::PARAM_STR);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM emails WHERE email_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function deleteByUserId(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM emails WHERE user_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function updateObject($object): bool
  {
    try {
      if ($object instanceof Email) {
        $email = $object;
      }
      $sql = "UPDATE emails SET user_id = ?, email = ? WHERE email_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $email->getUser()->getUserId(), PDO::PARAM_INT);
      $stmt->bindParam(2, $email->getEmail(), PDO::PARAM_STR);
      $stmt->bindParam(3, $email->getEmailId(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
}

class ModelKipStudy extends DAO
{

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM kip_studys WHERE kip_study_id = ?";
    try {
      // 2. Chuẩn bị câu lệnh sử dụng PDO
      $stmt = $this->link->prepare($sql);
      // 3. Gắn tham số một cách an toàn (ngăn chặn SQL injection)
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      // 4. Thực thi câu lệnh
      $stmt->execute();
      // 5. Lấy kết quả dưới dạng mảng kết hợp
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $timeStartObject = DateTime::createFromFormat('H:i:s', $result['time_start']);
        return new KipStudy(
          $result['kip_study_id'],
          $timeStartObject,
          $result['time_study'],
        );

      }
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();


    }

  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof KipStudy) {
        $kipStudy = $object;
      }
      $sql = "INSERT INTO kip_studys(time_start,time_study) VALUES (?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $kipStudy->getTimeStart(), PDO::PARAM_STR);
      $stmt->bindParam(2, $kipStudy->getTimeStudy(), PDO::PARAM_STR);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM kip_studys WHERE kip_study_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function updateObject($object): bool
  {
    try {
      if ($object instanceof KipStudy) {
        $kipStudy = $object;
      }
      $sql = "UPDATE kip_studys SET time_start = ?, time_study = ? WHERE kip_study_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $kipStudy->getTimeStart(), PDO::PARAM_STR);
      $stmt->bindParam(2, $kipStudy->getTimeStudy(), PDO::PARAM_STR);
      $stmt->bindParam(3, $kipStudy->getKipStudyId(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
}


class ModelPhoneNumber extends DAO
{

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM phone_numbers WHERE phone_number_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $modelUser = new ModelUser();
        $user = $modelUser->getById($result["user_id"]);
        return new PhoneNumber(
          $result['phone_number_id'],
          $user,
          $result['phone_number'],
        );

      }
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();
    }

  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof PhoneNumber) {
        $email = $object;
      }
      $sql = "INSERT INTO phone_numbers(user_id,phone_number) VALUES (?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $email->getUser()->getUserId(), PDO::PARAM_INT);
      $stmt->bindParam(2, $email->getPhoneNumberId(), PDO::PARAM_STR);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM phone_numbers WHERE phone_number_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function deleteByUserId(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM phone_numbers WHERE user_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function updateObject($object): bool
  {
    try {
      if ($object instanceof PhoneNumber) {
        $email = $object;
      }
      $sql = "UPDATE phone_numbers SET user_id = ?, phone_number = ? WHERE phone_number_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $email->getUser()->getUserId(), PDO::PARAM_INT);
      $stmt->bindParam(2, $email->getPhoneNumber(), PDO::PARAM_STR);
      $stmt->bindParam(3, $email->getPhoneNumberId(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
}
class ModelRegister extends DAO
{

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM registers WHERE register_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $modelUser = new ModelUser();
      $modelClassCredit = new ModelClassCredit();
      if ($result) {
        $user = $modelUser->getById($result["user_id"]);
        $classCredit = $modelClassCredit->getById($result["class_credit_id"]);
        return new Register(
          $result['register_id'],
          $classCredit,
          $user,
          DateTime::createFromFormat('Y-m-d H:i:s', $result['register_time'])
        );

      }
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();


    }

  }
  public function getAll(): array
  {
    $sql = "SELECT * FROM registers ORDER BY class_credit_id";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->execute();
      $list=[];
      $modelUser = new ModelUser();
      $modelClassCredit = new ModelClassCredit();
      while( $result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user = $modelUser->getById($result["user_id"]);
        $classCredit = $modelClassCredit->getById($result["class_credit_id"]);
        array_push($list,new Register(
          $result['register_id'],
          $classCredit,
          $user,
          DateTime::createFromFormat('Y-m-d H:i:s', $result['register_time'])
        ));

      }
      return $list;
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();


    }

  }

  public function getByUserId(int $uid): array
  {
    $sql = "SELECT * FROM registers WHERE user_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $list = [];
      $modelUser = new ModelUser();
      $modelClassCredit = new ModelClassCredit();
      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user = $modelUser->getById($result["user_id"]);
        $classCredit = $modelClassCredit->getById($result["class_credit_id"]);
        array_push($list, new Register(
          $result['register_id'],
          $classCredit,
          $user,
          DateTime::createFromFormat('Y-m-d H:i:s', $result['register_time'])
        )
        );

      }
      return $list;
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();


    }
  }
  public function getSvByClassCreditId(int $uid): array
  {
    $sql = "SELECT * FROM registers WHERE class_credit_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $list = [];
      $modelUser = new ModelUser();
      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user = $modelUser->getById($result["user_id"]);
        if ($user->getUserRole() == 1) {
          array_push($list, $user);
        }

      }
      return $list;
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();
    }

  }
  public function getTop3($id): array
  {
    $sql = "SELECT user_id,COUNT(class_credit_id) FROM registers GROUP BY user_id ORDER BY COUNT(class_credit_id) DESC";
    try {
      $stmt = $this->link->prepare($sql);
    
      $stmt->execute();
      $list = [];
      $modelUser = new ModelUser();
      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user = $modelUser->getById($result["user_id"]);
        if ($user->getUserRole() == $id) {
          array_push($list, [$user,$result["COUNT(class_credit_id)"]]);
        }

      }
      return $list;
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();
    }

  }


  public function getGvByClassCreditId(int $uid): array
  {
    $sql = "SELECT * FROM registers WHERE class_credit_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $list = [];
      $modelUser = new ModelUser();

      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user = $modelUser->getById($result["user_id"]);
        if ($user->getUserRole() == 3) {
          array_push($list, $user);
        }

      }
      return $list;
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();
    }

  }

  public function getTgByClassCreditId(int $uid): array
  {
    $sql = "SELECT * FROM registers WHERE class_credit_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $list = [];
      $modelUser = new ModelUser();
      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user = $modelUser->getById($result["user_id"]);
        if ($user->getUserRole() == 2) {
          array_push($list, $user);
        }

      }
      return $list;
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();


    }
  }
  public function getByUserIdAndClassCreditId(int $uid, int $classCreditId): object
  {
    $sql = "SELECT * FROM registers WHERE user_id = ? and class_credit_id = ? ";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->bindParam(2, $classCreditId, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $modelUser = new ModelUser();
      if ($result) {
        $user = $modelUser->getById($result["user_id"]);
        $classCredit = $modelClassCredit->getById($result["class_credit_id"]);
        return new Register(
          $result['register_id'],
          $classCredit,
          $user,
          DateTime::createFromFormat('Y-m-d H:i:s', $result['register_time'])
        );

      }

    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();


    }

  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof Register) {
        $register = $object;
      }
      $sql = "INSERT INTO registers (class_credit_id, user_id, register_time) VALUES (?, ?, ?)";
      $stmt = $this->link->prepare($sql);
      $creditId = $object->getClassCredit()->getClassCreditId();
      $userId = $object->getUser()->getUserId();
      $time = $object->getRegisterTime()->format('Y-m-d H:i:s');
      $stmt->bindParam(1, $creditId, PDO::PARAM_INT);
      $stmt->bindParam(2, $userId, PDO::PARAM_INT);
      $stmt->bindParam(3, $time, PDO::PARAM_STR);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM registers WHERE register_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function deleteByUserId(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM registers WHERE user_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function  deleteByClassCredit(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM registers WHERE class_credit_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
 
  public function deleteByUserAndClassCredit(int $objectid, int $classCreditId): bool
  {
    try {
      $sql = "DELETE FROM registers WHERE user_id = ? and class_credit_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->bindParam(2, $classCreditId, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }

  public function updateObject($object): bool
  {
    try {
      if ($object instanceof Register) {
        $register = $object;
      }
      $sql = "UPDATE registers SET class_credit_id = ?, user_id  = ?, register_time = ? WHERE register_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $register->getClassCredit()->getClassCreditId(), PDO::PARAM_INT);
      $stmt->bindParam(2, $register->getUser()->getUserId(), PDO::PARAM_INT);
      $stmt->bindParam(3, $register->getRegisterTime(), PDO::PARAM_STR);
      $stmt->bindParam(4, $register->getRegisterId(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
}
class ModelWeek extends DAO
{
  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM weeks WHERE week_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {

        return new Week(
          $result["week_id"],
          $result["week_name"],
          DateTime::createFromFormat('Y-m-d', $result["start_time"]),
          DateTime::createFromFormat('Y-m-d', $result["end_time"])

        );

      }
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();
    }

  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof Week) {
        $week = $object;
      }
      $sql = "INSERT INTO weeks(week_id,week_name,start_time,end_time) VALUES (?, ?, ?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $week->getWeekId(), PDO::PARAM_INT);
      $stmt->bindParam(2, $week->getWeekName(), PDO::PARAM_INT);
      $stmt->bindParam(3, $week->getStartTime(), PDO::PARAM_STR);
      $stmt->bindParam(4, $week->getEndTime(), PDO::PARAM_STR);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM weeks WHERE week_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }
  }
  public function updateObject($object): bool
  {

    return false;

  }
}
class ModelSchedule extends DAO
{

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM schedules WHERE schedule_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $modelKipstudy = new ModelKipStudy();
        $modelWeek = new ModelWeek();
        $week = $modelWeek->getById($result['week_id']);
        $weekEnd = $modelWeek->getById($result['week_id_end']);
        $kipStudy = $modelKipstudy->getById($result["kip_study_id"]);
        $modelClassRoom = new ModelClassRoom();
        $classRoom = $modelClassRoom->GetById($result["class_room_id"]);
        return new Schedule(
          $result['schedule_id'],
          $result['schedule_code'],
          $kipStudy,
          $result['day_study'],
          $result['category'],
          $week,
          $weekEnd,
          $classRoom
        );

      }
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();
    }

  }
  public function getByCode(int $uid): array
  {
    $sql = "SELECT * FROM schedules WHERE schedule_code = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $list = [];

      $modelKipstudy = new ModelKipStudy();
      $modelWeek = new ModelWeek();
      $modelClassRoom = new ModelClassRoom();

      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $week = $modelWeek->getById($result['week_id']);
        $weekEnd = $modelWeek->getById($result['week_id_end']);
        $kipStudy = $modelKipstudy->getById($result["kip_study_id"]);
        $classRoom = $modelClassRoom->GetById($result["class_room_id"]);

        array_push($list, new Schedule(
          $result['schedule_id'],
          $result['schedule_code'],
          $kipStudy,
          $result['day_study'],
          $result['category'],
          $week,
          $weekEnd,
          $classRoom
        )
        );

      }
      return $list;



    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();
    }
  }
  public function getAll()
  {
    $sql = "SELECT * FROM schedules";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->execute();
      $list = [];
      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
     
        array_push($list,$result['schedule_code']);

      }
      return  $list;



    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();
    }
  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof Schedule) {
        $schedule = $object;
      }
      $sql = "INSERT INTO schedules(schedule_code,kip_study_id,day_study,category,week_id,week_id_end,class_room_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $schedule->getScheduleCode(), PDO::PARAM_INT);
      $stmt->bindParam(2, $schedule->getKipStudy()->getKipStudyId(), PDO::PARAM_INT);
      $stmt->bindParam(3, $schedule->getDayStudy(), PDO::PARAM_INT);
      $stmt->bindParam(4, $schedule->getCategory(), PDO::PARAM_STR);
      $stmt->bindParam(5, $schedule->getWeek()->getWeekId(), PDO::PARAM_INT);
      $stmt->bindParam(6, $schedule->getWeekEnd()->getWeekId(), PDO::PARAM_INT);
      $stmt->bindParam(7, $schedule->getClassRoom()->getClassRoomId(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM schedules WHERE schedule_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function updateObject($object): bool
  {
    try {
      if ($object instanceof Schedule) {
        $schedule = $object;
      }
      $sql = "UPDATE schedules SET schedule_code = ?, kip_study_id = ?, day_study = ?, category= ?, week_id= ?, week_id_end = ?, class_room_id=? WHERE schedule_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $schedule->getScheduleCode(), PDO::PARAM_INT);
      $stmt->bindParam(2, $schedule->getKipStudy()->getKipStudyId(), PDO::PARAM_INT);
      $stmt->bindParam(3, $schedule->getDayStudy(), PDO::PARAM_INT);
      $stmt->bindParam(4, $schedule->getCategory(), PDO::PARAM_STR);
      $stmt->bindParam(5, $schedule->getWeek()->getWeekId(), PDO::PARAM_INT);
      $stmt->bindParam(6, $schedule->getWeekEnd()->getWeekId(), PDO::PARAM_INT);
      $stmt->bindParam(7, $schedule->getClassRoom()->getClassRoomId(), PDO::PARAM_INT);
      $stmt->bindParam(8, $schedule->getScheduleId(), PDO::PARAM_INT);

      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
}
class ModelSubject extends DAO
{

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM subjects WHERE subject_id = ?";
    try {
      // 2. Chuẩn bị câu lệnh sử dụng PDO
      $stmt = $this->link->prepare($sql);
      // 3. Gắn tham số một cách an toàn (ngăn chặn SQL injection)
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      // 4. Thực thi câu lệnh
      $stmt->execute();
      // 5. Lấy kết quả dưới dạng mảng kết hợp
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return new Subject(
          $result['subject_id'],
          $result['subject_code'],
          $result['subject_name'],
          $result['credit'],
          $result['price_credit']
        );

      }
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }

  }
  public function getAll():array
  {
    $sql = "SELECT * FROM subjects";
    try {
      // 2. Chuẩn bị câu lệnh sử dụng PDO
      $stmt = $this->link->prepare($sql);
      $stmt->execute();
      $list=[];
      while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        array_push($list, new Subject(
          $result['subject_id'],
          $result['subject_code'],
          $result['subject_name'],
          $result['credit'],
          $result['price_credit']
        ));

      }
      return $list;
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }

  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof Subject) {
        $subject = $object;
      }
      $sql = "INSERT INTO subjects(subject_code,subject_name,credit, price_credit) VALUES (?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $subject->getSubjectCode(), PDO::PARAM_STR);
      $stmt->bindParam(2, $subject->getSubjectName(), PDO::PARAM_STR);
      $stmt->bindParam(1, $subject->getCredit(), PDO::PARAM_INT);
      $stmt->bindParam(2, $subject->getPriceCredit(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM subjects WHERE subject_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function updateObject($object): bool
  {
    try {
      if ($object instanceof Subject) {
        $subject = $object;
      }
      $sql = "UPDATE subjects SET subject_code = ?, subject_name = ?,credit = ?, price_credit = ? WHERE subject_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $subject->getSubjectCode(), PDO::PARAM_STR);
      $stmt->bindParam(2, $subject->getSubjectName(), PDO::PARAM_STR);
      $stmt->bindParam(1, $subject->getCredit(), PDO::PARAM_INT);
      $stmt->bindParam(2, $subject->getPriceCredit(), PDO::PARAM_INT);
      $stmt->bindParam(3, $subject->getSubjectId(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
}
class ModelSubjectSemester extends DAO
{

  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM subject_semesters WHERE subject_semester_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $modelBranch = new ModelBranch();
        $branch = $modelBranch->getById($result["branch_id"]);
        $modelSubject = new ModelSubject();
        $subject = $modelSubject->GetById($result["subject_id"]);
        return new SubjectSemester(
          $result['subject_semester_id'],
          $result['subject_semester_name'],
          $subject,
          $branch
        );

      }
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }

  }
  public function getByNameAndBranch(int $name, string $departmentCode): array
  {
    $sql = "SELECT * FROM subject_semesters WHERE subject_semester_name = ? and branch_id=?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $name, PDO::PARAM_INT);
      $stmt->bindParam(2, $departmentCode, PDO::PARAM_STR);
      $stmt->execute();
      $list = [];
      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $modelBranch = new ModelBranch();
        $branch = $modelBranch->getById($result["branch_id"]);
        $modelSubject = new ModelSubject();
        $subject = $modelSubject->GetById($result["subject_id"]);

        array_push(
          $list,
          new SubjectSemester(
            $result['subject_semester_id'],
            $result['subject_semester_name'],
            $subject,
            $branch
          )
        );

      }
      return $list;
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }

  }
  public function addObject(object $object): bool
  {
    try {
      if ($object instanceof SubjectSemester) {
        $subject = $object;
      }
      $sql = "INSERT INTO subject_semesters(subject_semester_name,subject_id,branch_id) VALUES (?, ?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $subject->getSubjectSemesterName(), PDO::PARAM_INT);
      $stmt->bindParam(2, $subject->getSubject()->getSubjectId(), PDO::PARAM_INT);
      $stmt->bindParam(1, $subject->GetBranch()->getBranchId(), PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM subject_semesters WHERE subject_semester_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }
  public function updateObject($object): bool
  {

    return false;

  }
  // public function updateObject($object):bool{
  //   try {
  //     if ($object instanceof SubjectSemester) {
  //         $subject  = $object;
  //     }
  //     $sql = "UPDATE subject_semesters SET subject_semester_name = ?, subject_id = ?,department_id = ? WHERE subject_semester_id = ?";
  //     $stmt = $this->link->prepare($sql);
  //     $stmt->bindParam(1, $subject->getSubjectSemesterName(), PDO::PARAM_INT);
  //     $stmt->bindParam(2,  $subject->getSubject()->getSubjectId(), PDO::PARAM_INT);
  //     $stmt->bindParam(1, $subject->GetDepartment()->getDepartmentId() , PDO::PARAM_INT);
  //     $stmt->bindParam(2,  $subject->getSubjectSemesterId(), PDO::PARAM_INT);
  //     $stmt->execute();
  //     return true;
  //   } catch (PDOException $e) {
  //     return false;
  //   }
  // }
}

class ModelUser extends DAO
{


  public function getRole($userName, $passWord)
  {
    $sql = 'SELECT * FROM  users WHERE user_name = ? and pass_word = ?';
    try {

      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $userName, PDO::PARAM_STR);
      $stmt->bindParam(2, $passWord, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return ($result['user_role']);
      }
      return 0;

    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }

  }
  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM  users WHERE user_id = ?";
    try {

      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $modelClassFormal = new ModelClassFormal();

        return new User(
          $result['user_id'],
          $modelClassFormal->getById($result["class_formal_id"]),
          $result['user_name'],
          $result['pass_word'],
          $result['full_name'],
          $result['user_role'],
          $result['status'],
          $result['date_of_birth'],
          $result['gender'],
          $result['birthplace'],
          $result['current_address'],
          $result['avatar_image_path'],
          $result['link_social'],
          $result['description_text']
        );

      }
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }
  }
  public function getAll(): array
  {
    $sql = "SELECT * FROM  users";
    try {

      $stmt = $this->link->prepare($sql);

      $stmt->execute();
      $list = [];
      $modelClassFormal = new ModelClassFormal();
      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

        array_push($list, new User(
          $result['user_id'],
          $modelClassFormal->getById($result["class_formal_id"]),
          $result['user_name'],
          $result['pass_word'],
          $result['full_name'],
          $result['user_role'],
          $result['status'],
          $result['date_of_birth'],
          $result['gender'],
          $result['birthplace'],
          $result['current_address'],
          $result['avatar_image_path'],
          $result['link_social'],
          $result['description_text']
        )
        );

      }
      return $list;
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }
  }
  public function getByUserName(string $uid)
  {
    $sql = "SELECT * FROM  users WHERE user_name = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $modelClassFormal = new ModelClassFormal();
        return new User(
          $result['user_id'],
          $modelClassFormal->getById($result["class_formal_id"]),
          $result['user_name'],
          $result['pass_word'],
          $result['full_name'],
          $result['user_role'],
          $result['status'],
          $result['date_of_birth'],
          $result['gender'],
          $result['birthplace'],
          $result['current_address'],
          $result['avatar_image_path'],
          $result['link_social'],
          $result['description_text'],
        );

      }
      return 0;
    } catch (PDOException $e) {
      // 7. Xử lý lỗi cơ sở dữ liệu tiềm ẩn
      echo "Lỗi: " . $e->getMessage();

    }
  }
  public function addObject(object $object): bool
  {
    try {
      $classFormalId = $object->getClassFormal()->getClassFormalId();
      $userName = $object->getUserName();
      $password = $object->getPassword();
      $fullName = $object->getFullName();

      $userRole = $object->getUserRole();  // Assuming valid role values are defined
      $status = $object->getStatus();      // Assuming valid status values are defined
      $dateOfBirth = $object->getDateOfBirth(); // Assuming date format is appropriate for storage
      $gender = $object->getGender();        // Assuming valid gender values are defined
      $birthplace = $object->getBirthplace();
      $currentAddress = $object->getCurrentAddress();
      $avatarImagePath = $object->getAvatarImagePath(); // Optional
      $linkSocial = $object->getLinkSocial();          // Optional
      $descriptionText = $object->getDescriptionText(); // Optional
      $ok = 0;
      $sql = "INSERT INTO users (
            class_formal_id,
            user_name,
            pass_word,
            full_name,
           
            user_role,
            status,
            date_of_birth,
            gender,
            birthplace,
            current_address,
            avatar_image_path,
            link_social,
            description_text,
            password_latest
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

      $stmt = $this->link->prepare($sql);

      $stmt->bindParam(1, $classFormalId, PDO::PARAM_INT);
      $stmt->bindParam(2, $userName, PDO::PARAM_STR);
      $stmt->bindParam(3, $password, PDO::PARAM_STR); // Assuming password is hashed
      $stmt->bindParam(4, $fullName, PDO::PARAM_STR);
      $stmt->bindParam(5, $userRole, PDO::PARAM_INT);  // Assuming valid role values are defined
      $stmt->bindParam(6, $status, PDO::PARAM_INT);    // Assuming valid status values are defined
      $stmt->bindParam(7, $dateOfBirth, PDO::PARAM_STR); // Assuming date format is appropriate for storage
      $stmt->bindParam(8, $gender, PDO::PARAM_STR);     // Assuming valid gender values are defined
      $stmt->bindParam(9, $birthplace, PDO::PARAM_STR);
      $stmt->bindParam(10, $currentAddress, PDO::PARAM_STR);
      $stmt->bindParam(11, $avatarImagePath, PDO::PARAM_STR); // Optional
      $stmt->bindParam(12, $linkSocial, PDO::PARAM_STR);     // Optional
      $stmt->bindParam(13, $descriptionText, PDO::PARAM_STR); // Optional
      $stmt->bindParam(14, $ok, PDO::PARAM_INT); // Optional
      $stmt->execute();

      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    try {
      $modelRegister=new ModelRegister();
      $modelEmail=new ModelEmail();
      $modelPhoneNumber=new ModelPhoneNumber();
      $modelRegister->deleteByUserId($objectid);
      $modelEmail->deleteByUserId($objectid);
      $modelPhoneNumber->deleteByUserId($objectid);
      $sql = "DELETE FROM users WHERE user_id = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      // echo "" . $e->getMessage();
      return false;
    }

  }
  public function deleteUserByUserName(int $objectid): bool
  {
    try {
      $sql = "DELETE FROM users WHERE user_name = ?";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $objectid, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      echo "" . $e->getMessage();
      return false;
    }

  }


  #update user with username 
  public function updateObject($object): bool
  {
    try {

      $sql = "UPDATE users SET
       class_formal_id= ?,
        user_name  = ?,
        pass_word  = ?,
        full_name  = ?,
        user_role  = ?,
        status  = ?,
        date_of_birth = ?,
        gender= ?, 
        birthplace= ?,
        current_address= ?, 
        avatar_image_path= ?,
        link_social=?
        WHERE user_id = ?";
      $stmt = $this->link->prepare($sql);
      $userId=$object->getUserId();
      $classFormalId = $object->getClassFormal()->getClassFormalId();
      $userName = $object->getUserName();
      $password = $object->getPassword();
      $fullName = $object->getFullName();
      $userRole = $object->getUserRole();  // Assuming valid role values are defined
      $status = $object->getStatus();      // Assuming valid status values are defined
      $dateOfBirth = $object->getDateOfBirth(); // Assuming date format is appropriate for storage
      $gender = $object->getGender();        // Assuming valid gender values are defined
      $birthplace = $object->getBirthplace();
      $currentAddress = $object->getCurrentAddress();
      $avatarImagePath = $object->getAvatarImagePath(); // Optional
      $linkSocial = $object->getLinkSocial();          // Optional


      $stmt->bindParam(1, $classFormalId, PDO::PARAM_INT);
      $stmt->bindParam(2, $userName, PDO::PARAM_STR);
      $stmt->bindParam(3, $password, PDO::PARAM_STR); // Assuming password is hashed
      $stmt->bindParam(4, $fullName, PDO::PARAM_STR);

      $stmt->bindParam(5, $userRole, PDO::PARAM_INT);  // Assuming valid role values are defined
      $stmt->bindParam(6, $status, PDO::PARAM_INT);    // Assuming valid status values are defined
      $stmt->bindParam(7, $dateOfBirth, PDO::PARAM_STR);
      $stmt->bindParam(8, $gender, PDO::PARAM_INT);
      $stmt->bindParam(9, $birthplace, PDO::PARAM_STR);
      $stmt->bindParam(10, $currentAddress, PDO::PARAM_STR);
      $stmt->bindParam(11, $avatarImagePath, PDO::PARAM_STR);
      $stmt->bindParam(12,$linkSocial, PDO::PARAM_STR);

      $stmt->bindParam(13, $userId, PDO::PARAM_INT);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();
      return false;
    }
  }
}
class ModelNews extends DAO
{
  public function getById(int $uid): object
  {
    $sql = "SELECT * FROM news WHERE new_id = ?";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $uid, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return new News(
          $result['new_id'],
          $result['new_title'],
          $result['new_body'],
          DateTime::createFromFormat('Y-m-d H:i:s', $result['new_time'])
        );

      }
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();

    }

  }
  public function getAll(): array
  {
    $sql = "SELECT * FROM news";
    try {
      $stmt = $this->link->prepare($sql);
      $stmt->execute();
      $list = [];
      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($list, new News(
          $result['new_id'],
          $result['new_title'],
          $result['new_body'],
          DateTime::createFromFormat('Y-m-d H:i:s', $result['new_time'])
        )
        );

      }
      return $list;
    } catch (PDOException $e) {
      echo "Lỗi: " . $e->getMessage();

    }

  }

  public function addObject(object $object): bool
  {
    try {
      $sql = "INSERT INTO news(new_id,new_title,new_body,new_time) VALUES (?, ?, ?, ?)";
      $stmt = $this->link->prepare($sql);
      $stmt->bindParam(1, $object->getNewId(), PDO::PARAM_INT);
      $stmt->bindParam(2, $object->getNewTitle(), PDO::PARAM_STR);
      $stmt->bindParam(3, $object->getNewBody(), PDO::PARAM_STR);
      $stmt->bindParam(4, $object->getNewTime(), PDO::PARAM_STR);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }


  }
  public function deleteObject(int $objectid): bool
  {
    return false;
  }
  public function updateObject($object): bool
  {

    return false;
  }

}
?>