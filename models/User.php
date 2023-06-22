<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 */

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): User|\yii\web\IdentityInterface|null
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): User|\yii\web\IdentityInterface|null
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->auth_key === $authKey;
    }

    public static function findByUsername(string $username): static
    {
        return self::findOne(['username' => $username]);
    }

    public function validatePassword(string $password): bool
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isAttributeChanged('password', true)) {
                $this->password = \Yii::$app->security->generatePasswordHash($this->password);
            }
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
}
