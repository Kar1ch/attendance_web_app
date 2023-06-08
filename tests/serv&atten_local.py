# --- Настройка окружения ---
#
# Для начала тестировки на компьютер с Ubuntu 22.04.2 LTS были установлены и настроены 
# The Apache HTTP Server и MySQL Cluster Community Server. С сервера на локальный компьютер 
# была экспортирована база данных и исходный код проекта.
#
# --- Тест ---
#
# На данный момент тест способен проверять команды из модулей serv.php и atten.php. 
# Некоторые функции требуют дополнительно id администратора, указанного в базе.
# Вывод 1 означает, что произошел сбой, вывод 0 означает, что тест прошел успешно.



import mysql.connector
import requests
import json


default_query="SELECT name FROM students order by name"
# Запрос к локальной базе данных.
def bdquery(query=default_query):

    config = {
              'user': 'root',
              'password': '*********',
              'host': 'localhost',
              'database': 'attendance',
              'raise_on_warnings': True,
             }
    try:

        db = mysql.connector.connect(**config)
        cursor = db.cursor()

        cursor.execute(query)
        result = cursor.fetchall()

        cursor.close()
        db.close()       

        #print(result)   
    
    except mysql.connector.Error as e: 

        print(e)

    return result


default_url="http://192.168.1.79:2222/attendance_web_app/serv/serv.php"
# Запрос к локальному серверу.
def servquery(url=default_url, payload={'get_comm' : 1,}):

    #admin_id = "***********"
    #url = 'http://192.168.1.79:2222/attendance_web_app/serv/atten.php'
    #payload = {'py_get_comm' : 1,}
    
    x = requests.get(url, params=payload)
    #print(x.text)
    response = json.loads(x.text)

    #print(response)
    
    #sprint(response[0]['name'])
    #response = requests.get(url, params=payload)
    #print(response)
    #if response.status_code == 200:
    #    x = json.loads(response.text)
    #    print(x[0])
        #pass
        #data = response.json()
        #print(data)
    #else:
    #    print('Ошибка при запросе данных.')
        
    return response


def comparaison(bdans, servans):
    #post get & query k bd
    print(bdans == servans)

def comparaison_main(bdans, servans):
    s1, s2 = '',''

    print(bdans, "\n", servans)
    for i in bdans:
        s1+= str(i[0])
    for i in servans:
        s2+= str(i["name"])
    print(s1, "\n", s2)

    return 0 if s1==s2 else 1

def comparaison_atten(bdans, servans):
    s1, s2 = '',''

    print(bdans, "\n", servans)
    for i in bdans:
        s1+= str(i[2])
    for i in servans:
        s2+= str(i["name"])
    #print(s1, "\n", s2)

    return 0 if s1==s2 else 1


# TODO 
#
# 1. Копируем запросы из php -- любую команду
# 2. Сравнение sql запросов
# 3. ...
# 4. SUCCESS!

print("Тест команды номер 6 из serv.php")

bdans = bdquery()

servans = servquery(payload={'get_comm' : 6, 'admin_id' : '9ea9c37839152fb8f5ca72ffce02b9ad'})

print(comparaison_main(bdans, servans))

print("\nТест команды номер 1 из atten.php")

bdans = bdquery("SELECT * FROM `students`")

servans = servquery(
    payload={'py_get_comm' : 1}, 
    url="http://192.168.1.79:2222/attendance_web_app/serv/atten.php"
    )

print(comparaison_atten(bdans, servans))

print("\nТест команды номер 1 из atten.php")

bdans = bdquery("SELECT * FROM `students`")

servans = servquery(
    payload={'py_get_comm' : 1}, 
    url="http://192.168.1.79:2222/attendance_web_app/serv/atten.php"
    )

print(comparaison_atten(bdans, servans))


print(comparaison_6(bdans, servans))
