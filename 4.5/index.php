<?php
$words = ['парк', 'квітник', 'гра', 'вітер', 'гай', 'дощ', 'алея', 'краєвид', 'фонтан'];

$word = '';
$guesses = [];
$attempts = 0;
$max_attempts = 6;
$word_display = '';

if (!isset($_POST['word'])) {
    $word = $words[array_rand($words)];
} else {
    $word = $_POST['word'];
    $guesses = isset($_POST['guesses']) ? explode(',', $_POST['guesses']) : [];
    $attempts = intval($_POST['attempts']);
    $max_attempts = 6;

    if (isset($_POST['letter'])) {
        $letter = mb_strtolower(trim($_POST['letter']));
        if (mb_strlen($letter) === 1 && !in_array($letter, $guesses)) {
            $guesses[] = $letter;
            if (strpos($word, $letter) === false) {
                $attempts++;
            }
        }
    }
}

foreach (mb_str_split($word) as $char) {
    $word_display .= in_array($char, $guesses) ? $char : '_';
}

if ($attempts >= $max_attempts) {
    echo "<p>Ви програли! Загадане слово: $word.</p><br/>
    <a href='?reset=1'>Почати заново</a>";
    exit;
}

if ($word_display === $word) {
    echo "<p>Ви перемогли! Загадане слово спраді: $word.</p><br/>
    <a href='?reset=1'>Почати заново</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Шибениця</title>
</head>
<body>
    <h1>Гра Шибениця</h1>
    <p>Спроби: <?=$attempts?> из <?=$max_attempts?></p>
    <p>Слово: <?=$word_display?></p>
    <p>Запропоновані літери: <?=implode(', ', $guesses)?></p>
    <form method="post">
        <input type="hidden" name="word" value="<?=htmlspecialchars($word)?>">
        <input type="hidden" name="guesses" value="<?=htmlspecialchars(implode(',', $guesses))?>">
        <input type="hidden" name="attempts" value="<?=$attempts?>">
        <label for="letter">Введіть літеру:</label>
        <input type="text" name="letter" id="letter" maxlength="1" required>
        <input type="submit" value="Надіслати">
    </form>
</body>
</html>