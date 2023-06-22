<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

class RoleForm extends Model
{
    public $name;
    public $description;
    public $parent;
    public $permissions;

    public function rules(): array
    {
        return [
            [['name', 'permissions'], 'required'],
            [['description', 'parent'], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Role name',
            'parent' => 'Parent',
            'permissions' => 'Role permissions',
            'description' => 'Description',
        ];
    }

    public function create(): bool
    {
        $role = new Role();
        $role->type = Item::TYPE_ROLE;
        $role->name = $this->name;
        $role->description = $this->description;

        if(!$role->save()){
            return false;
        }

        if ($this->parent != null){
            $this->addAuthItemChild($this->parent, $role->name);
        }

        $this->savePermissions($role);
        return true;
    }

    public function update(): bool
    {
        $role = Role::findOne(['name' => $this->name]);
        $role->description = $this->description;

        if(!$role->save()){
            return false;
        }

        AuthItemChild::deleteAll(['parent' => $role->name]);
        $this->savePermissions($role);

        return true;
    }

    private function savePermissions(Role $role): void
    {
        foreach ($this->permissions as $permission){
            $this->addAuthItemChild($role->name, $permission);
        }
    }

    private function addAuthItemChild($parent, $child): void
    {
        $authItemChild = new AuthItemChild();
        $authItemChild->parent = $parent;
        $authItemChild->child = $child;
        $authItemChild->save();
    }

    public function getPermissions(): array
    {
        $permissions = Role::find()->where(['type' => Item::TYPE_PERMISSION])->asArray()->all();
        return ArrayHelper::map($permissions, 'name', 'name');
    }

    public static function getRoles(): array
    {
        $roles = Role::find()->where(['type' => Item::TYPE_ROLE])->asArray()->all();
        return ArrayHelper::map($roles, 'name', 'name');
    }

    public static function getRolePermissions(string $roleName): array
    {
        $permissions = Role::find()
            ->join('JOIN', 'auth_item_child', 'auth_item.name = auth_item_child.child')
            ->where(['auth_item_child.parent' => $roleName])
            ->asArray()
            ->all();

        return ArrayHelper::map($permissions, 'name', 'name');
    }

    public function getRoleParent(string $name): ?string
    {
        $authItemChild = AuthItemChild::findOne(['child' => $name]);
        return $authItemChild?->parent;
    }
}