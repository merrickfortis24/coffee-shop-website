<?php
 
class database{
 
    function opencon() {
 
        return new PDO(
            'mysql:host=localhost; dbname=coffee_shop',
            username: 'root',
            password: '');
   
 
        }
 
        function signupUser($firstname, $lastname, $username, $email, $password) {
            $con = $this->opencon();
 
            try {
                $con->beginTransaction();

                // Combine first and last name for Admin_Name
                $admin_name = $firstname . ' ' . $lastname;
                $admin_role = 'admin';
                $created_at = date('Y-m-d H:i:s');
                $updated_at = date('Y-m-d H:i:s');
                $status = 'active';

                $stmt = $con->prepare("INSERT INTO admin (Admin_Name, Admin_password, Admin_email, Admin_role, Created_at, Updated_at, Status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$admin_name, $password, $email, $admin_role, $created_at, $updated_at, $status]);

                $userID = $con->lastInsertId();
                $con->commit();

                return $userID;
            } catch (PDOException $e) {
                $con->rollBack();
                return false;
            }
           
        }
 
        function isUsernameExists($username) {
            $con = $this->opencon();
 
            $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_username = ?");
            $stmt->execute([$username]);
 
            $count = $stmt->fetchColumn();
            return $count > 0; //Returns true if username exists, false otherwise
           
        }

        function isEmailExists($email) {
            $con = $this->opencon();
 
            $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_email = ?");
            $stmt->execute([$email]);
 
            $count = $stmt->fetchColumn();
            return $count > 0; //Returns true if username exists, false otherwise
           
        }

        function isCourseExists($courseName) {
            $con = $this->opencon();
            $stmt = $con->prepare("SELECT COUNT(*) FROM courses WHERE course_name = ?");
            $stmt->execute([$courseName]);
            $count = $stmt->fetchColumn();
            return $count > 0;
        }

        function loginUser($username, $password) {
            $con = $this->opencon();
            $stmt = $con->prepare("SELECT * FROM Admin WHERE admin_username = ?");

            $stmt->execute([$username]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['admin_password'])) {

                return $user;


            }else{
                return false;
            }

        }

        function addStudent($firstname, $lastname, $email, $admin_id) {
            $con = $this->opencon();
           
            try{
                $con->beginTransaction();
 
                $stmt = $con->prepare("INSERT INTO students (student_FN, student_LN, student_email, admin_id) VALUES (?,?,?,?)");
                $stmt->execute([$firstname, $lastname, $email, $admin_id]);
               
                $userID = $con->lastInsertId();
                $con->commit();
 
                return $userID;
            }catch (PDOException $e){
                $con->rollBack();
                return false;
            }
           
        }

        function addCourse($course, $admin_id) {
            $con = $this->opencon();
           
            try{
                $con->beginTransaction();
 
                $stmt = $con->prepare("INSERT INTO courses (course_name, admin_id) VALUES (?,?)");
                $stmt->execute([$course, $admin_id]);
               
                $userID = $con->lastInsertId();
                $con->commit();
 
                return $userID;
            }catch (PDOException $e){
                $con->rollBack();
                return false;
            }
           
        }
        function getCourses() {
        $con = $this->opencon();
        return $con->query("SELECT * FROM courses")->fetchAll();
    }
    function getStudents() {
        $con = $this->opencon();
        return $con->query("SELECT * FROM students")->fetchAll();
    }

    function getStudentById($student_id) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->execute([$student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateStudent($student_id, $first_name, $last_name, $email) {
    try {
    $con = $this->opencon();
    $con->beginTransaction();
    $query = $con->prepare("UPDATE students SET student_FN = ?, student_LN = ?, student_email = ? WHERE student_id = ?");
    $query->execute([$first_name, $last_name, $email, $student_id]);
    $con->commit();
    return true;
    } catch (PDOException $e) {
        $con->rollBack();
        return false;
    }
}

function getCourseById($course_id) {
    $con = $this->opencon();
    $stmt = $con->prepare("SELECT * FROM courses WHERE course_id = ?");
    $stmt->execute([$course_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateCourse($course_id, $course_name) {
    try {
        $con = $this->opencon();
        $con->beginTransaction();
        $stmt = $con->prepare("UPDATE courses SET course_name = ? WHERE course_id = ?");
        $stmt->execute([$course_name, $course_id]);
        $con->commit();
        return true;
    } catch (PDOException $e) {
        $con->rollBack();
        return false;
    }
}


}