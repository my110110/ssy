<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use app\models\Stace;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii;
use app\models\Sample;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Group;
use app\helpers\CommonHelper;
class SampleController extends BackendController
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
        $model=$this->findModel($id);
        $stace=Stace::findAll(['sid'=>$id,'isdel'=>'0']);
        $group=Group::findOne(['id'=>$model->gid]);

        return $this->render('view', [
            'model' => $model,
            'group'=>$group,
            'stace'=>$stace
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model=Group::findOne(['id'=>$id]);

        $sample=new Sample();
        $sample->gid=$id;
        $sample->pid=$model->pro_id;

        $post = Yii::$app->request->post();
        if ($post)
        {
            $tr=Yii::$app->db->beginTransaction();
            try{


                $sample->attributes=$_POST['Sample'];

                $sample->add_time=date('Y-m-d H:i:s');
                $sample->retrieve='PSEG'.time();
                $sample->add_user=Yii::$app->user->id;
                if ($sample->load($post)&&$sample->save() )
                {
                        CommonHelper::addlog(1,$sample->id,$sample->name,'sample');
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '保存成功');
                        return  $this->redirect(['group/view','id'=>$model->id]);
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
                'sample'=>$sample,
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
        $sample = $this->findModel($id);
        $model=Group::findOne(['id'=>$sample->gid]);
        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try{
                $sample->attributes=$_POST['Sample'];
                $sample->change_time=date('Y-m-d H:i:s');
                $sample->change_user=Yii::$app->user->id;
                if ($sample->load($post) )
                {
                    CommonHelper::addlog(3,$sample->id,$sample->name,'sample');
                    if( $sample->save())
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
                'sample'=>$sample
            ]);
        }
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDel($id)
    {
         $model=Sample::findOne(['id'=>$id]);
         $model->isdel=1;
         $model->del_user=Yii::$app->user->id;
         $model->del_time=date('Y-m-d H:i:s');
        if($model->save()){
            CommonHelper::addlog(4,$model->id,$model->name,'sample');
            return $this->showFlash('删除成功','success',['group/view','id'=>$model->gid]);
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
        if (($model = Sample::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}