<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $manageRolePermission = $auth->createPermission('manageRolePermission');
        $manageRolePermission->description = 'manage User Permission';
        $auth->add($manageRolePermission);

        $manageUserPermission = $auth->createPermission('manageUserPermission');
        $manageUserPermission->description = 'manage User Permission';
        $auth->add($manageUserPermission);

        $managePostPermission = $auth->createPermission('managePostPermission');
        $managePostPermission->description = 'Update postPermission';
        $auth->add($managePostPermission);

        $viewPostsPermission = $auth->createPermission('viewPostsPermission');
        $viewPostsPermission->description = 'View posts Permission';
        $auth->add($viewPostsPermission);
        $auth->addChild($managePostPermission, $viewPostsPermission);

        $viewPostPermission = $auth->createPermission('viewPostPermission');
        $viewPostPermission->description = 'View post Permission';
        $auth->add($viewPostPermission);
        $auth->addChild($managePostPermission, $viewPostPermission);

        $createPostPermission = $auth->createPermission('createPostPermission');
        $createPostPermission->description = 'Create a post Permission';
        $auth->add($createPostPermission);
        $auth->addChild($managePostPermission, $createPostPermission);

        $updatePostPermission = $auth->createPermission('updatePostPermission');
        $updatePostPermission->description = 'Update postPermission';
        $auth->add($updatePostPermission);
        $auth->addChild($managePostPermission, $updatePostPermission);

        $deletePostPermission = $auth->createPermission('deletePostPermission');
        $deletePostPermission->description = 'Update postPermission';
        $auth->add($deletePostPermission);
        $auth->addChild($managePostPermission, $deletePostPermission);

        $authorRule = new \app\rbac\AuthorRule;
        $auth->add($authorRule);

        $updateOwnPostPermission = $auth->createPermission('updateOwnPostPermission');
        $updateOwnPostPermission->description = 'Update own post';
        $updateOwnPostPermission->ruleName = $authorRule->name;
        $auth->add($updateOwnPostPermission);

        // "updateOwnPost" will be used from "updatePost"
        $auth->addChild($updateOwnPostPermission, $updatePostPermission);

        // add "createPost" permission
        $viewMyPosts = $auth->createPermission('viewMyPostsPermission');
        $viewMyPosts->description = 'View my posts Permission';
        $auth->add($viewMyPosts);

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('authorRole');
        $auth->add($author);
        $auth->addChild($author, $createPostPermission);
        $auth->addChild($author, $viewPostsPermission);
        $auth->addChild($author, $viewPostPermission);
        $auth->addChild($author, $updateOwnPostPermission);
        $auth->addChild($author, $viewMyPosts);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('adminRole');
        $auth->add($admin);
        $auth->addChild($admin, $manageRolePermission);
        $auth->addChild($admin, $manageUserPermission);
        $auth->addChild($admin, $managePostPermission);
        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        //$auth->assign($author, 2);
        $auth->assign($admin, 1);
        $auth->assign($author, 2);
    }
}
