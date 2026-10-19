<?php
//task 1
$colors =array('white','red','green');

sort($colors);
echo"<ul>";
foreach($colors as $color){
    echo"<li>$color</li>";

}
echo "</ul>";

//task2

$cities= array( "Italy"=>"Rome", "Luxembourg"=>"Luxembourg", "Belgium"=> "Brussels", 
"Denmark"=>"Copenhagen", "Finland"=>"Helsinki", "France" => "Paris", "Slovakia"=>"Bratislava", 
"Slovenia"=>"Ljubljana", "Germany" => "Berlin", "Greece" => "Athens", "Ireland"=>"Dublin", 
"Netherlands"=>"Amsterdam", "Portugal"=>"Lisbon", "Spain"=>"Madrid" ); 

asort($cities);

foreach($cities as $country => $capital){
    echo"The capital of $country is $capital,<br>";}
    
    //task3
    $colort3 = array (4 => 'white', 6 => 'green', 11=> 'red');

    echo "<br>$colort3[4]";

//task4
    $task4=array('p1','p2','p3','p4','p5');
    $location=3;
    $newitem='new';
array_splice($task4, 3, 0, $newitem);
  echo"<br>";
foreach($task4 as $task ){
    echo"$task  ";}

    //task5
    $fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
    asort($fruits);

foreach($fruits as $fruit =>$val){
    echo"<br>$fruit =$val";}

    //task 6


$task6  = array(
    78, 60, 62, 68, 71, 68, 73, 85, 66, 64,
    76, 63, 75, 76, 73, 68, 62, 73, 72, 65,
    74, 62, 62, 65, 64, 68, 73, 75, 79, 73
);


$avg= array_sum($task6)/count($task6);
echo"<br>$avg<br>";
sort($task6);
$min=array_slice($task6,0,5);

foreach($min as $m){
   echo"$m ";
}
echo"<br>";
$max=array_slice($task6,-5);

 foreach($max as $M){
   echo"$M ";
}

//task 7
$array1 = array("color" => "red", 2, 4); 
$array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
$array3=array_merge($array1,$array2);
 echo"<br> ";
foreach($array3 as $arr){
   echo"$arr<br> ";
}
// task 8
$task8 = array("red", "blue", "white", "yellow");

foreach ($task8 as $value) {
    echo strtoupper($value) . " ";
}
//task 9 

function isprime ($num){
    $isprime=true;
    for($i=1;$i<=$num;$i++)
        if($num%$i==0 && $i!=1 && $i!=$num ){
       $isprime=false;
    break;
}
if($isprime)
    echo"its a prime number";
else
       echo"its  not a prime number";
}
 echo"$arr<br> ";

isprime(3);
//10
function  reverse ($str){
    $newstr="";
    for($i=strlen($str)-1;$i>=0;$i--)
        $newstr.= $str[$i];
    return $newstr;
}
 echo"$arr<br> ";
$result=reverse("hello");
echo"$result";
 echo"$arr<br> ";
 //11
function swap(&$a,&$b){
    $c=$a;
    $a=$b;
    $b=$c;
    
}

$x = 12;
$y = 10;

swap($x, $y);

echo "x = $x<br>";
echo "y = $y";
//12
function isArmstrong($num) {

    $original = $num;
    $sum = 0;

    while ($num > 0) {

        $digit = $num % 10;
        $sum = $sum + ($digit * $digit * $digit);

        $num = floor($num / 10);
    }

    if ($sum == $original)
        echo "$original is Armstrong Number";
    else
        echo "$original is not Armstrong Number";
}

isArmstrong(407);
//13
function isPalindrome($str) {

    $str = strtolower($str);
    $str = preg_replace("/[^a-z]/", "", $str);

    $i = 0;
    $j = strlen($str) - 1;

    $ispalendrom = true;

    while ($i <= $j) {

        if ($str[$i] != $str[$j]) {
            $ispalendrom = false;
            break;
        }

        $i++;
        $j--;
    }

    if ($ispalendrom)
        echo "is palindrome";
    else
        echo "is not a palindrome";
}

isPalindrome("Eva, can I see bees in a cave?");


//14
function removeDuplicates($array) {
    return array_unique($array);
}

$array1 = array(2, 4, 7, 4, 8, 4);

$array1 = removeDuplicates($array1);

print_r($array1);
//15

function checkSum($firstInteger, $secondInteger) {
    $sum = $firstInteger + $secondInteger;

    if ($sum == 30) {
        return $sum;
    } else {
        return false;
    }
}

echo checkSum(10, 10) ? checkSum(10, 10) : "false";


//16


function isMultipleOf3($number) {
    if ($number % 3 == 0) {
        return true;
    } else {
        return false;
    }
}

var_dump(isMultipleOf3(20));
//17
function checkRange($number) {
    if ($number >= 20 && $number <= 50) {
        return true;
    } else {
        return false;
    }
}

var_dump(checkRange(50));
//18
function findLargest($a, $b, $c) {
    return max($a, $b, $c);
}

echo findLargest(1, 5, 9);
//19



$units = 200;

if ($units <= 50) {
    $bill = $units * 2.50;
} elseif ($units <= 150) {
    $bill = (50 * 2.50) + (($units - 50) * 5.00);
} elseif ($units <= 250) {
    $bill = (50 * 2.50) + (100 * 5.00) + (($units - 150) * 6.20);
} else {
    $bill = (50 * 2.50) + (100 * 5.00) + (100 * 6.20) + (($units - 250) * 7.50);
}

echo $bill . " JOD";
//20

$num1 = 10;
$num2 = 5;
$operator = "+";

if ($operator == "+") {
    echo $num1 + $num2;
} elseif ($operator == "-") {
    echo $num1 - $num2;
} elseif ($operator == "*") {
    echo $num1 * $num2;
} elseif ($operator == "/") {
    echo $num1 / $num2;
} else 
    echo "Invalid operator";

    //21
    $age = 15;

if ($age >= 18) {
    echo "is eligible to vote";
} else {
    echo "is not eligible to vote";
}
//22

$number = -60;

if ($number > 0) {
    echo "Positive";
} elseif ($number < 0) {
    echo "Negative";
} else {
    echo "Zero";
}
//23
function calculateGrade($scores) {
    if (empty($scores)) {
        return "No scores provided";
    }

    $average = array_sum($scores) / count($scores);


    if ($average < 60) {
        $grade = 'F';
    } elseif ($average < 70) {
        $grade = 'D';
    } elseif ($average < 80) {
        $grade = 'C';
    } elseif ($average < 90) {
        $grade = 'B';
    } else {
        $grade = 'A';
    }

    return $grade;
}


$scores = [60, 86, 95, 63, 55, 74, 79, 62, 50];


$grade = calculateGrade($scores);
echo "'" . $grade . "'";
//24
for ($i = 1; $i <= 10; $i++) {
    if ($i === 10) {
        echo $i;
    } else {
        echo $i . "-";
    }
}
//25
$total = 0;

for ($i = 0; $i <= 30; $i++) {
    $total += $i;
}

echo $total;
//26
$letters = ['A', 'B', 'C', 'D', 'E'];

for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < 5; $j++) {
  
        if ($j < (5 - 1 - $i)) {
            echo "A ";
        } else {
            echo $letters[$i] . " ";
        }
    }
    echo "\n"; 
}
//27

for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 5; $j++) {

        if ($j <= (5 - $i)) {
            echo "1 ";
        } else {
            echo $i . " ";
        }
    }
    echo "\n"; 
}
//28
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 5; $j++) {

        if ($i === $j) {
            echo $i . " ";
        } else {
            echo "0 ";
        }
    }}
    echo "\n"; 
    //29
    $number = 5;
$factorial = 1;

for ($i = 1; $i <= $number; $i++) {
    $factorial *= $i;
}

echo $factorial;
//30
echo '<table border="1" cellpadding="3px" cellspacing="0px">';

for ($i = 1; $i <= 6; $i++) {
    echo '<tr>';
    for ($j = 1; $j <= 5; $j++) {
        $result = $i * $j;
        echo "<td>$i * $j = $result</td>";
    }
    echo '</tr>';
}

echo '</table>';

//31
$str = "hello world from php";

echo strtoupper($str) . "\n"; 
echo strtolower($str) . "\n"; 
echo ucfirst($str) . "\n"; 
echo ucwords($str) . "\n"; 

//32
$input = '085119';
$formatted = substr($input, 0, 2) . ':' . substr($input, 2, 2) . ':' . substr($input, 4, 2);
echo $formatted; 
//33
$sentence = 'I am a full stack developer at orange coding academy';
$word = 'Orange';

if (stripos($sentence, $word) !== false) {
    echo 'Word Found!';
} else {
    echo 'Word Not Found!';
}
//34

$url = 'www.orange.com/index.php';
$filename = basename($url);
echo "'" . $filename . "'";

//35

$email = 'info@orange.com';

$username = strstr($email, '@', true);
echo "'" . $username . "'";

//36
$str = 'info@orange.com';
$lastThree = substr($str, -3);
echo "'" . $lastThree . "'";
//37

$chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';

function generatePassword($chars, $length = 10) {
 
    return substr(str_shuffle($chars), 0, $length);
}

echo generatePassword($chars, 10);

//38

$text = 'That new trainee is so genius.';
$result = str_replace('That', 'Our', $text);
echo $result;

