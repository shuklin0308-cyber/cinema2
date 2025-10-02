<?php
header("Content-Type: text/html; charset=utf-8");
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная - Кинотеатр</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }
        .header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .welcome {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
        }
        .menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .menu-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: transform 0.3s;
        }
        .menu-card:hover {
            transform: translateY(-5px);
        }
        .menu-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }
        .user-info {
            float: right;
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5a67d8;
        }
        .btn-logout {
            background: #e53e3e;
        }
        .btn-logout:hover {
            background: #c53030;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>🎬 Система управления кинотеатром</h1>
            <div class="user-info">
                Добро пожаловать, <strong><?php echo $_SESSION['user']; ?></strong>
                <a href="logout.php" class="btn btn-logout">Выйти</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Главная панель управления</h2>
            <p>Выберите раздел для управления данными кинотеатра</p>
        </div>

        <div class="menu">
            <a href="films.php" class="menu-card">
                <div class="menu-icon">🎭</div>
                <h3>Управление фильмами</h3>
                <p>Добавление, редактирование и удаление фильмов</p>
            </a>
            
            <a href="#" class="menu-card">
                <div class="menu-icon">🏛️</div>
                <h3>Управление залами</h3>
                <p>Настройка кинозалов и мест</p>
            </a>
            
            <a href="#" class="menu-card">
                <div class="menu-icon">📅</div>
                <h3>Сеансы</h3>
                <p>Расписание сеансов и бронирование</p>
            </a>
            
            <a href="#" class="menu-card">
                <div class="menu-icon">🎫</div>
                <h3>Билеты</h3>
                <p>Продажа и управление билетами</p>
            </a>
        </div>
    </div>
</body>
</html>