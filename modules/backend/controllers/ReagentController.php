<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use app\models\Company;
use app\models\Reagent;
use app\models\Routine;
use yii;
use app\models\Sample;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Testmethod;
use app\helpers\CommonHelper;
use yii\data\Pagination;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_CSV;
use PHPExcel_Reader_Excel5;
use app\models\UploadFile;
use yii\web\UploadedFile;class ReagentController extends BackendController
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
        $search=New Reagent();
        $model =  Reagent::find();
        $search->scenario='search';

        if(isset(Yii::$app->request->queryParams['Reagent']))
        {

            $parms=Yii::$app->request->queryParams['Reagent'];
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

    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$ret=0)
    {
        $model=$this->findModel($id);
        $parent=Sample::findOne(['id'=>$model->sid]);
        $child=Company::find()->andFilterWhere(['rid'=>$id,'isdel'=>'0'])->all();
        return $this->render('view', [
            'model' => $model,
            'parent'=>$parent,
            'child'=>$child,
            'ret'=>$ret,
            'file'=>new UploadFile()
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id,$type)
    {


        $model=new Reagent();
        $model->retrieve='ETR'.time().'A'.rand(0,9);
        if($type=='routine'){
            $parent=Routine::findOne($id);
            $model->sid=$parent->id;
        }elseif($type=='testmethod'){
            $parent=Testmethod::findOne($id);
            $model->sid=$parent->pid;
        }
        $model->tid=$id;

        $model->type=$type;

        $post = Yii::$app->request->post();
        if ($post)
        {
            $tr=Yii::$app->db->beginTransaction();
            try{


                $model->attributes=$_POST['Reagent'];
                $model->add_time=date('Y-m-d H:i:s');

                if ($model->load($post)&&$model->save() )
                {
                        CommonHelper::addlog(1,$model->id,$model->name,'reagent');
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '保存成功');
                        return  $this->redirect(["$model->type/view",'id'=>$model->tid]);

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
                'model'=>$model
            ]);
        }

    }
    public function actionUploadfile($type='',$pid=0,$tid=0)
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
        $Pmodel=new Reagent();
        $tr=Yii::$app->db->beginTransaction();
        try{
            foreach ($tableData as $k=>$v)
            {


                $_model=clone $Pmodel;
                $_model->name=trim($v['0']);
                $_model->sid=$pid;
                $_model->tid=$tid;
                $_model->type=$type;
                $_model->retrieve='ETR'.time().'D'.$k;


                $_model->add_time=date('Y-m-d H:i:s');

                if($_model->save()){
                    CommonHelper::addlog(1,$_model->id,$_model->name,'reagent');
                }else{
                    $tr->rollBack();
                    return $this->showFlash('导入失败');
                }
            }

            $tr->commit();
            Yii::$app->getSession()->setFlash('success', '保存成功');

            return  $this->redirect(["$type/view",'id'=>$tid]);


        }catch (excepetion $e)
        {
            $tr->rollBack();
            return $this->showFlash('导入失败');
        }
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$type)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try{
                $model->attributes=$_POST['Reagent'];
                $model->change_time=date('Y-m-d H:i:s');
                $model->change_user=Yii::$app->user->id;
                if ($model->load($post) )
                {
                    CommonHelper::addlog(3,$model->id,$model->name,'reagent');
                    if( $model->save())
                    {
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '修改成功');
                        return  $this->redirect(["$model->type/view",'id'=>$model->tid]);
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
         $model->del_time=date('Y-m-d H:i:s');
            if($model->save()){
                CommonHelper::addlog(4,$model->id,$model->name,'reagent');
                return $this->showFlash('删除成功','success',["$model->type/view",'id'=>$model->tid]);
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
        if (($model = Reagent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}