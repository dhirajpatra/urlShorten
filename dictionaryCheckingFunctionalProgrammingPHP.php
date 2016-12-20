<?php
/**
* This script will process dictionary words and their values 
* to calculate total scores for whole sentences
*
*/
$time = microtime();
$dictionary = array('good' => 100, 'bad' => 0, "god" => 50, "man" => 40, "is"=> 50, "wife" => 40, "country" => 70, "love" => 50, "he" => 20, "his" => 20, "for" => 10, "and" => 30);
$sentence = "He is a very good man and love for his country and his wife is good";

//$sentenceArr = explode(' ', $sentence);
$sentenceArr = array_count_values(str_word_count($sentence, 1));
//print_r($sentenceArr); exit;
$count = 0;
/*$scores = 0;
foreach($sentenceArr as $word => $times){
    $word = strtolower($word);
    if (array_key_exists($word, $dictionary)){
        $count++;
        $scores += ($dictionary[$word] * $times);        
    }
}*/
$scores = 0;
function countScore($sentenceArr, $dictionary, &$scores)
{        
    return array_walk(
        $sentenceArr,
        function($times, $word) use ($dictionary, &$scores)
        {
            $word = strtolower($word);
            if (array_key_exists($word, $dictionary)){
                $scores += ($dictionary[$word] * $times);        
            }
        }    
    );
    
    return true;
}

echo microtime() - $time;
//echo "<br>" . $scores.'  '.$count;
countScore($sentenceArr, $dictionary, $scores);
echo "<br>" . $scores;