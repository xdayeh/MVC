<?php

namespace AbuDayeh\Core;

abstract class Model
{
    abstract static public function tableName(): string;
    abstract static public function primaryKey();
    abstract public function attributes(): array;
    abstract public function rules(): array;

    public const RULE_REQUIRED  = 'Required';
    public const RULE_EMAIL     = 'Email';
    public const RULE_MIN       = 'Min';
    public const RULE_MAX       = 'Max';
    public const RULE_MATCH     = 'Match';
    public const RULE_UNIQUE    = 'Unique';
    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value){
            if (property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules){
            $value = $this->{$attribute};
            foreach ($rules as $rule){
                $ruleName = $rule;
                if (!is_string($ruleName)){
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['Min']){
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['Max']){
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['Match']}){
                    $rule['Match'] = $this->getLabel($rule['Match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                    $uniqueAttr= $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->pdo->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record){
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value){
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This Field is Required',
            self::RULE_EMAIL    => 'This Field Must Be Valid Email Address',
            self::RULE_MIN      => 'Min Length Of This Field Must Be {Min}',
            self::RULE_MAX      => 'Max Length Of This Field Must Be {Max}',
            self::RULE_MATCH    => 'This Field Must Be This Same As {Match}',
            self::RULE_UNIQUE   => 'Record With This {field} Already Exists',
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }

    public function labels(): array
    {
        return [];
    }

    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") VALUES (".implode(',', $params).")");

        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
    
}