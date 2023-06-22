<?php

try {
    return [
        'user1' => [
            'id' => 1,
            'username' => 'admin',
            'password' => \Yii::$app->getSecurity()->generatePasswordHash('pass_1234'),
            'first_name' => 'admin',
            'last_name' => 'admin',
        ],
        'user2' => [
            'id' => 2,
            'username' => 'ismail',
            'password' => \Yii::$app->getSecurity()->generatePasswordHash('pass_1234'),
            'first_name' => 'test',
            'last_name' => 'user',
        ],
    ];
} catch (\yii\base\Exception $e) {
    echo $e->getMessage();
}
