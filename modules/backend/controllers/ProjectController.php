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
use app\models\Principal;
use yii\web\Response;
use app\helpers\CategoryHelper;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class ProjectController extends BackendController
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
   public function actionDelete_all()
   {
           Yii::$app->response->format = Response::FORMAT_JSON;

           $ids =  Yii::$app->request->post('ids');
           if(empty($ids)){
               return ['data'=>'至少选择一个','code'=>1];
           }
           $attr = ['isdel'=>1];
           /** @var $query ContentQuery */
           $query = Project::find();

           $query->andFilterWhere([
               'in', 'pro_id', $ids
           ]);
           try {
               Project::updateAll($attr,$query->where);
               return [
                   'code'=>0,
                   'data'=>'操作成功'
               ];
           }catch(Exception $e)
           {
               return [
                   'code'=>1,
                   'data'=>$e->getMessage()
               ];
           }
   }



    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {

        //分页读取类别数据
        $search=New Project();
        $model =  Project::find();

        if(isset(Yii::$app->request->queryParams['Project']))
        {
            $parms=Yii::$app->request->queryParams['Project'];
            if(isset($parms['pro_retrieve']))
                $model->andFilterWhere(['pro_retrieve' => $parms['pro_retrieve'],]);
            if(isset($parms['pro_name']))
                $model->andFilterWhere(['like', 'pro_name', $parms['pro_name']]);
        }
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $model->count(),
        ]);
        $model->andFilterWhere(['isdel'=> 0,'pro_pid'=>0]);
        $model = $model->orderBy('pro_id ASC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $child=Project::find()->andFilterWhere(['>', 'pro_pid', 0])->all();
        $child = ArrayHelper::toArray($child);
        $model = ArrayHelper::toArray($model);
        foreach ($model as $k=>$md){
            foreach ($child as $c){
                if($c['pro_pid']==$md['pro_id']){
                    $model[$k]['child'][]=$c;
                }
            }


        }
        return $this->render('index', [
            'model' => $model,
            'pagination' => $pagination,
            'search'=>$search,
            'child'=>$child
        ]);

//        $searchModel = new ProjectSearch();
//
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->module->params['pageSize']);
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $Principal=Principal::find()->andFilterWhere(['pro_id'=>$id,'status'=>0])->all();
        $chid=Project::find()->andFilterWhere(['pro_pid'=>$id,'isdel'=>0])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'child'=>$chid,
            'Principal'=>$Principal
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();
        $principal=new Principal();
        $model->pro_pid=Yii::$app->request->get('pro_pid');
        $model->scenario='create';
        $post = Yii::$app->request->post();
        if ($post) {
            $tr=Yii::$app->db->beginTransaction();
            try{

                $model->setAttributes($_POST['Project'],false);
                $model->pro_add_time=date('Y-m-d H:i:s');
                $model->pro_retrieve='PDS'.date('YmdHis');
                $model->pro_user=Yii::$app->user->id;
                $principal->attributes=$_POST['Principal'];
                if ($model->load($post)&&$model->save() )
                {


                    $principal->pro_id= $model->attributes['pro_id'];

                    if( $principal->save())
                    {
                        $tr->commit();
                         if($model->pro_pid>0){
                             return $this->showFlash('添加成功','success',['project/view','id'=>$model->pro_pid]);

                         }else{
                             return $this->showFlash('添加成功','success',['project/index']);

                         }
                    }else{
                        $tr->rollBack();
                        return $this->showFlash('添加失败');
                    }
                }
            }catch (excepetion $e)
            {
                $tr->rollBack();
                return $this->showFlash('添加失败');
            }


        }
        return $this->render('create', [
            'model' => $model,
            'principal'=>$principal
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
        $principal=Principal::findOne(['pro_id'=>$id]);
        $model->scenario='create';
        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try{
                $model->setAttributes($_POST['Project'],false);
                $model->pro_change_user=Yii::$app->user->id;
                $principal->attributes=$_POST['Principal'];
                if ($model->load($post)&&$model->save() )
                {


                    $principal->pro_id= $model->attributes['pro_id'];

                    if( $principal->save())
                    {
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '修改成功');
                        return  $this->redirect(['project/index']);
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
                'principal'=>$principal
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
        $model=$this->findModel($id);
        $model->scenario='update';
        $model->isdel=1;
        if($model->save())
        {
            return $this->showFlash('删除成功','success',['index']);
        }
        return $this->showFlash('删除失败', 'danger',Yii::$app->getUser()->getReturnUrl());
    }
    public function actionDel($id)
    {
        $model=$this->findModel($id);
        $model->scenario='update';
        $model->isdel=1;
        if($model->save())
        {
            return $this->showFlash('删除成功','success',['project/view','id'=>$model->pro_pid]);
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
        if (($model = Project::findOne($id)) !== null) {
            return $model;

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}