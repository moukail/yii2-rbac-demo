<?php

namespace app\rbac;

use app\models\Post;
use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    public function execute($user, $item, $params)
    {
        $post = Post::findOne(['id' => $params['post_id']]);
        return $post?->author_id == $user;
    }
}