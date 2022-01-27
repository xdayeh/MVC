<?php

namespace AbuDayeh\Core\Template\Form;

class TextareaField extends BaseField
{

    public function renderInput(): string
    {
        return sprintf('<textarea name="%s" class="form-control %s" id="%s" placeholder="text" style="height: 100px">%s</textarea>',
            $this->attribute,
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->attribute.'Java',
            $this->model->{$this->attribute}
        );
    }
}