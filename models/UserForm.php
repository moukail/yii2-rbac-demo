<?php

namespace app\models;

use yii\base\Model;
use yii\web\NotFoundHttpException;

class UserForm extends Model
{
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $role;

    public function rules(): array
    {
        return [
            [['username', 'password', 'first_name', 'role'], 'required'],
            [['first_name', 'last_name', 'role'], 'string'],
            [['username'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    public function create(): bool|User
    {
        $user = new User();
        $user->username = $this->username;
        $user->password = $this->password;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;

        if(!$user->save()){
            return false;
        }

        $authAssignment = new AuthAssignment();
        $authAssignment->item_name = $this->role;
        $authAssignment->user_id = $user->getId();
        $authAssignment->save();

        return $user;
    }

    public function update(): bool
    {
        $user = User::findOne(['id' => $this->id]);
        $user->username = $this->username;
        $user->password = $this->password;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;

        if(!$user->save()){
            return false;
        }

        $authAssignment = AuthAssignment::findOne(['user_id' => $this->id]);
        if(!$authAssignment){
            $authAssignment = new AuthAssignment();
            $authAssignment->user_id = $this->id;
        }
        $authAssignment->item_name = $this->role;
        $authAssignment->save();

        return true;
    }

    public function getRole(int $id): ?string
    {
        $model = AuthAssignment::findOne(['user_id' => $id]);
        return $model?->item_name;
    }
}