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

    if (isset($_POST['letter'])) {
        $letter = mb_strtolower(trim($_POST['letter']));
        if (mb_strlen($letter) === 1 && !in_array($letter, $guesses)) {
            $guesses[] = $letter;
            if (mb_strpos($word, $letter) === false) {
                $attempts++;
            }
        }
    }
}

foreach (mb_str_split($word) as $index => $char) {
    if (in_array($char, $guesses) || $index === 0 || $index === mb_strlen($word) - 1) {
        $word_display .= $char;
    } else {
        $word_display .= '_';
    }
}

if ($attempts >= $max_attempts) {
    echo "<p>Вы проиграли! Загаданное слово: $word.</p><br/>
    <a href='?reset=1'>Начать заново</a>";
    exit;
}

if ($word_display === $word) {
    echo "<p>Вы победили! Загаданное слово действительно: $word.</p><br/>
    <a href='?reset=1'>Начать заново</a>";
    exit;
}
$guessed_letters = array_filter($guesses);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Шибениця</title>
</head>
<body>
    <h1>Гра Шибениця</h1>
    <p>Невдалих спроб: <?=$attempts?> з <?=$max_attempts?></p>
    <p>Слово: <?=$word_display?></p>
    <p>Запропоновані літери: <?=htmlspecialchars(implode(', ', $guessed_letters))?></p>
    <form method="post">
        <input type="hidden" name="word" value="<?=htmlspecialchars($word)?>">
        <input type="hidden" name="guesses" value="<?=htmlspecialchars(implode(',', $guessed_letters))?>">
        <input type="hidden" name="attempts" value="<?=$attempts?>">
        <label for="letter">Введіть літеру:</label>
        <input type="text" name="letter" id="letter" maxlength="1" required>
        <input type="submit" value="Надіслати">
    </form>
</body>
</html>