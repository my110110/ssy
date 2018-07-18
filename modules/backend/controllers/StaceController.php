<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use app\modules\backend\models\AdminUser;
use yii;
use app\models\Sample;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Stace;
use app\models\Sdyeing;
use app\helpers\CommonHelper;
use yii\data\Pagination;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_CSV;
use PHPExcel_Reader_Excel5;
use app\models\UploadFile;
use yii\web\UploadedFile;

class StaceController extends BackendController
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

    public function beforeAction($action)
    {
        if((!in_array($this->action->id,['index','view','exports']))&&(AdminUser::getUserRole(Yii::$app->user->id)!=1))
        {
            return $this->showFlash('没有权限', 'error',Yii::$app->getUser()->getReturnUrl());

        }else{
            return parent::beforeAction($action);
        }


    }
    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {

        //分页读取类别数据
        $search=New Stace();
        $model =  Stace::find();
        $search->scenario='search';

        if(isset(Yii::$app->request->queryParams['Stace']))
        {

            $parms=Yii::$app->request->queryParams['Stace'];
            if(isset($parms['retrieve']))
                $model->andFilterWhere(['retrieve' => $parms['retrieve'],]);
            if(isset($parms['name']))
                $model->andFilterWhere(['like', 'name', $parms['name']]);

        }
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
            'pagination' => $pagination,
            'search'=>$search,
            'file'=>new UploadFile()
        ]);
    }


    public function actionUploadfile($pid=0)
    {
        $model=new UploadFile();
        $model->file = UploadedFile::getInstance($model, 'file');
        if(!$model->file){
            return $this->showFlash('未选择任何文件', 'danger',Yii::$app->getUser()->getReturnUrl());
        }
        $extension=$model->file->extension ;
        if ($extension =='xlsx') {
            $objReader = new PHPExcel_Reader_Excel2007();
            $objExcel = $objReader ->load($model->file->tempName);
        } else if ($extension =='xls') {
            $objReader = new PHPExcel_Reader_Excel5();
            $objExcel = $objReader ->load($model->file->tempName);
        } else if ($extension=='csv') {
            $PHPReader = new PHPExcel_Reader_CSV();
            //默认输入字符集
            $PHPReader->setInputEncoding('GBK');
            //默认的分隔符
            $PHPReader->setDelimiter(',');
            //载入文件
            $objExcel = $PHPReader->load($model->file->tempName);
        }

        $objWorksheet = $objExcel->getSheet(0);
        $highestRow = $objWorksheet->getHighestRow();//最大行数，为数字
        $highestColumn = $objWorksheet->getHighestColumn();//最大列数 为字母
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn); //将字母变为数字

        $tableData = [];
        for($row = 1;$row<=$highestRow;$row++){
            for($col=0;$col< $highestColumnIndex;$col++){
                $tableData[$row][$col] = $objWorksheet->getCellByColumnAndRow($col,$row)->getValue();
            }
        }
        unset($tableData[0]);
        unset($tableData[1]);
        $Pmodel=new Stace();
        $tr=Yii::$app->db->beginTransaction();
        try{
            foreach ($tableData as $k=>$v)
            {
                $_model=clone $Pmodel;
                $_model->name=trim($v['0']);
                $_model->sid=$pid;
                $_model->description=trim($v['1']);
                $_model->postion=trim($v['2']);
                $_model->handle=trim($v['3']);
                $_model->place=trim($v['4']);
                $_model->retrieve='ERHE'.time().'D'.$k;
                $_model->add_time=date('Y-m-d H:i:s');
                $_model->add_user=Yii::$app->user->id;
                if($_model->save()){
                    CommonHelper::addlog(1,$_model->id,$_model->name,'stace');
                }else{
                    $tr->rollBack();
                    return $this->showFlash('导入失败');
                }
            }
            $tr->commit();
            Yii::$app->getSession()->setFlash('success', '保存成功');

            return  $this->redirect(['sample/view','id'=>$pid]);


        }catch (excepetion $e)
        {
            $tr->rollBack();
            return $this->showFlash('导入失败');
        }
    }
    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$ret=0)
    {

        $model=$this->findModel($id);
        $parent=Sample::findOne(['id'=>$model->sid]);
        $res=Sdyeing::find()->andFilterWhere(['isdel'=>0,'yid'=>$id])->all();
        return $this->render('view', [
            'model' => $model,
            'parent'=>$parent,
            'res'=>$res,
            'ret'=>$ret,
            'file'=>new UploadFile()
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $parent=Sample::findOne(['id'=>$id]);

        $model=new Stace();
        $model->sid=$id;

        $post = Yii::$app->request->post();
        if ($post)
        {
            $tr=Yii::$app->db->beginTransaction();
            try{


                $model->attributes=$_POST['Stace'];

                $model->add_time=date('Y-m-d H:i:s');
                $model->retrieve='PSEG'.time().'A'.rand(0,9);
                $model->add_user=Yii::$app->user->id;
                if ($model->load($post)&&$model->save() )
                {
                        CommonHelper::addlog(1,$model->id,$model->name,'stace');
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '保存成功');
                        return  $this->redirect(['sample/view','id'=>$model->sid]);

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
                'parent'=>$parent,
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
    public function actionUpdate($id,$ret=0)
    {
        $model = $this->findModel($id);
        $parent=Sample::findOne(['id'=>$model->sid]);
        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try{
                $model->attributes=$_POST['Stace'];
                $model->change_time=date('Y-m-d H:i:s');
                $model->change_user=Yii::$app->user->id;
                if ($model->load($post) )
                {
                    CommonHelper::addlog(3,$model->id,$model->name,'stace');
                    if( $model->save())
                    {
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '修改成功');
                        if($ret==1){
                            return  $this->redirect(['stace/index']);

                        }else{
                            return  $this->redirect(['sample/view','id'=>$model->sid]);

                        }
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
                'parent'=>$parent
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
         $model->del_user=Yii::$app->user->id;
         $model->del_time=date('Y-m-d H:i:s');
        if($model->save()){
            CommonHelper::addlog(4,$model->id,$model->name,'stace');
            return $this->showFlash('删除成功','success',['sample/view','id'=>$model->sid]);
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
        if (($model = Stace::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}