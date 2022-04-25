<?php

namespace App\Services;

class HTML_span
{
    public static function Get_HTML(string $body, array $attributes = [])
    {
        $elAttributes = '';
        foreach ($attributes as $key => $value) {
            $elAttributes .= "$key=\"$value\" ";
        }
        return "<span {$elAttributes}>$body</span>";
    }
}
