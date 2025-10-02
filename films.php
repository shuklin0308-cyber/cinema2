<?php
header("Content-Type: text/html; charset=utf-8");
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
include "config.php";

$message = "";

// Добавление фильма
if (isset($_POST['add'])) {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $year = intval($_POST['year']);
    
    if ($title && $genre && $year >= 1900 && $year <= date('Y') + 5) {
        if (addFilm($title, $genre, $year)) {
            $message = "<div class='success'>Фильм успешно добавлен!</div>";
        }
    } else {
        $message = "<div class='error'>Заполните все поля корректно!</div>";
    }
}

// Удаление фильма
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if (deleteFilm($id)) {
        $message = "<div class='success'>Фильм удален!</div>";
    }
}

// Обновление фильма
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $year = intval($_POST['year']);
    
    if ($title && $genre && $year >= 1900 && $year <= date('Y') + 5) {
        if (updateFilm($id, $title, $genre, $year)) {
            $message = "<div class='success'>Фильм обновлен!</div>";
        }
    } else {
        $message = "<div class='error'>Заполните все поля корректно!</div>";
    }
}

$films = getFilms();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление фильмами - Кинотеатр</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        input:focus {
            border-color: #667eea;
            outline: none;
        }
        .btn {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #5a67d8;
        }
        .btn-danger {
            background: #e53e3e;
        }
        .btn-danger:hover {
            background: #c53030;
        }
        .btn-success {
            background: #38a169;
        }
        .btn-success:hover {
            background: #2f855a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background: #f7fafc;
            font-weight: bold;
            color: #4a5568;
        }
        tr:hover {
            background: #f8fafc;
        }
        .success {
            background: #c6f6d5;
            color: #22543d;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #48bb78;
        }
        .error {
            background: #fed7d7;
            color: #c53030;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #fc8181;
        }
        .form-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 10px;
            align-items: end;
        }
        .actions {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>🎭 Управление фильмами</h1>
            <a href="index.php" class="btn">← Назад</a>
        </div>
    </div>

    <div class="container">
        <?php echo $message; ?>

        <div class="card">
            <h2>Добавить новый фильм</h2>
            <form method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label>Название фильма</label>
                        <input type="text" name="title" placeholder="Введите название" required>
                    </div>
                    <div class="form-group">
                        <label>Жанр</label>
                        <input type="text" name="genre" placeholder="Жанр" required>
                    </div>
                    <div class="form-group">
                        <label>Год выпуска</label>
                        <input type="number" name="year" min="1900" max="<?php echo date('Y') + 5; ?>" placeholder="2024" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="add" class="btn btn-success">Добавить</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <h2>Список фильмов (<?php echo count($films); ?>)</h2>
            <?php if (count($films) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Жанр</th>
                        <th>Год</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($films as $film): ?>
                        <tr>
                            <form method='post'>
                            <td><?php echo $film['id']; ?>
                                <input type='hidden' name='id' value='<?php echo $film['id']; ?>'>
                            </td>
                            <td>
                                <input type='text' name='title' value='<?php echo htmlspecialchars($film['title']); ?>' required>
                            </td>
                            <td>
                                <input type='text' name='genre' value='<?php echo htmlspecialchars($film['genre']); ?>' required>
                            </td>
                            <td>
                                <input type='number' name='year' value='<?php echo $film['year']; ?>' min="1900" max="<?php echo date('Y') + 5; ?>" required>
                            </td>
                            <td class="actions">
                                <button type='submit' name='update' class='btn'>Изменить</button>
                                <a href='?delete=<?php echo $film['id']; ?>' class='btn btn-danger' 
                                   onclick="return confirm('Удалить фильм <?php echo htmlspecialchars($film['title']); ?>?')">Удалить</a>
                            </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p style="text-align: center; padding: 20px; color: #666;">Фильмов пока нет. Добавьте первый фильм!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>