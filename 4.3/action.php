<?php
include 'db.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'title';

$filteredBooks = array_filter($books, function ($book) use ($query) {
    return stripos($book['title'], $query) !== false ||
           stripos($book['author'], $query) !== false ||
           stripos($book['year'], $query) !== false;
});

if (empty($query)) {
    $filteredBooks = $books;
}

if (!empty($sort)) {
    usort($filteredBooks, function ($a, $b) use ($sort) {
        return $a[$sort] <=> $b[$sort];
    });
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результати пошуку</title>
</head>
<body>
    <h1>Результати пошуку</h1>
    
    <form action="action.php" method="GET">
        <label for="query">Введіть частину назви книги:</label>
        <input type="text" id="query" name="query" value="<?= htmlspecialchars($query) ?>">
        <input type="submit" value="Пошук">
    </form>
    
    <br/>
    <form action="action.php" method="GET">
        <label for="sort">Сортувати за:</label>
        <select id="sort" name="sort">
            <option value="author" <?= $sort == 'author' ? 'selected' : '' ?>>Ім'я автора</option>
            <option value="title" <?= $sort == 'title' ? 'selected' : '' ?>>Назва книги</option>
            <option value="year" <?= $sort == 'year' ? 'selected' : '' ?>>Рік видання</option>
        </select>
        <input type="hidden" name="query" value="<?= htmlspecialchars($query) ?>">
        <input type="submit" value="Сортувати">
    </form>
    
    <br/>

    <?php if (count($filteredBooks) > 0): ?>
        <table border='1' style="border-collapse: collapse;">
            <tr>
                <th>Назва книги</th>
                <th>Автор</th>
                <th>Рік видання</th>
            </tr>
            <?php foreach ($filteredBooks as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['year']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Книги не знайдено.</p>
    <?php endif; ?>
    <br>
    <a href="index.php">Повернутися до пошуку</a>
</body>
</html>