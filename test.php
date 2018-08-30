<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
$string = file_get_contents(__DIR__.'\test.json');
$tests_data = json_decode($string, true);
$test_index = null;
if (isset($_GET['index'])) {
    $test_index = htmlspecialchars(($_GET['index']));
}
if ($test_index === null) {
    echo 'error: index undefined';
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') { ?>
    test: <?php echo $tests_data[$test_index]['testName'] ?><br\>
    <form action='' method='POST'>
    <?php foreach ($tests_data[$test_index]['questions'] as $question) { ?>
        <fieldset>
        <legend><?php echo $question['question'] ?></legend>
        <?php foreach ($question['answers'] as $i => $answer) { ?>
            <label><input type="checkbox" name="<?php echo $question['title'] ?>[]" value="<?php echo $i ?>"><?php echo $answer ?></label>
        <?php } ?>
        </fieldset>
    <?php } ?>
    <input type="submit" value="Отправить">
    </form>
<?php }
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = 0;
    foreach ($tests_data[$test_index]['questions'] as $i => $question_data) {
        if ($tests_data[$test_index]['questions'][$i]['result'] == $_POST[$tests_data[$test_index]['questions'][$i]['title']]) {
            $result += 1;
        }
    }
    echo 'Результат: '.$result.' из '.count($tests_data[$test_index]);
}
else {
    echo 'Request method undefined. Use "GET" or "POST".';
} ?>
</body>
</html>
