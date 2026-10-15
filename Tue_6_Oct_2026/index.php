<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coding Academy PHP Tasks - Complete Solution</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; color: #333; }
        h1 { color: #ff6600; text-align: center; }
        h2 { border-bottom: 2px solid #ff6600; padding-bottom: 5px; margin-top: 40px; color: #444; }
        .exercise { background: #fdfdfd; border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-left: 4px solid #ff6600; border-radius: 4px; }
        table { border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #ccc; padding: 5px 10px; text-align: center; }
    </style>
</head>
<body>

<h1>Coding Academy - PHP Tasks Solutions</h1>

<?php
// ==========================================
// 1. ARRAY EXERCISES
// ==========================================
echo "<h2>1. Array Exercises</h2>";
?>

<div class="exercise">
    <h3>Exercise 1: Colors Unordered List</h3>
    <?php
    $colors = array('white', 'green', 'red');
    sort($colors);
    echo "<ul>";
    foreach ($colors as $color) {
        echo "<li>$color</li>";
    }
    echo "</ul>";
    ?>
</div>

<div class="exercise">
    <h3>Exercise 2: Cities Sorted by Capital</h3>
    <?php
    $cities = array(
        "Italy" => "Rome", "Luxembourg" => "Luxembourg", "Belgium" => "Brussels",
        "Denmark" => "Copenhagen", "Finland" => "Helsinki", "France" => "Paris", 
        "Slovakia" => "Bratislava", "Slovenia" => "Ljubljana", "Germany" => "Berlin", 
        "Greece" => "Athens", "Ireland" => "Dublin", "Netherlands" => "Amsterdam", 
        "Portugal" => "Lisbon", "Spain" => "Madrid"
    );
    
    asort($cities);
    foreach ($cities as $country => $capital) {
        echo "The capital of $country is $capital<br>";
    }
    ?>
</div>

<div class="exercise">
    <h3>Exercise 3: First Element of Array</h3>
    <?php
    $color = array(4 => 'white', 6 => 'green', 11 => 'red');
    echo reset($color);
    ?>
</div>

<div class="exercise">
    <h3>Exercise 4: Insert Item in Array</h3>
    <?php
    $array = array(1, 2, 3, 4, 5);
    $location = 3; 
    $newItem = '$';
    
    array_splice($array, $location, 0, $newItem);
    echo implode('', $array);
    ?>
</div>

<div class="exercise">
    <h3>Exercise 5: Sort Associative Array by Value</h3>
    <?php
    $fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
    asort($fruits);
    foreach ($fruits as $key => $value) {
        echo "\$$key = \$ $value<br>";
    }
    ?>
</div>

<div class="exercise">
    <h3>Exercise 6: Temperature Statistics</h3>
    <?php
    $temps = array(78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73);
    $avg = array_sum($temps) / count($temps);
    echo "Average Temperature is: " . round($avg, 1) . "<br>";
    
    $unique_temps = array_unique($temps);
    sort($unique_temps);
    echo "List of five lowest temperatures: " . implode(', ', array_slice($unique_temps, 0, 5)) . "<br>";
    
    rsort($unique_temps);
    echo "List of five highest temperatures: " . implode(', ', array_slice($unique_temps, 0, 5)) . "<br>";
    ?>
</div>

<div class="exercise">
    <h3>Exercise 7: Merge Arrays</h3>
    <?php
    $array1 = array("color" => "red", 2, 4);
    $array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
    $merged = array_merge($array1, $array2);
    echo "<pre>";
    print_r($merged);
    echo "</pre>";
    ?>
</div>

<div class="exercise">
    <h3>Exercise 8: Uppercase Array Strings</h3>
    <?php
    $colorsArray = array("red", "blue", "white", "yellow");
    $upperColors = array_map('strtoupper', $colorsArray);
    echo "<pre>";
    print_r($upperColors);
    echo "</pre>";
    ?>
</div>

<?php
// ==========================================
// 2. FUNCTION EXERCISES
// ==========================================
echo "<h2>2. Function Exercises</h2>";
?>

<div class="exercise">
    <h3>Function 1: Prime Number Check</h3>
    <?php
    function checkPrime($n) {
        if ($n <= 1) return false;
        for ($i = 2; $i <= sqrt($n); $i++) {
            if ($n % $i == 0) return false;
        }
        return true;
    }
    $num = 3;
    if (checkPrime($num)) {
        echo "$num is a prime number";
    } else {
        echo "$num is not a prime number";
    }
    ?>
</div>

<div class="exercise">
    <h3>Function 2: Reverse String</h3>
    <?php
    function reverseMyString($str) {
        return strrev($str);
    }
    echo reverseMyString("remove");
    ?>
</div>

<div class="exercise">
    <h3>Function 3: Swap Two Variables</h3>
    <?php
    function swapVars(&$a, &$b) {
        $temp = $a;
        $a = $b;
        $b = $temp;
    }
    $x = 12; $y = 10;
    swapVars($x, $y);
    echo "y=$y x=$x";
    ?>
</div>

<div class="exercise">
    <h3>Function 4: Armstrong Number</h3>
    <?php
    function checkArmstrong($number) {
        $sum = 0;
        $temp = $number;
        $len = strlen((string)$number);
        while ($temp > 0) {
            $digit = $temp % 10;
            $sum += pow($digit, $len);
            $temp = (int)($temp / 10);
        }
        return $sum == $number;
    }
    $armInput = 407;
    if (checkArmstrong($armInput)) {
        echo "$armInput is Armstrong Number";
    } else {
        echo "$armInput is not an Armstrong Number";
    }
    ?>
</div>

<div class="exercise">
    <h3>Function 5: Palindrome Check</h3>
    <?php
    function checkPalindrome($string) {
        $clean = strtolower(preg_replace("/[^A-Za-z0-9]/", '', $string));
        return $clean === strrev($clean);
    }
    $palInput = "Eva, can I see bees in a cave?";
    echo checkPalindrome($palInput) ? "Yes it is a palindrome" : "No it is not a palindrome";
    ?>
</div>

<div class="exercise">
    <h3>Function 6: Remove Duplicates from Array</h3>
    <?php
    function removeArrayDuplicates($arr) {
        return array_values(array_unique($arr));
    }
    $array1 = array(2, 4, 7, 4, 8, 4);
    $resArray = removeArrayDuplicates($array1);
    echo "\$array1 array(" . implode(', ', $resArray) . ")";
    ?>
</div>

<?php
// ==========================================
// 3. LOGICAL STATEMENTS AND OPERATORS
// ==========================================
echo "<h2>3. Logical Statements and Operators</h2>";
?>

<div class="exercise">
    <h3>Logical 1: Sum Check</h3>
    <?php
    function testSum($a, $b) {
        $sum = $a + $b;
        return ($sum == 30) ? $sum : 'false';
    }
    echo testSum(10, 10);
    ?>
</div>

<div class="exercise">
    <h3>Logical 2: Multiple of 3</h3>
    <?php
    function checkMultipleOf3($n) {
        return ($n > 0 && $n % 3 == 0) ? 'true' : 'false';
    }
    echo checkMultipleOf3(20);
    ?>
</div>

<div class="exercise">
    <h3>Logical 3: Range Check</h3>
    <?php
    function checkRange($n) {
        return ($n >= 20 && $n <= 50) ? 'true' : 'false';
    }
    echo checkRange(50);
    ?>
</div>

<div class="exercise">
    <h3>Logical 4: Largest Number</h3>
    <?php
    $intList = [1, 5, 9];
    echo max($intList);
    ?>
</div>

<div class="exercise">
    <h3>Logical 5: Electricity Bill</h3>
    <?php
    function calcElectricityBill($units) {
        $bill = 0;
        if ($units <= 50) {
            $bill = $units * 2.50;
        } elseif ($units <= 150) {
            $bill = (50 * 2.50) + (($units - 50) * 5.00);
        } elseif ($units <= 250) {
            $bill = (50 * 2.50) + (100 * 5.00) + (($units - 150) * 6.20);
        } else {
            $bill = (50 * 2.50) + (100 * 5.00) + (100 * 6.20) + (($units - 250) * 7.50);
        }
        return $bill . " JOD";
    }
    echo "Bill for 200 units: " . calcElectricityBill(200);
    ?>
</div>

<div class="exercise">
    <h3>Logical 6: Simple Calculator</h3>
    <?php
    function simpleCalc($num1, $num2, $op) {
        switch ($op) {
            case '+': return $num1 + $num2;
            case '-': return $num1 - $num2;
            case '*': return $num1 * $num2;
            case '/': return ($num2 != 0) ? $num1 / $num2 : "Cannot divide by zero";
            default: return "Invalid operator";
        }
    }
    echo "10 * 5 = " . simpleCalc(10, 5, '*');
    ?>
</div>

<div class="exercise">
    <h3>Logical 7: Voting Eligibility</h3>
    <?php
    $age = 15;
    echo ($age >= 18) ? 'Eligible to vote' : 'is no eligible to vote';
    ?>
</div>

<div class="exercise">
    <h3>Logical 8: Sign Check</h3>
    <?php
    $val = -60;
    if ($val > 0) echo 'Positive';
    elseif ($val < 0) echo 'Negative';
    else echo 'Zero';
    ?>
</div>

<div class="exercise">
    <h3>Logical 9: Student Grade</h3>
    <?php
    $scores = [60, 86, 95, 63, 55, 74, 79, 62, 50];
    $avgScore = array_sum($scores) / count($scores);
    if ($avgScore < 60) $grade = 'F';
    elseif ($avgScore < 70) $grade = 'D';
    elseif ($avgScore < 80) $grade = 'C';
    elseif ($avgScore < 90) $grade = 'B';
    else $grade = 'A';
    echo "Grade: '$grade'";
    ?>
</div>

<?php
// ==========================================
// 4. LOOPS EXERCISES
// ==========================================
echo "<h2>4. Loops Exercises</h2>";
?>

<div class="exercise">
    <h3>Loop 1: Number Sequence</h3>
    <?php
    $seq = [];
    for ($i = 1; $i <= 10; $i++) {
        $seq[] = $i;
    }
    echo implode('-', $seq);
    ?>
</div>

<div class="exercise">
    <h3>Loop 2: Sum 0 to 30</h3>
    <?php
    $total = 0;
    for ($i = 0; $i <= 30; $i++) {
        $total += $i;
    }
    echo "Total: $total";
    ?>
</div>

<div class="exercise">
    <h3>Loop 3: Pattern A-E</h3>
    <?php
    $letters = ['A', 'B', 'C', 'D', 'E'];
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            echo ($i == $j) ? $letters[$i] : 'A';
        }
        echo "<br>";
    }
    ?>
</div>

<div class="exercise">
    <h3>Loop 4: Number Matrix</h3>
    <?php
    for ($i = 1; $i <= 5; $i++) {
        for ($j = 1; $j <= 5; $j++) {
            echo ($j == 5) ? "$i " : "1 ";
        }
        echo "<br>";
    }
    ?>
</div>

<div class="exercise">
    <h3>Loop 5: Diagonal Matrix</h3>
    <?php
    for ($i = 1; $i <= 5; $i++) {
        for ($j = 1; $j <= 5; $j++) {
            echo ($i == $j) ? "$i " : "0 ";
        }
        echo "<br>";
    }
    ?>
</div>

<div class="exercise">
    <h3>Loop 6: Factorial</h3>
    <?php
    $factNum = 5;
    $factorial = 1;
    for ($i = 1; $i <= $factNum; $i++) {
        $factorial *= $i;
    }
    echo "Factorial of $factNum is $factorial";
    ?>
</div>

<div class="exercise">
    <h3>Loop 7: Multiplication Table Table</h3>
    <?php
    echo "<table cellpadding='3px' cellspacing='0px'>";
    for ($i = 1; $i <= 6; $i++) {
        echo "<tr>";
        for ($j = 1; $j <= 5; $j++) {
            echo "<td>$i * $j = " . ($i * $j) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    ?>
</div>

<?php
// ==========================================
// 5. PHP STRING AND STRING FUNCTIONS
// ==========================================
echo "<h2>5. PHP String and String Functions</h2>";
?>

<div class="exercise">
    <h3>String 1: Case Conversions</h3>
    <?php
    $stringTest = "orange coding academy";
    echo "Uppercase: " . strtoupper($stringTest) . "<br>";
    echo "Lowercase: " . strtolower($stringTest) . "<br>";
    echo "First letter uppercase: " . ucfirst($stringTest) . "<br>";
    echo "Title case: " . ucwords($stringTest) . "<br>";
    ?>
</div>

<div class="exercise">
    <h3>String 2: Date Format Split</h3>
    <?php
    $timeInput = '085119';
    echo substr($timeInput, 0, 2) . ":" . substr($timeInput, 2, 2) . ":" . substr($timeInput, 4, 2);
    ?>
</div>

<div class="exercise">
    <h3>String 3: Check Word in Sentence</h3>
    <?php
    $sentence = 'I am a full stack developer at orange coding academy';
    $searchWord = 'Orange';
    if (stripos($sentence, $searchWord) !== false) {
        echo "Word Found!";
    }
    ?>
</div>

<div class="exercise">
    <h3>String 4: Extract Filename from URL</h3>
    <?php
    $urlStr = 'www.orange.com/index.php';
    echo basename($urlStr);
    ?>
</div>

<div class="exercise">
    <h3>String 5: Extract Username from Email</h3>
    <?php
    $emailAddr = 'info@orange.com';
    echo strstr($emailAddr, '@', true);
    ?>
</div>

<div class="exercise">
    <h3>String 6: Last Three Characters</h3>
    <?php
    $emailStr = 'info@orange.com';
    echo substr($emailStr, -3);
    ?>
</div>

<div class="exercise">
    <h3>String 7: Random Password Generation</h3>
    <?php
    $charsPool = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
    $pass = '';
    $maxIdx = strlen($charsPool) - 1;
    for ($i = 0; $i < 7; $i++) {
        $pass .= $charsPool[mt_rand(0, $maxIdx)];
    }
    echo "Random Password: $pass";
    ?>
</div>

<div class="exercise">
    <h3>String 8: Replace First Word</h3>
    <?php
    $originalSent = 'That new trainee is so genius.';
    $newWord = 'Our';
    $updatedSent = preg_replace('/^\S+/', $newWord, $originalSent);
    echo $updatedSent;
    ?>
</div>

</body>
</html>