<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coding Academy PHP Tasks - Part 2</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; color: #333; }
        h1 { color: #ff6600; text-align: center; }
        h2 { border-bottom: 2px solid #ff6600; padding-bottom: 5px; margin-top: 40px; color: #444; }
        .exercise { background: #fdfdfd; border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-left: 4px solid #ff6600; border-radius: 4px; }
    </style>
</head>
<body>

<h1>Coding Academy - PHP Tasks Part 2 Solutions</h1>

<?php
// ==========================================
// 1. PHP STRING AND STRING FUNCTIONS
// ==========================================
echo "<h2>1. PHP String and String Functions</h2>";
?>

<div class="exercise">
    <h3>String Task 1: String to Array (var_dump)</h3>
    <?php
    $string = "Twinkle, twinkle, little star.";
    $stringArray = explode(",", $string);
    echo "<pre>";
    var_dump($stringArray);
    echo "</pre>";
    ?>
</div>

<div class="exercise">
    <h3>String Task 2: Next Letter</h3>
    <?php
    function getNextLetter($char) {
        if ($char === 'z') return 'a';
        if ($char === 'Z') return 'A';
        return chr(ord($char) + 1);
    }
    echo "Input 'a' -> Output: '" . getNextLetter('a') . "'<br>";
    echo "Input 'z' -> Output: '" . getNextLetter('z') . "'";
    ?>
</div>

<div class="exercise">
    <h3>String Task 3: Insert String at Position</h3>
    <?php
    $original = 'The brown fox';
    $inserted = substr_replace($original, 'quick ', 4, 0);
    echo "Expected: " . $inserted;
    ?>
</div>

<div class="exercise">
    <h3>String Task 4: Get First Word</h3>
    <?php
    $sentence = 'The quick brown fox';
    $firstWord = strtok($sentence, ' ');
    echo "Expected: " . $firstWord;
    ?>
</div>

<div class="exercise">
    <h3>String Task 5: Remove Zeroes from Number</h3>
    <?php
    $numStr = '0000657022.24';
    $cleanedNum = str_replace('0', '', $numStr);
    echo "Expected: " . $cleanedNum;
    ?>
</div>

<div class="exercise">
    <h3>String Task 6: Remove Trailing Dashes</h3>
    <?php
    $dashStr = 'The quick brown fox jumps over the lazy dog---';
    $trimmedStr = rtrim($dashStr, '-');
    echo "Expected: " . $trimmedStr;
    ?>
</div>

<div class="exercise">
    <h3>String Task 7: Select First 5 Words</h3>
    <?php
    $longStr = 'The quick brown fox jumps over the lazy dog';
    $wordsArray = array_slice(explode(' ', $longStr), 0, 5);
    $firstFive = implode(' ', $wordsArray);
    echo "Expected: " . $firstFive;
    ?>
</div>

<div class="exercise">
    <h3>String Task 8: Remove Commas from Numeric String</h3>
    <?php
    $numericStr = '2,543.12';
    $resultNum = str_replace(',', '', $numericStr);
    echo "Expected: " . $resultNum;
    ?>
</div>

<?php
// ==========================================
// 2. LOOPS
// ==========================================
echo "<h2>2. Loops</h2>";
?>

<div class="exercise">
    <h3>Loop Task 1: Fibonacci Sequence</h3>
    <?php
    $fib = [0, 1];
    for ($i = 2; $i < 10; $i++) {
        $fib[$i] = $fib[$i - 1] + $fib[$i - 2];
    }
    echo implode(', ', $fib) . ", ...";
    ?>
</div>

<div class="exercise">
    <h3>Loop Task 2: Floyd's Triangle</h3>
    <?php
    $n = 5;
    $num = 1;
    for ($i = 1; $i <= $n; $i++) {
        for ($j = 1; $j <= $i; $j++) {
            echo $num++ . " ";
        }
        echo "<br>";
    }
    ?>
</div>

<div class="exercise">
    <h3>Loop Task 3: Alphabet Pattern</h3>
    <?php
    $letters = range('A', 'E');
    // Ascending part
    for ($i = 0; $i < count($letters); $i++) {
        for ($j = 0; $j <= $i; $j++) {
            echo $letters[$j] . " ";
        }
        echo "<br>";
    }
    // Descending part
    for ($i = count($letters) - 2; $i >= 0; $i--) {
        for ($j = 0; $j <= $i; $j++) {
            echo $letters[$j] . " ";
        }
        echo "<br>";
    }
    ?>
</div>

<?php
// ==========================================
// 3. LOGICAL STATEMENTS AND OPERATORS
// ==========================================
echo "<h2>3. Logical Statements and Operators</h2>";
?>

<div class="exercise">
    <h3>Logical Task 1: Leap Year Check</h3>
    <?php
    $year = 2013;
    if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
        echo "$year is a leap year";
    } else {
        echo "This year is not a leap year";
    }
    ?>
</div>

<div class="exercise">
    <h3>Logical Task 2: Season Check</h3>
    <?php
    $temperature = 27;
    if ($temperature < 20) {
        echo "It is wintertime!";
    } else {
        echo "It is summertime!";
    }
    ?>
</div>

<div class="exercise">
    <h3>Logical Task 3: Sum / Triple Sum</h3>
    <?php
    $firstInteger = 2;
    $secondInteger = 2;
    $sum = $firstInteger + $secondInteger;
    if ($firstInteger === $secondInteger) {
        $result = ($sum) * 3;
        echo "($firstInteger+$secondInteger)*3=$result";
    } else {
        echo $sum;
    }
    ?>
</div>

<div class="exercise">
    <h3>Logical Task 4: Numbers Divisible by 4 (200 to 250)</h3>
    <?php
    $divisible = [];
    for ($i = 200; $i <= 250; $i += 4) {
        $divisible[] = $i;
    }
    echo implode(',', $divisible);
    ?>
</div>

<div class="exercise">
    <h3>Logical Task 5: Unique Random 10 Numbers</h3>
    <?php
    $numbers = range(11, 20);
    shuffle($numbers);
    echo implode(' ', $numbers);
    ?>
</div>

</body>
</html>