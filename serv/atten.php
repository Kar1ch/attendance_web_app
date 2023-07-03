<?php
    include('logs.php');
    //echo 'test';
    if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1" ){
        $db = mysqli_connect('localhost', 'root', '', 'attendance');
        if (!$db) {die("Connection failed: " . mysqli_connect_error());}
        //echo('fd');
    }else if($_SERVER['REMOTE_ADDR'] == '::1'){
        $db = mysqli_connect('localhost', 'root', 'root', 'attendance');
        if (!$db) {die("Connection failed: " . mysqli_connect_error());}
        //echo ('f');
    }else{
        $db = mysqli_connect('localhost', 'cg86624_attendan', 'pass', 'cg86624_attendan');
        if (!$db) {die("Connection failed: " . mysqli_connect_error());}
    }

    //$Data = file_get_contents('php://input'); // Получаем необработанный текст от входящего запроса

    //echo($_GET['py_comm']);

    //$dat = json_decode($Data, true); // преобразование строки в формате json в ассоциативный массив

    if($_GET['py_get_comm']){ // Запрос списка студентов GetStudentsList()
        if ($_GET['py_get_comm'] == 1){
            $sql1 = "SELECT * FROM `students`";
            $result2_1 = mysqli_query($db, $sql1);
    
            $myArray = array();
            if($result2_1){
                while($Arr2 = mysqli_fetch_assoc($result2_1)){
                    $myArray[] = $Arr2;
                }
    
                echo json_encode($myArray);
                AddLog(1, 'Староста', "GetStudentsList()", "Список студентов выведен");
            }else{
                echo 'error';
                AddLog(0, 'Староста', "GetStudentsList()", "Ошибка вывода списка студентов");
            }
        }
        if($_GET['py_get_comm'] == 2){
        
            $date = $_GET['date'];
            $lesson = $_GET['lesson'];

            $sql = "SELECT students.student_id, students.name, attendance_accounting.status 
                    FROM students JOIN attendance_accounting ON students.student_id = attendance_accounting.student_id 
                    WHERE attendance_accounting.date = '$date' AND attendance_accounting.lessonn = '$lesson'";

            $result2_2 = mysqli_query($db, $sql);

            $myArray = array();
            if($result2_2){
                while($Arr2 = mysqli_fetch_assoc($result2_2)){
                    $myArray[] = $Arr2;
                }
                echo json_encode($myArray);
            }
            else{
                echo 'error';
            }
        }
    }


    if($_POST['py_post_comm']){ // Проставление посещаемости StudentAttendanceSet(Номер студака, текущая дата, текущая пара)
        if($_POST['py_post_comm'] == 1){
            $student_id = mysqli_real_escape_string($db, $_GET['student_id']);
            $current_date = mysqli_real_escape_string($db, $_GET['cur_date']);

            //$student_id = $_POST['student'];
            //$current_date = $_POST['cur_date'];
    
            $sql1 = "SELECT * FROM `students` WHERE studak = '$student_id'";
            $result1_1 = mysqli_query($db, $sql1);
    
            if(mysqli_num_rows($result1_1) > 0){
                $Arr1 = mysqli_fetch_assoc($result1_1);
                $student_id_from_table = $Arr1['stud_id'];
    
    
                //echo $student_id_from_table;
                $sql2 = "SELECT * FROM `attendance_accounting` WHERE student_id = '$student_id_from_table' and lesson_number = '$_POST[cur_lesson]' and date = '$_POST[cur_date]'";
                $result1_2 = mysqli_query($db, $sql2);
                if(mysqli_num_rows($result1_2) > 0){
                    echo('уже отмечен');
                    AddLog(0, "Староста", "StudentAttendanceSet($student_id, $current_date, $current_lesson)", "Студент уже отмечен");
                }else{
                    $sql3 = "INSERT INTO `attendance_accounting`(`student_id`, `date`, `lesson_number`, `status`) VALUES ('$student_id_from_table', '$current_date', '$_POST[cur_lesson]', '1')";
                    $result1_3 = mysqli_query($db, $sql3);
                    if($result1_3){
                        echo('поставлена посещаемость');
                        AddLog(1, "Староста", "StudentAttendanceSet($student_id, $current_date, $current_lesson)", "Посещамость проставлена");
                    }else{
                        echo 'посещаемость не поставлена';
                        AddLog(0, "Староста", "StudentAttendanceSet($student_id, $current_date, $current_lesson)", "Посещамость не проставлена");     
                    }
                }
            }else{
                echo 'Такого студенческого нет в базе студентов';
                AddLog(0, "Староста", "StudentAttendanceSet($student_id, $current_date, $current_lesson)", "Такого студенческого нет в базе студентов");
            }
        }

        if($_POST['py_post_comm'] == 2){ // Добавление студента в базу StudentAddToDataBase(Номер студака, ФИО стиудента, пароль студента)
            $studak = mysqli_real_escape_string($db, $_GET['studak']);
            $name = mysqli_real_escape_string($db, $_GET['name']);

            //$studak = $_POST['studak'];
            //$name = $_POST['name'];
            $password = md5($_POST['name'] .''. $_POST['password']);
    
            $sql2 = "INSERT INTO `students`(`studak`, `name`, `password`, `admin`) VALUES ('$studak', '$name','$password','0')";
            $result2_1 = mysqli_query($db, $sql2);
    
            if($result2_1){
                echo "Новый студент добавлен в базу";
                AddLog(1, "Староста", "StudentAddToDataBase($studak, $name, $password)", "Новый студент добавлен в базу");
            }else{
                echo "Ошибка доавбления нового студента в базу";
                AddLog(0, "Староста", "StudentAddToDataBase($studak, $name, $password)", "Ошибка добавления нового студента в базу");
            }
        }
    }
    

    /*
    $sql = "SELECT * FROM student_attendance WHERE stud_id = '$student_id'";
    echo($dat['student']);
    echo('__');
    echo($dat['cur_date']);
    */

?>
