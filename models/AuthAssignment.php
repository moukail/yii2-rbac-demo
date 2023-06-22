<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property mixed|null $item_name
 * @property int|mixed|string|null $user_id
 */
class AuthAssignment extends ActiveRecord
{
    public static function tableName()
    {
        return 'auth_assignment';
    }
}