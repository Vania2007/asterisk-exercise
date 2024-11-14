<?php
include 'db.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'title';

$filteredBooks = array_filter($books, function ($book) use ($query) {
    return stripos($book['title'], $query) !== false;
});

usort($filteredBooks, function ($a, $b) use ($sort) {
    return $a[$sort] <=> $b[$sort];
});
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
    <?php if (count($filteredBooks) > 0): ?>
        <table border='1' style="border-collapse: collapse;" >
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
            <?php endforeach;?>
        </table>
    <?php else: ?>
        <p>Книги не знайдено.</p>
    <?php endif;?>
    <br>
    <a href="index.php">Повернутися до пошуку</a>
</body>
</html>