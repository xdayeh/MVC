<?php

namespace AbuDayeh\Core\Template\Form;

use AbuDayeh\Models\Model;

class Form
{
    public static function begin($action, $method): Form
    {
        echo sprintf('<form action="'.htmlentities('%s').'" method="%s">', $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute): field
    {
        return new field($model, $attribute);
    }
}