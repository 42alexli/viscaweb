<?php

$orange_words = array(
    'orange',
    'naranja',
    'oranssi',
    'narancs',
    'arancione',
    'laranja',
    'turuncu',
);
/**
 *
 * I misunderstood the task, did it, was glad that it was fast.
 * You can uncomment and run the script, it's working
 *
 */
//function find_word($array)
//{
//    $orange = $array[0];
//    $orange_count = count(str_split($orange));
//    $count = array();
//    foreach ($array as $k) {
//
//        $count[$k] = ($orange_count - count(array_diff(str_split($orange), str_split($k)))) / $orange_count * 100;
//    }
//    return $count;
//}
//
//print_r(find_word($orange_words));

/**
 *
 * Re-read the task, understood, upset. :)
 * Re-read one more time to be sure I understood correctly
 *
 */

$result = [];

foreach ($orange_words as $word) {
    foreach ($orange_words as $word2) {
        if ($word2 != $word) {
            $result[$word . ':' . $word2] = similar_percentage($word, $word2);
        }
    }
}
arsort($result);

function similar_percentage($first, $second)
{
    $percentage = NULL;
    similar_text($first, $second, $percentage);
    return $percentage;
}