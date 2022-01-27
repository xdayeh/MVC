<?php

namespace AbuDayeh\Core\Template\Form;

use AbuDayeh\Models\Model;

abstract class BaseField
{
    abstract public function renderInput(): string;
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return sprintf('
            <div class="form-floating mb-3">
                %s
                <label for="%s">%s</label>
                <div class="invalid-feedback">%s</div>
            </div>
        ',
            $this->renderInput(),
            $this->attribute.'Java',
            $this->model->getLabel($this->attribute),
            $this->model->getFirstError($this->attribute)
        );
    }
}