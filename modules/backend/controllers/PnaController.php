<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use yii;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Pna;
use app\models\Testmethod;
use yii\web\Response;
use yii\data\Pagination;
use app\helpers\CommonHelper;
class PnaController extends BackendController
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
    public function actionIndex($type)
    {
        //分页读取类别数据

        $model =  Pna::find();


        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $model->count(),
        ]);
        $model->andFilterWhere(['isdel'=> 0,'type'=>$type]);
        $model = $model->orderBy('id ASC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'model' => $model,
            'pagination'=>$pagination,
            'type'=>$type
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

        $child=Testmethod::find()->andFilterWhere(['pid'=>$id,'isdel'=>0])->all();
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
    public function actionCreate($type)
    {
        $model = new Pna();
        $model->type=$type;
        if($type==1){
            $model->retrieve='ETP'.time();
        }elseif ($type==2){
            $model->retrieve='ETN'.time();
        }

        $post = Yii::$app->request->post();
        if ($post) {
            $tr=Yii::$app->db->beginTransaction();
            try{

                $model->setAttributes($_POST['Pna'],false);
                $model->add_time=date('Y-m-d H:i:s');

                if ($model->load($post)&&$model->save())
                {
                    CommonHelper::addlog(1,$model->id,$model->name,'pna');

                    $tr->commit();
                    return $this->showFlash('添加成功','success',['pna/index','type'=>$model->type]);


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
                $model->setAttributes($_POST['Pna'], false);
                if ($model->load($post) && $model->save())
                {

                    CommonHelper::addlog(3, $model->id, $model->name, 'pna');
                    $tr->commit();
                    return $this->showFlash('修改成功','success',['pna/index','type'=>$model->type]);
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


    public function actionDel($id)
    {
        $model=$this->findModel($id);
        $model->isdel=1;
        if($model->save())
        {
            CommonHelper::addlog(4,$model->id,$model->name,'particular');
            return $this->showFlash('删除成功','success',['particular/index','id'=>$model->id]);
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
        if (($model = Pna::findOne($id)) !== null)
        {
            return $model;

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}