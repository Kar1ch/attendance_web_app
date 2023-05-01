<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js</script>
        <script src="js/jquery.cookies.js"></script>
        <script><?php include "js/scripts.js";?></script>

        <style><?php include "css/styles.css";?></style>
    </head>
    <body>
        <main id="auth-page" class="hide">
            <div class="auth-header">Авторизация</div>

            <div class="auth-content">
                <div class="auth-form">
                    <input type="text" class="auth-input" id="login" placeholder="Ваше ФИО"/>
                    <input type="text" class="auth-input" id="password" placeholder="Пароль"/>
                    <div id='auth-fields-not-filled' class="hide">Все поля должны быть заполнены</div>
                    <input type="button" class="auth-submit" id="auth-submit-btn" value="Войти"/>
                </div>
            </div>
        </main>

        <main id="attendance-page" class="hide">
            <div class="attendance-header">
                <span class="exit-from-account">Выйти</span>
                <span class="attendance-header-text">Посещаемость</span>
            </div>

            <div class="attendance-content">
                <div class="user-attendance">

                </div>
            </div>
        </main>
    </body>
</html>
