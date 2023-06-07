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
    srvdat.get_comm = 3;  
    srvdat.current_date = current_date;  
    srvdat.student_id = $.cookie('auth');

    $.get(srvAdr, srvdat, function(data){
        if (data.length > 0){ // Если есть данные 
            if (data != 'error'){
                var response = JSON.parse(data);

                //alert(response[0].status);
            }
        }else{alert("Нет ответа от сервера!");} // END Если есть данные
    });
}

async function check_for_admin(){
    is_admin = false;
    if($.cookie('admin')){
        var srvAdr = "serv/serv.php";

        var srvdat = new Object();                 
        srvdat.get_comm = 4;  
        srvdat.admin_id = $.cookie('admin');

        await $.get(srvAdr, srvdat, function(data){
            if (data.length > 0){ // Если есть данные 
                if (data != 'error'){
                    is_admin = true;
                    
                }
            }else{alert("Нет ответа от сервера!");} // END Если есть данные
        });
    }

    return is_admin;    
}

async function load_attendance_table(){
    var srvAdr = "serv/serv.php";

    if($.cookie('admin')){
        //alert('admin');
       
        //var res = await check_for_admin();
        if(await check_for_admin()){
            var srvdat = new Object();                 
            srvdat.get_comm = 6;  
            srvdat.admin_id = $.cookie('admin');

            $.get(srvAdr, srvdat, function(data){
                if (data.length > 0){ // Если есть данные 
                    if (data != 'error'){
                        //alert('admin');
                        let nn = 'dfg';
                        var response = JSON.parse(data);

                        var block = `<table class='atten-table'>
                        <tr>
                            <td colspan='2' rowspan='2'></td>
                        </tr>
                        <tr class='dates-tr'></tr>

                        <tr class='atten-headers'>
                            <td></td>
                            <td>ФИО</td>
                          
                        </tr>`;
                         

                        for (let i = 0; i < Object.keys(response).length; i++){
                            //alert(response[i].user_id);
                            studentNumber = i + 1;
                            block += 
                                `<tr class='student-tr' student_id='${response[i].stud_id}'>
                                    <td>${response[i].stud_id}</td>
                                    <td>${response[i].name}</td>
                                </tr>`;
                        }


                        block += "</table>";

                        $('.user-attendance').html(block);

                        //$('.atten-headers').append('<td>test</td>');

                        //$('.atten-headers').append('<td>test</td>');
                    }
                }else{alert("Нет ответа от сервера!");} // END Если есть данные
            });
        }
        

    }else{
        var srvdat = new Object();                 
        srvdat.get_comm = 2;  
        srvdat.admin_id = $.cookie('admin');

        $.get(srvAdr, srvdat, function(data){ 
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

    
}

async function get_students(){
    var srvAdr = "serv/serv.php";

    var srvdat = new Object();     
    srvdat.get_comm = 6;            
    srvdat.admin_id = $.cookie('admin'); 

    var resp = '';

    await $.get(srvAdr, srvdat, function(data){
        if (data.length > 0){ // Если есть данные 
            if (data != 'error'){
                resp = JSON.parse(data);
            }
        }else{alert("Нет ответа от сервера!");} // END Если есть данные
    })
    
    return resp;

}

async function get_status(date, lesson, stud_id){
    var srvAdr = "serv/serv.php";

    var srvdat = new Object();     
    srvdat.get_comm = 9;            
    srvdat.date = date; 
    srvdat.lesson_number = lesson; 
    srvdat.stud_id = stud_id; 

    var resp = '';

    await $.get(srvAdr, srvdat, function(data){
        if (data.length > 0){ // Если есть данные 
            if (data != 'error'){
                resp = JSON.parse(data);
            }
        }else{alert("Нет ответа от сервера!");} // END Если есть данные
    })
    
    return resp;

}

async function get_attendance_data(date_from, date_to){
    var srvAdr = "serv/serv.php";

    var srvdat = new Object();     
    srvdat.get_comm = 7;            
    srvdat.date_from = date_from;  
    srvdat.date_to = date_to;

    var resp = '';

    await $.get(srvAdr, srvdat, function(data){
        if (data.length > 0){ // Если есть данные 
            if (data != 'error'){
                resp = JSON.parse(data);
            }
        }else{alert("Нет ответа от сервера!");} // END Если есть данные
    })
    
    return resp;
}


async function get_calendar_data(date_from, date_to){
    var srvAdr = "serv/serv.php";

    var srvdat = new Object();     
    srvdat.get_comm = 8;            
    srvdat.date_from = date_from;  
    srvdat.date_to = date_to;

    var resp = '';

    await $.get(srvAdr, srvdat, function(data){
        if (data.length > 0){ // Если есть данные 
            if (data != 'error'){
                resp = JSON.parse(data);

                //console.log(response);

                /*
                var stack = [];
                for(let i = 0; i < Object.keys(response).length; i++){
                    //alert(Object.keys(response).length);
                    
                    if (!stack.includes(response[i].date)){
                        $('.dates-tr').append('<td>' + response[i].date + '</td>');
                        stack.push(response[i].date);
                    }
                    
                    //var block = '<td>' + response[i].date + '</td>';
                    //$('.atten-headers').append(block);
                }
                */

                //console.log(stack);
            }
        }else{alert("Нет ответа от сервера!");} // END Если есть данные
    })
    
    return resp;
}

function open_attendance_page(){
    //alert('test');
    close_all_page();
    load_attendance_table();
    $('#attendance-page').removeClass('hide');
}

//alert(sessionStorage.getItem('username'));


if($.cookie('auth')){
    open_attendance_page();
}else{
    open_auth_page();
}
    

$(function(){
    $('.exit-from-account').on("click",function(){
        //alert('click');
        clear_auth_cookie();
        location.href="";
    });


    $('#submit').on("click",async function(){

        //$('table').remove();
        await load_attendance_table();

        const date_from = $('#date_start').val();
        const date_to = $('#date_end').val();

        //const calendar_data = await get_calendar_data(date_from, date_to);

        //Получаем календарь с расписаним за период
        const calendar_data = await get_calendar_data(date_from, date_to);
        console.log('Календарь: ');
        console.log(calendar_data);

        //Получаем посещаемость за период
        const attendance_data = await get_attendance_data(date_from, date_to);
        console.log('Посещаемость: ');
        console.log(attendance_data);


        //Получаем список студентов
        const students_list = await get_students();
        console.log('Студенты: ');
        console.log(students_list);

        


        var calendar_unick_dates = [];
        var dates_cnt = 0;

        var dates_p = 0;
        for(let i = 0; i < Object.keys(calendar_data).length; i++){
            //alert(Object.keys(response).length);
            
            if (!calendar_unick_dates.includes(calendar_data[i].date)){
                dates_cnt++;
                $('.dates-tr').append('<td class="' + calendar_data[i].date+ '" colspan="0">' + calendar_data[i].date + '</td>');
                calendar_unick_dates.push(calendar_data[i].date);

                /*
                var j=0;
                while(attendance_data[j].date == calendar_data[i].date){

                    if(!unick_lesson_numbers.includes(attendance_data[j].lesson_number)){
                        //console.log('asd' + attendance_data[j].date);
                        $('.atten-headers').append('<td class>' + attendance_data[j].lesson_number + '</td>');

                        var cur_colspan = $('.' + attendance_data[j].date).attr('colspan');
                        $('.' + attendance_data[j].date).attr('colspan', cur_colspan + 1);

                        unick_lesson_numbers.push(attendance_data[j].lesson_number);
                    }

                    j++;
                }
                */

                //console.log('qwe  ');

                var unick_lesson_numbers = []; 
                for(let j = dates_p; j < Object.keys(calendar_data).length; j++){
                    //console.log(j);
                    if (calendar_data[j].date == calendar_data[i].date){
                        //console.log(attendance_data[j].date);

                        if(!unick_lesson_numbers.includes(calendar_data[j].lesson_number)){
                            //console.log('asd  ' + attendance_data[j].date);
                            $('.atten-headers').append('<td lesson-number="'+ calendar_data[j].lesson_number  + '" lesson-date="'+ calendar_data[j].date  + '">' + calendar_data[j].lesson_number + '</td>');

                            //$('.atten-headers').append('<td lesson-number="'+ calendar_data[j].lesson_number  + '" lesson-date="'+ calendar_data[j].date  + '">' + calendar_data[j].lesson_number + '</td>');
                            var cur_colspan = $('.' + calendar_data[j].date).attr('colspan');
                            $('.' + calendar_data[j].date).attr('colspan', parseInt(cur_colspan) + 1);

                            unick_lesson_numbers.push(calendar_data[j].lesson_number);

                            for(let k = 0; k < Object.keys(students_list).length; k++){
                                //Получаем список студентов
                                const status_data = await get_status(calendar_data[j].date, calendar_data[j].lesson_number, students_list[k].stud_id);
                                //console.log('Статус: ');
                                //console.log(Object.keys(status_data).length);

                                //var s = status_data.status;
                                //console.log(s);

                                if (Object.keys(status_data).length > 0){
                                    $('.student-tr').filter('[student_id="'+ students_list[k].stud_id +'"]').append('<td>' + status_data[0].status + '</td>');
                                }else{
                                    $('.student-tr').filter('[student_id="'+ students_list[k].stud_id +'"]').append('<td></td>');
                                }
                                    

                                //console.log('test' + k);
                            }
                            /* третий фор
                                    проходим по списку студентов и проставляем необходимую отметку
                            */ 
                        }
                        
                    }else{
                        dates_p = j;
                        break;
                        //$('.atten-headers').append('<td class></td>');
                    }
                    
                }
            
            }
        }

        //console.log(stack);
        //alert(calendar_data);
        /*
        calendar_data.forEach(element => {
            $('tr')[1].val(element.date+'-'+element.leson_number);
        });
        */

        

    });


    $('#auth-submit-btn').on("click",function(){
        //alert('yes');
        var login = $('#login').val();
        var password = $('#password').val();

        if (login != '' && password != ''){
            var srvAdr = "serv/serv.php";

            var srvdat = new Object();                                        
            srvdat.get_comm = 1;  
            srvdat.login = login;
            srvdat.password = password;

            $.get(srvAdr, srvdat, function(data){ // POST Запрос
                if (data.length > 0){ // Если есть данные 
                    if (data != 'error'){
                        var response = JSON.parse(data);
                        alert(response.password);
                        $.cookie('auth', response.username, {path: '/' });
                        //alert($.cookie('auth'));
                        if(response.admin == 1){
                            $.cookie('admin', response.password, {path: '/' });
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
