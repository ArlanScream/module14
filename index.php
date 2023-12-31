<!DOCTYPE html><html lang="en">
<?php
    session_start();
    $auth = $_SESSION['auth'] ?? null; // авторизация
    $nouser = isset($_SESSION['nouser']) ? 'Пользователя не существует' : null;
    $wrongPassword = isset($_SESSION['wrongpassword']) ? 'Неверный пароль' : null;

    $login = $_SESSION['login'] ?? null; // активный пользователь
    if($auth && $login !== 'admin'){
        $_SESSION[$login]['visit'] = $_SESSION[$login]['visit'] ?? 0; // число обновлений страницы активным пользователем
        $_SESSION[$login]['visit']++;
        $_SESSION[$login]['exit'] = $_SESSION[$login]['exit'] ?? 0;
    }

    $json['auth'] = $auth;
    $json['login'] = $login;
    $json['authtime'] = $_SESSION['authTime'] ?? 0; // время авторизации
    $json['birthday'] = $_SESSION[$login]['birthday'] ?? 0;
    $json['exit'] = $_SESSION[$login]['exit'];
    $json['visit'] =  $_SESSION[$login]['visit'];
    
    // var_dump($_SESSION);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/birthday.css">
    <link rel="stylesheet" href="css/loginWindow.css">
    <title> СПА-салон «SPA PRO»</title>
</head>

<body>
    <header class='header'>
        <!-- Кнопка входа/выхода -->
        <input type='button' class='header__btn' value=<?=$auth?'Выйти':'Войти'?>>
        <!-- имя пользователя и время входа -->
        <p class='header__user'></p>
        <!-- заголовок -->
        <p class='header__title'> <img src="img/icon.png" alt="СПА-салон"> SPA PRO</p>
        <!-- меню навигации -->
        <nav class="header__menu"><ul>
            <li><a href="#">Главная</a></li>
            <li><a href="#">Услуги</a></li>
            <li><a href="#">О нас</a></li>
            <li><a href="#">Контакты</a></li>
        </ul></nav>    
    </header>

    <main>
        <div class='stripes'></div>
        <!-- контейнер числа дней до ДР -->
        <p class='discount discountBirthday'></p>
        <!-- индивидуальная скидка -->
        <p class='discount discountUniq'></p>
        
        <?php
            include 'pages/loginWindow.php'; // модальное окно входа
            include 'pages/birthday.php';  // модальное окно ввода ДР

            if($auth){ 
                // при первом входе активируется индивидуальная скидка 
                if($_SESSION[$login]['visit'] == 1) $_SESSION[$login]['endDiscount'] = time() + 86400; // время конца скидки
                $json['endDiscount'] = $_SESSION[$login]['endDiscount'];             
                // отлов формы ввода ДР
                if (isset($_POST['birthday'])){
                    $_SESSION[$login]['visit']--; // не учитывается редирект
                    
                    // формирование даты ДР для подсчета числа дней до него
                    $birthDate = explode('-', $_POST['birthday']);
                    $birthDay = $birthDate[2];
                    $birthMonth = $birthDate[1];
                    if($birthMonth>date('m')) $birthYear = date('Y');
                    elseif($birthMonth===date('m') && $birthDay>=date('d')) $birthYear = date('Y');
                    else $birthYear = date('Y')+1;          

                    $_SESSION[$login]['birthday'] = mktime(0,0,0, $birthMonth, $birthDay, $birthYear); // запись ДР в секундах
                    header('Location: index.php');              
                }
            }         
        ?>

        <section class='container'>
            <section class='visit-card'>
                <p class='visit-card__company-name'> SPA PRO </p>
                <p class='visit-card__address'>Спа-Салон </p>
                <p class='visit-card__schedule'>Круглосуточно</p>
                <input type="button" class='visit-card__btn' value="Позвонить">
            </section>

            <h2 class='services-container__title'>Услуги</h2>
            <div class='services-container'>
            <section class='service'>
                <h3 class='service__title'>«Ледяной ананас»</h3>
                <img src="img/srv1.png" alt="">
                <p class='service__info'>Релакс процедура с лимфодренажным и детокс эффектом, разработанная специально для летнего сезона. Предотвращает застой жидкости в организме. Обладая свежим экзотическим ароматом, имеет эффект глубокого расслабления и аромарелакса.</p>
                <ul class='service__pricelist'>
                    <li>60 минут — <span class='service__price'>1600₽</span></li>
                    <li>90 минут — <span class='service__price'>3400₽</span></li>
                    <li>120 минут — <span class='service__price'>5200₽</span></li>
                </ul>
            </section>

            <section class='service'> 
                <h3 class='service__title'>Талассо Магнезиум</h3>
                <img src="img/srv2.png" alt="">
                <p class='service__info'>Массаж расслабляет все тело, уходят зажимы, восстанавливается подвижность тела.</p>
                <ul class='service__pricelist'>
                    <li>60 минут — <span class='service__price'>3600₽</span></li>
                    <li>90 минут — <span class='service__price'>5400₽</span></li>
                    <li>120 минут — <span class='service__price'>7200₽</span></li>
                </ul>
            </section>
            <section class='service'>
                <h3 class='service__title'>SPA-ритуал «Турецкий мыльный массаж»</h3>
                <img src="img/srv3.png" alt="">
                <p class='service__info'>Выполняется движениями от конечностей к центру тела.
                    Перед массажем нужно выпить стакан воды. 
                    Хорошо устраняет отечность тела. Легкость, здоровье, стройность.</p>
                <ul class='service__pricelist'>
                    <li>60 минут — <span class='service__price'>3900₽</span></li>
                    <li>90 минут — <span class='service__price'>5800₽</span></li>
                    <li>120 минут — <span class='service__price'>7800₽</span></li>
                </ul>
            </section>

            <section class='service'>
                <h3 class='service__title'>SPA-ритуал "ШокоСПА "</h3>
                <img src="img/srv4.png" alt="">
                <p class='service__info'>Баунти — самая экзотическая программа со вкусом кокоса и натурального темного шоколада.
                Кокосовое молоко, мякоть и живительное кокосовое масло с древних времен используют в Таиланде 
                для оздоровления всего организма, ухода за кожей и волосами.</p>
                <ul class='service__pricelist'>
                    <li>150 минут — <span class='service__price'>9000₽</span></li>
                </ul>
            </section>
            </div>
        </section>
    </main>

    <footer class='footer'>
            <p>8 (888) 999-99-99</p>
            <p>Электронная почта:a@mail.ru</p>
            <p>Номер медицинской лицензии ЛО-76-01-002267 от 25.02.2020 г.</p>
            <p>СПА Салон ООО "SPA PRO"</p>
    </footer>

    <?php
        unset($_SESSION['nouser']);
        unset($_SESSION['password']);
    ?>
    
    <div id="data-php" data-json=<?=json_encode($json)?>></div>
    <script type='text/javascript' src='js/dateFunc.js'></script>
    <script type='text/javascript' src='js/index.js'></script>
    <script type='text/javascript' src='js/loginInputWindow.js'></script>
    <script type='text/javascript' src='js/birthday.js'></script>
</body>
</html>
