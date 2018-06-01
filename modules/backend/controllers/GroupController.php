<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii;
use app\models\Project;
use app\modules\backend\models\ProjectSearch;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Group;
use yii\web\Response;
use app\modules\backend\models\operatelog;
class GroupController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {

        $pro_id=Yii::$app->request->queryParams;
        $project=new Project();
        $project=$project->findOne(['pro_id'=>$pro_id]);
        $searchModel = new Principal();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->module->params['pageSize']);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'pro_id'=>$pro_id,
            'project'=>$project
        ]);
    }

    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model=Project::findOne(['pro_id'=>$id]);

        $group=new Group();
        $group->pro_id=$id;
        $post = Yii::$app->request->post();
        if ($post)
        {
            $tr=Yii::$app->db->beginTransaction();
            try{


                $group->attributes=$_POST['Group'];
                $group->pro_id=$model->pro_id;
                $group->group_add_time=data('Y-m-d H:i:s');
                $group->group_retrieve='PSEG'.time();
                $group->group_add_user=Yii::$app->user->id;
                if ($group->load($post)&&$group->save() )
                {
                        operatelog::addlog(1,$group->id,$group->group_name,2);
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '保存成功');
                        return  $this->redirect(['project/view','id'=>$model->pro_id]);
                       // return $this->showFlash('添加成功','success',['project/index']);

                } else{
                    $tr->rollBack();
                    return $this->showFlash('添加失败');
                }
            }catch (excepetion $e)
            {
                $tr->rollBack();
                return $this->showFlash('添加失败');
            }


        }else{
            return $this->render('create', [
                'group'=>$group,
                'model'=>$model
            ]);
        }

    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $group = $this->findModel($id);
        $model=Group::findOne(['pro_id'=>$group->pro_id]);
        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try{
                $group->attributes=$_POST['Group'];
                $group->group_add_time=data('Y-m-d H:i:s');
                $group->group_add_user=Yii::$app->user->id;
                if ($group->load($post) )
                {
                    operatelog::addlog(3,$group->id,$group->group_name,2);
                    if( $group->save())
                    {
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '修改成功');
                        return  $this->redirect(['project/view','id'=>$model->pro_id]);
                        // return $this->showFlash('添加成功','success',['project/index']);
                    }else{
                        $tr->rollBack();
                        return $this->showFlash('修改失败');
                    }
                }
            }catch (excepetion $e)
            {
                $tr->rollBack();
                return $this->showFlash('添加失败');
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'group'=>$group
            ]);
        }
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
         $model=Group::findOne(['id'=>$id]);
         $model->status=1;
         $model->group_del_user=Yii::$app->user->id;
         $model->group_del_time=date('Y-m-d H:i:s');
        if($model->save()){
            operatelog::addlog(4,$model->id,$model->group_name,2);
            return $this->showFlash('删除成功','success',['Project/view','id'=>$model->pro_id]);
        }
        return $this->showFlash('删除失败', 'danger',Yii::$app->getUser()->getReturnUrl());
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Principal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}