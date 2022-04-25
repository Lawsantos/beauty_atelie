<?php

namespace App\Services;

class HTML_a
{
    public static function Get_HTML(string $body, array $attributes = [])
    {
        $elAttributes = '';
        foreach ($attributes as $key => $value) {
            $elAttributes .= "$key=\"$value\" ";
        }
        return "<a {$elAttributes}>$body</a>";
    }
}
