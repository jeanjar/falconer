<?php

namespace Falconer\Rule;

class MessagePrinter
{
    public static function flatArray($messages, $labels, $label_function = '\\Falconer\\Helper\\Core::label')
    {
        $flattened = array();
        foreach ($messages as $key => $m)
        {
            foreach ($m as $message)
            {
                $flattened[] = $label_function($key, $labels) . ': ' . $message;
            }
        }
        return $flattened;
    }


    public static function event($messages, $labels, $label_function = '\\Falconer\\Helper\\Core::label')
    {
        $messages_html = '';

        foreach ($messages as $key => $m)
        {
            foreach ($m as $message)
            {
                $messages_html .= '<strong class="field-error" data-field="' . $key . '">' . $label_function($key, $labels) . ': </strong>' . $message;
            }
        }

        return $messages_html;
    }
}
