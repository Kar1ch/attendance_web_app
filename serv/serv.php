<?php

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
include('logs.php');

if(isset($_GET['get_comm']))
{
    $get_comm = $_GET['get_comm'];

    if($get_comm == 1){ //Авторизация Auth(login, password)
        //echo 'test';
        $login = $_GET['login'];
        $password = $_GET['password'];
        $tmp = $login ."" . $password;
        $hash = md5($tmp);
        $sql = "SELECT * FROM students WHERE name = '$login' and password = '$hash'";
        $result1 = mysqli_query($db, $sql);
        $myArray = array();
        if(mysqli_num_rows($result1) == 1){
            $Arr1 = mysqli_fetch_assoc($result1);
            if($Arr1['password'] == $hash){
                $myArray[] = $Arr1;
                echo json_encode($myArray);
                AddLog(1, $login, "Auth($login, $password)", 'Удачная авторизация');
            }
        }else{
            echo 'error_get1';
            AddLog(0, $login, "Auth($login, $password)", 'Не удалось авторизироваться');
        }
    }

    if($get_comm == 2){//Получение дат пар для конкретного студента UniqDates(Student_id)
        //echo ('test');
        $student_id = $_GET['student_id'];
        $sql = "SELECT distinct date FROM attendance_accounting WHERE student_id = '$student_id'";
        $result2 = mysqli_query($db, $sql);
        $myArray = array();
        if($result2){
            while($Arr2 = mysqli_fetch_assoc($result2)){
                $myArray[] = $Arr2;
            }

            echo json_encode($myArray);
            AddLog(1, 'user', "UniqDates($student_id)", 'Удачно получены даты пар для студента');
        }else{
            echo 'error';
            AddLog(0, 'user', "UniqDates($student_id)", 'Не удалось получить даты пар для студента');
        }
    }

    if($get_comm == 3){//Получение посещаемости студента в конкретный день CurrentDate(Student_id, Current_data)
        //echo ('test');
        $student_id = $_GET['student_id'];
        $current_date = $_GET['current_date'];
        $sql = "SELECT * FROM attendance_accounting WHERE student_id = '$student_id' and date = '$current_date'";
        $result3 = mysqli_query($db, $sql);
        $myArray = array();
        if($result3){
            while($Arr3 = mysqli_fetch_assoc($result3)){
                $myArray[] = $Arr3;
            }
            echo json_encode($myArray);
            AddLog(1, 'user', "CurrnetDate($student_id, $current_date)", 'Получена посещаемость студента в конкретный день');
        }else{
            echo 'error';
            AddLog(0, 'user', "CurrnetDate($student_id, $current_date)", 'Не удалось получить посещаемость студента в конкретный день');
        }
    }

    if($get_comm == 4){ //check_for_admin(Admin_id)
        //echo ('test');
        $admin_id = $_GET['admin_id'];
        $sql = "SELECT name FROM students WHERE password = '$admin_id'";
        $result4 = mysqli_query($db, $sql);
        $myArray = array();
        if($result4){
            while($Arr4 = mysqli_fetch_assoc($result4)){
                $myArray[] = $Arr4;
            }

            echo json_encode($myArray);
            AddLog(1, 'Староста', "check_for_admin($admin_id)", 'Проверка на админа пройдена');
        }else{
            echo 'error';
            AddLog(0, 'Староста', "check_for_admin($admin_id)", 'Проверка на админа не пройдена');
        }
    }

    if($get_comm == 5){ //Получение списка студентов с их посещаемостью GetStudenstListWithAttendance(admin_id)
        //echo ('test');
        $admin_id = $_GET['admin_id'];
        $sql = "SELECT name FROM students order by name";
        $result5 = mysqli_query($db, $sql);
        $myArray = array();
        if($result5){
            while($Arr5 = mysqli_fetch_assoc($result5)){
                $myArray[] = $Arr5;
            }

            echo json_encode($myArray);
            AddLog(1, 'Староста', "GetStudenstListWithAttendance($admin_id)", 'Получен список студентов с их посещаемостью');
        }else{
            echo 'error';
            AddLog(0, 'Староста', "GetStudenstListWithAttendance($admin_id)", 'Не удалось получить список студентов с их посещаемостью');
        }
    }

    if($get_comm == 6){ //Получение списка студентов GetStudentsList(admin_id)
        //echo ('test');
        $admin_id = $_GET['admin_id'];
        $sql = "SELECT * FROM students order by name";
        $result6 = mysqli_query($db, $sql);
        $myArray = array();
        if($result6){
            while($Arr6 = mysqli_fetch_assoc($result6)){
                $myArray[] = $Arr6;
            }

            echo json_encode($myArray);
        }else{
            echo 'error';
        }
    }

    if($get_comm == 7){ //Получение посещаемости за период
        //echo ('test');
        $date_from = $_GET['date_from'];
        $date_to = $_GET['date_to'];
        $sql = "SELECT * FROM attendance_accounting WHERE attendance_accounting.date >= '$date_from' and attendance_accounting.date <= '$date_to' ORDER BY attendance_accounting.date";
        $result7 = mysqli_query($db, $sql);
        $myArray = array();
        if($result7){
            while($Arr7 = mysqli_fetch_assoc($result7)){
                $myArray[] = $Arr7;
            }

            echo json_encode($myArray);
        }else{
            echo 'error';
        }
    }

    if($get_comm == 8){ //Получение календаря за период
        //echo ('test');
        $date_from = $_GET['date_from'];
        $date_to = $_GET['date_to'];
        $sql = "SELECT * FROM calendar WHERE calendar.date >= '$date_from' and calendar.date <= '$date_to' ORDER BY calendar.date, calendar.lesson_number";
        $result8 = mysqli_query($db, $sql);
        $myArray = array();
        if($result8){
            while($Arr8 = mysqli_fetch_assoc($result8)){
                $myArray[] = $Arr8;
            }

            echo json_encode($myArray);
            AddLog(1, 'Староста', "GetStudentsList($admin_id)", 'Получен список студентов');
        }else{
            echo 'error';
            AddLog(0, 'Староста', "GetStudentsList($admin_id)", 'Не удалось получить список студентов');
        }
    }
    if($get_comm == 9){ //Получение статуса студента за конкретную пару
        //echo ('test');
        $date = $_GET['date'];
        $lesson_number = $_GET['lesson_number'];
        $student_id = $_GET['stud_id'];
        $sql = "SELECT status FROM `attendance_accounting` WHERE date = '$date' and lesson_number='$lesson_number' and student_id='$student_id'";
        $result9 = mysqli_query($db, $sql);
        $myArray = array();
        if($result9){
            while($Arr9 = mysqli_fetch_assoc($result9)){
                $myArray[] = $Arr9;
            }

            echo json_encode($myArray);
        }else{
            echo 'error';
        }
    }
}




if(isset($_POST['post_comm'])){  
    $post_comm = $_POST['post_comm'];
    


}

?>
