<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бібліотека</title>
</head>
<body>
    <h1>Пошук книг</h1>
    <form action="action.php" method="GET">
        <label for="query">Введіть частину назви книги:</label>
        <input type="text" id="query" name="query" required>
        <br>
        <label for="sort">Сортувати за:</label>
        <select id="sort" name="sort">
            <option value="author">Ім'я автора</option>
            <option value="title">Назва книги</option>
            <option value="year">Рік видання</option>
        </select>
        <br>
        <input type="submit" value="Пошук">
    </form>
</body>
</html>