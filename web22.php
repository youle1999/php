<?php
session_start();

// Load the CSV file
$file = fopen('kencho.csv', 'r');
$questions = fgetcsv($file);
$answers = fgetcsv($file);
fclose($file);

// Check if a question has been answered or a new question is requested
if (isset($_POST['answer'])) {
    // Check the user's answer
    $questionIndex = $_SESSION['question_index'];
    $userAnswer = trim($_POST['answer']);
    $correctAnswer = $answers[$questionIndex];

    if ($userAnswer === $correctAnswer) {
        $result = "正解！";
    } else {
        $result = "不正解 (正解は{$correctAnswer}です)";
    }

} else {
    // If no answer has been provided yet, just select a random question
    $questionIndex = array_rand($questions);
    $_SESSION['question_index'] = $questionIndex;
    $result = "";
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>県庁所在地クイズ</title>
</head>
<body>
    <h2>22. 県庁所在地クイズ</h2>
    
    <!-- Move the "次の問題" button to the top of the form -->
    <form method="post">
        <button type="submit" name="next_question">次の問題</button>
    </form>

    <form method="post">
        <input type="hidden" name="question_index" value="<?php echo $_SESSION['question_index']; ?>">
        <p>問題: <?php echo $questions[$_SESSION['question_index']]; ?>の県庁所在地はどこですか？</p>
        <label for="answer">答え:</label>
        <input type="text" name="answer" id="answer">
        <button type="submit">解答</button>
    </form>

    <?php if (!empty($result)): ?>
        <h3>結果表示</h3>
        <p><?php echo $result; ?></p>
    <?php endif; ?>
</body>
</html>
