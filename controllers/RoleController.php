<?php

namespace app\controllers;

use app\models\Role;
use app\models\RoleForm;
use app\models\AuthItemChild;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            //'actions' => ['index'],
                            'roles' => ['adminRole', 'manageRolePermission'],
                        ],
                    ]
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Role models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Role::find()->where(['type' => \yii\rbac\Item::TYPE_ROLE]),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
     * @param string $name Name
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        $role = $this->findRole($name);

        $model = new RoleForm();
        $model->name = $role->name;
        $model->description = $role->description;
        $model->permissions = RoleForm::getRolePermissions($name);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RoleForm();

        if ($model->load($this->request->post()) && $model->create()) {
            return $this->redirect(['view', 'name' => $model->name]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $name Name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($name)
    {
        $role = $this->findRole($name);

        $model = new RoleForm();
        $model->name = $role->name;
        $model->description = $role->description;
        $model->parent = $model->getRoleParent($name);
        $model->permissions = $model->getRolePermissions($name);


        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->update();
            return $this->redirect(['view', 'name' => $model->name]);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name Name
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($name)
    {
        $this->findRole($name)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name Name
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findRole($name)
    {
        if (($model = Role::findOne(['name' => $name])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
