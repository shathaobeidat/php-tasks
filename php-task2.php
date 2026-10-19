<?php
//1
$array = array(
    "Twinkle, ",
    "twinkle,",
    " little star."
);
echo"<br>";
$test="rest";
var_dump($array);
echo"<br>";
//2
$input='a';
function convertchar ($ch){
    if($ch=='z')
        return 'a';
else return ++$ch;
}
$res=convertchar($input);
echo"$res";
echo"<br>";
//3

$sentence = 'The quick brown fox';
$new = 'quick';
$words = explode(' ', $sentence);
array_splice($words, 0, 0, $new);
$result = implode(' ', $words);
echo $result;
echo"<br>";
//4

$original = '0000657022.24';
$result = str_replace('0', '', $original);
echo $result; 
//5
echo"<br>";
$original = 'The quick brown fox jumps over the lazy dog---';
$result = rtrim($original, '-');
echo $result; 

//6
echo"<br>";
$sentence = 'The quick brown fox jumps over the lazy dog';


$words = explode(' ', $sentence);

$first_five = array_slice($words, 0, 5);

$result = implode(' ', $first_five);

echo $result; 
//7
echo"<br>";

$number_string = '2,543.12';
$clean_string = str_replace(',', '', $number_string);

$result = (float)$clean_string;

echo $result; 

//8
echo"<br>";
$fibonacci = [];


function fibonacci($num) {
    if ($num == 0) {
        return 0;
    } 
    if ($num == 1) {
        return 1;
    }
    
    return fibonacci($num - 1) + fibonacci($num - 2);
}


$count = 10;
for ($i = 0; $i < $count; $i++) {
    $fibonacci[] = fibonacci($i);
}

echo implode(', ', $fibonacci) . ', ...';

//9
    $k=1;
for($i=1;$i<=5;$i++){
       echo"<br>";
  for($j=1;$j<=$i;$j++) {   
echo"$k ";
$k++;
    }
    }
    //10
for ($i = 1; $i <= 5; $i++) {
    $k = 'A'; 
    
    for ($j = 1; $j <= $i; $j++) {   
        echo "$k ";
        $k++;
    }
    echo "<br>";
}

for ($i = 4; $i >= 1; $i--) {
    $k = 'A';
    for ($j = 1; $j <= $i; $j++) {   
        echo "$k ";
        $k++;
    }
    echo "<br>";
}

//11


$year = 2013;
if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
    echo "This year is a leap year";
} else {
    echo "This year is not a leap year";
}
//12

$temp = 27;
if ($temp < 20) {
    echo "It is wintertime!";
} else {
    echo "It is summertime!";
}
//13

$first = 2;
$second = 2;

$sum = $first + $second;

if ($first == $second) {
    $result = $sum * 3;
    echo "( $first + $second ) * 3 = $result";
} else {
    echo "Sum = $sum";
}
echo"<br>";
//14

$numbers = [];

for ($i = 200; $i <= 250; $i++) {
    if ($i % 4 == 0) {
        echo"$i ";
    }
}

//15
echo"<br>";
$min = 11;
$max = 20;

$numbers = range($min, $max);

shuffle($numbers);
echo implode(' ', $numbers);
