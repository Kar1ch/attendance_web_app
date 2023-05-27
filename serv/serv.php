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


if(isset($_GET['get_comm']))
{
    $get_comm = $_GET['get_comm'];

    if($get_comm == 1){//Авторизация
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
            }
        }else{
            echo 'error_get1';
        }
    }

    if($get_comm == 2){//Получение дат пар для конкретного студента
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
        }else{
            echo 'error';
        }
    }

    if($get_comm == 3){//Получение посещаемости студента в конкретный день
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
        }else{
            echo 'error';
        }
    }

    if($get_comm == 4){ //check_for_admin
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
        }else{
            echo 'error';
        }
    }

    if($get_comm == 5){ //Получение списка студентов с их посещаемостью
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
        }else{
            echo 'error';
        }
    }

    if($get_comm == 6){ //Получение списка студентов
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
        }else{
            echo 'error';
        }
    }
}




if(isset($_POST['post_comm'])){  
    $post_comm = $_POST['post_comm'];
    


}

?>
