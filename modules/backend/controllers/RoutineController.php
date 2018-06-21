<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use app\models\Group;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Routine;
use app\models\Reagent;

use app\models\Sdyeing;
use yii\web\Response;
use app\helpers\CategoryHelper;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use PHPExcel;
use app\models\UploadFile;
use app\helpers\CommonHelper;
class RoutineController extends BackendController
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
        //分页读取类别数据

        $model =  Routine::find();


        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $model->count(),
        ]);
        $model->andFilterWhere(['isdel'=> 0]);
        $model = $model->orderBy('id ASC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'model' => $model,
            'pagination'=>$pagination
        ]);

//        $searchModel = new ProjectSearch();
//
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->module->params['pageSize']);
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }

    public function actionUploadfile()
    {

    }

    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $child=Reagent::find()->andFilterWhere(['sid'=>$id,'isdel'=>0,'type'=>'routine'])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'child'=>$child

        ]);
    }
        /**
         * Creates a new Content model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionAdd($id)
        {
            $model = new Sdyeing();
            $routine=Routine::find()->andFilterWhere(['isdel'=>'0'])->all();

            $reagent=Reagent::find()->andFilterWhere(['isdel'=>0,'type'=>'routine'])->all();

            $model ->yid= $id;
            $post = Yii::$app->request->post();
            if ($post) {
                $tr=Yii::$app->db->beginTransaction();
                try{
                    $post['Sdyeing']['rgid']=isset($post['Sdyeing']['rgid']) ? json_encode(  $post['Sdyeing']['rgid']) : '';
                    $model->setAttributes($_POST['Sdyeing'],false);
                    $model->add_time=date('Y-m-d H:i:s');
                    $model->ntype=1;
                    $model->retrieve='ERHE'.time();
                    if ($model->load($post)&&$model->save() )
                    {
                        CommonHelper::addlog(1,$model->id,$model->section_name,'sdyeing');

                        $tr->commit();
                        return $this->showFlash('添加成功','success',['stace/view','id'=>$model->yid]);
                    }else{
                        $tr->rollBack();
                        return $this->showFlash('添加失败');
                    }
                }catch (excepetion $e)
                {
                    $tr->rollBack();
                    return $this->showFlash('添加失败');
                }


            }
            return $this->render('add', [
                'model' => $model,
                'routine'=>$routine,
                'reagent'=>$reagent
            ]);
        }


    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionChange($id)
    {
        $model =Sdyeing::findOne($id);
        $routine=Routine::find()->andFilterWhere(['isdel'=>'0'])->all();

        $reagent=Reagent::find()->andFilterWhere(['isdel'=>0,'type'=>'routine'])->all();

        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try {
                $newkit=Kit::find()->select('id')->andFilterWhere(['type'=>'testmethod','rid'=> $post['Sdyeing']['nid']])->asArray()->all();
                $kid=[];
                foreach ($newkit as $vn)
                {
                    $kid[]=$vn['id'];
                }
                $kids=array_values(array_intersect(isset($post['Sdyeing']['kit']) ? $post['Sdyeing']['kit'] : [],$kid));
                $post['Sdyeing']['kit']=!empty($kids) ? json_encode($kids) : '';
                $model->setAttributes($_POST['Sdyeing'], false);


                if ($model->load($post) && $model->save())
                {

                    CommonHelper::addlog(3, $model->id, $model->section_name, 'sdyeing');
                    $tr->commit();
                    return $this->showFlash('修改成功','success',['stace/view','id'=>$model->yid]);
                } else {
                    $tr->rollBack();
                    return $this->showFlash('修改失败');
                }

            }catch (excepetion $e)
            {
                $tr->rollBack();
                return $this->showFlash('修改失败');
            }
        } else {
            return $this->render('change', [
                'model' => $model,
                'routine'=>$routine,
                'reagent'=>$reagent
            ]);
        }
    }


    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Routine();
        $post = Yii::$app->request->post();
        if ($post) {
            $tr=Yii::$app->db->beginTransaction();
            try{

                $model->setAttributes($_POST['Routine'],false);
                $model->add_time=date('Y-m-d H:i:s');
                $model->retrieve='ETS'.time();
                if ($model->load($post)&&$model->save() )
                {
                    CommonHelper::addlog(1,$model->id,$model->name,'routine');

                    $tr->commit();
                    return $this->showFlash('添加成功','success',['routine/index']);


                }else{
                        $tr->rollBack();
                        return $this->showFlash('添加失败');

                }
            }catch (excepetion $e)
            {
                $tr->rollBack();
                return $this->showFlash('添加失败');
            }


        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try {
                $model->setAttributes($_POST['Routine'], false);
                if ($model->load($post) && $model->save())
                {

                    CommonHelper::addlog(3, $model->id, $model->name, 'routine');
                    $tr->commit();
                    return $this->showFlash('修改成功','success',['routine/index']);
                } else {
                    $tr->rollBack();
                    return $this->showFlash('修改失败');
                }

            }catch (excepetion $e)
            {
                $tr->rollBack();
                return $this->showFlash('修改失败');
            }
        } else {
            return $this->render('update', [
                'model' => $model,
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
        $model=$this->findModel($id);
        $model->isdel=1;
        if($model->save())
        {
            CommonHelper::addlog(4,$model->id,$model->name,'routine');
            return $this->showFlash('删除成功','success',['routine/index','id'=>$model->id]);
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
        if (($model = Routine::findOne($id)) !== null) {
            return $model;

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}