$(function(){

    function clear_auth_cookie(){
        $.removeCookie('auth', { path: '/' });
    }

    function close_all_page(){
        $('#auth-page').addClass('hide');
        $('#attendance-page').addClass('hide');
    }

    function open_auth_page(){
        close_all_page();
        $('#auth-page').removeClass('hide');
    }


    function get_attendance_for_today(current_date){
        var srvAdr = "serv/serv.php";

        var srvdat = new Object();                 
        srvdat.comm = 3;  
        srvdat.current_date = current_date;  
        srvdat.student_id = $.cookie('auth');

        $.post(srvAdr, srvdat, function(data){ // POST Запрос
            if (data.length > 0){ // Если есть данные 
                if (data != 'error'){
                    var response = JSON.parse(data);

                    //alert(response[0].status);
                }
            }else{alert("Нет ответа от сервера!");} // END Если есть данные
        });
    }

    function check_for_admin(){

    }

    function load_attendance_table(){
        var srvAdr = "serv/serv.php";

        var srvdat = new Object();                 
        srvdat.comm = 2;  
        srvdat.student_id = $.cookie('auth');

        $.post(srvAdr, srvdat, function(data){ // POST Запрос
            if (data.length > 0){ // Если есть данные 
                if (data != 'error'){
                    var response = JSON.parse(data);

                    var block = "<table><tr><td></td>";             

                    for (let i = 0; i < Object.keys(response).length; i++){
                        //alert(response[i].user_id);
                        get_attendance_for_today(response[i].date)
                        block += "<td>" + response[i].date + "</td>";
                    }
                    block += "</tr>";

                    for (let i = 0; i < 6 ; i++){
                        //alert(response[i].date);
                        block += "<tr><td>" + (i+1) + "</td>" + 
                        "</tr>";
                    }

                    block += "</table>";

                    $('.user-attendance').html(block);
                }
            }else{alert("Нет ответа от сервера!");} // END Если есть данные
        });
    }

    function open_attendance_page(){
        close_all_page();
        load_attendance_table();
        $('#attendance-page').removeClass('hide');
        $('.user-greetings').removeClass('hide');
        $('.user-greetings').html('Номер вашего студенческого: ' + $.cookie('auth'));
    }


    if($.cookie('auth')){
        open_attendance_page();
    }else{
        open_auth_page();
    }
    
    $('.exit-from-account').on("click",function(){
        //alert('click');
        clear_auth_cookie();
        location.href="";
    });

    $('#auth-submit-btn').on("click",function(){
        //alert('yes');
        var login = $('#login').val();
        var password = $('#password').val();

        
        if (login != '' && password != ''){
            var srvAdr = "serv/serv.php";

            var srvdat = new Object();                                        
            srvdat.comm = 1;  
            srvdat.login = login;
            srvdat.password = password;

            $.post(srvAdr, srvdat, function(data){ // POST Запрос
                if (data.length > 0){ // Если есть данные 
                    if (data != 'error'){
                        var response = JSON.parse(data);
                        //alert(data);
                        $.cookie('auth', response[0].stud_id, {path: '/' });
                        alert($.cookie('auth'));
                        if(response[0].admin == 1){
                            $.cookie('admin', response[0].password, {path: '/' });
                        }
                        
                        //alert($.cookie('admin'));

                        location.href="";
                    }else{
                        alert('Не угадал');
                    }
                }else{alert("Нет ответа от сервера!");} // END Если есть данные
            });

        }else{
            $('#auth-fields-not-filled').removeClass('hide');
            //alert('Нужно заполнить все поля');
        }
    });




});
