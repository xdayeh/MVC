<?php

namespace AbuDayeh\Models;

use AbuDayeh\Core\Application;
use AbuDayeh\Core\Model;

class LoginModel extends Model
{
    public string $Email    = '';
    public string $Password = '';
    public function tableName(): string
    {
        return 'users';
    }
    public function attributes(): array
    {
        return ['Email', 'Password'];
    }
    public function primaryKey(): string
    {
        return 'Userid';
    }
    public function rules(): array
    {
        return [
            'Email'     => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'Password'  => [self::RULE_REQUIRED, [self::RULE_MIN, 'Min' => 8], [self::RULE_MAX, 'Max' => 24]]
        ];
    }
    public function labels(): array
    {
        return [
            'Email'     => 'Your Email',
            'Password'  => 'Password'
        ];
    }

    public function login(): bool
    {
        $user = self::findOne(['Email' => $this->Email]);
        if (!$user){
            $this->addError('Email', 'Email Does Not Exist');
            return false;
        }
        if (!password_verify($this->Password, $user->Password)){
            $this->addError('Password', 'Password Is Incorrect');
            return false;
        }

        return Application::$app->login($user);
    }
}