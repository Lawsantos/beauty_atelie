<?php

namespace App\Services;

class CalendarElement
{
    public static function render(string $tag, string $body = null, array $attributes = null)
    {
        $elAttributes = '';
        foreach ($attributes as $key => $value) {
            $elAttributes .= "$key=\"$value\" ";
        }
        if (!in_array($tag, ['a', 'span', 'div'])) {
            throw new \Exception('Invalid calendar HTML element');
        }

        return "<$tag {$elAttributes}>$body</$tag>";
    }
}
