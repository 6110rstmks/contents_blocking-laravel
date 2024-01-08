<?php

function hiragana_to_katakana($str)
{
    return mb_convert_kana($str, 'C');
}

// function isHiraganaAndKatakana($str) {
//     $pattern = '/[\p{Hiragana}\p{Katakana}]+/u';
//     return preg_match($pattern, $str) === 1;
// }

// カタカナやアルファベットも含まれて良いです。
//ただし、カタカナのみ、アルファベットのみの文字列は許容しません。
function isHiragana($str) {
    $pattern = '/[\x{3040}-\x{309F}\x{30A0}-\x{30FF}a-zA-Z]+/u';
    return preg_match($pattern, $str) === 1;
}
