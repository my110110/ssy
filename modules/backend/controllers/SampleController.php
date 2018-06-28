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
use yii\data\Pagination;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_CSV;
use PHPExcel_Reader_Excel5;
use app\models\UploadFile;
use yii\web\UploadedFile;


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

        //分页读取类别数据
        $search=New Sample();
        $model =  Sample::find();
        $search->scenario='search';

        if(isset(Yii::$app->request->queryParams['Sample']))
        {

            $parms=Yii::$app->request->queryParams['Sample'];
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
        $Pmodel=new Sample();
        $perent=Group::findOne($pid);
        $tr=Yii::$app->db->beginTransaction();
        try{
            foreach ($tableData as $k=>$v)
            {


                $_model=clone $Pmodel;
                $_model->name=trim($v['0']);
                $_model->gid=$pid;
                $_model->pid=$perent->pro_id;
                $_model->descript=trim($v['1']);
                $_model->retrieve='PSEG'.time().'D'.$k;
                $_model->add_time=date('Y-m-d H:i:s');
                $_model->add_user=Yii::$app->user->id;

                if($_model->save()){
                    CommonHelper::addlog(1,$_model->id,$_model->name,'sample');
                }else{
                    $tr->rollBack();
                    return $this->showFlash('导入失败');
                }
            }

            $tr->commit();
            Yii::$app->getSession()->setFlash('success', '保存成功');

            return  $this->redirect(['group/view','id'=>$pid]);


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
        $stace=Stace::findAll(['sid'=>$id,'isdel'=>'0']);
        $group=Group::findOne(['id'=>$model->gid]);

        return $this->render('view', [
            'model' => $model,
            'group'=>$group,
            'stace'=>$stace,
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
                $sample->retrieve='PSEG'.time().'A'.rand(0,9);
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
    public function actionUpdate($id,$ret=0)
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
                        if($ret==1){
                            return  $this->redirect(['sample/index']);
                        }else{
                            return  $this->redirect(['group/view','id'=>$model->id]);

                        }
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
    public function actionDelete($id)
    {
        $model=Sample::findOne(['id'=>$id]);
        $model->isdel=1;
        $model->del_user=Yii::$app->user->id;
        $model->del_time=date('Y-m-d H:i:s');
        if($model->save()){
            CommonHelper::addlog(4,$model->id,$model->name,'sample');
            return $this->showFlash('删除成功','success',['sample/index']);
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