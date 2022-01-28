<?php

namespace AbuDayeh\Core\Template\Form;

use AbuDayeh\Core\Model;

class Field extends BaseField
{

    public const TYPE_TEXT      = 'text';
    public const TYPE_Password  = 'password';
    public const TYPE_Email     = 'email';
    public const TYPE_number    = 'number';

    public string $type;

    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    public function __toString()
    {
        return sprintf('
            <div class="form-floating mb-3">
                %s
                <label for="%s">%s</label>
                <div class="invalid-feedback text-start">%s</div>
            </div>
        ',
            $this->renderInput(),
            $this->attribute.'Java',
            $this->model->getLabel($this->attribute),
            $this->model->getFirstError($this->attribute)
        );
    }

    public function passwordField(): Field
    {
        $this->type = self::TYPE_Password;
        return $this;
    }

    public function emailField(): Field
    {
        $this->type = self::TYPE_Email;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control %s" id="%s" placeholder="text">',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->attribute.'Java',
        );
    }
}