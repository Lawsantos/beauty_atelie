<?php

namespace App\Services;

use Illuminate\Support\HtmlString;

class HTML_div
{
    public static function Get_HTML(string $body, array $attributes = [])
    {
        $elAttributes = '';
        foreach ($attributes as $key => $value) {
            $elAttributes .= "$key=\"$value\" ";
        }

        return "<div {$elAttributes}>$body</div>";
    }
}
