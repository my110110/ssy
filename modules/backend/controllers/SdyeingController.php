<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use app\models\Kit;
use app\models\Reagent;
use app\models\Routine;
use app\models\Particular;
use app\models\Pna;
use yii;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Sdyeing;
use yii\web\Response;
use yii\data\Pagination;
use app\helpers\CommonHelper;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_CSV;
use PHPExcel_Reader_Excel5;
use app\models\UploadFile;
use yii\web\UploadedFile;
class SdyeingController extends BackendController
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


    public function actionUploadfile($pid=0)
    {
        $model=new UploadFile();
        $model->file = UploadedFile::getInstance($model, 'file');
        if(!$model->file){
            return $this->showFlash('未选择任何文件', 'danger',Yii::$app->getUser()->getReturnUrl());
        }

        $ntype=intval($_POST['ntype']);
        switch ($ntype){
            case 1:
                $re='ERHE';
                break;
            case 2 :
                $re='ERSS';
                break;
            case 3:
                $re='ERP';
                break;
            case 4:
                $re='ERN';
                break;
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
        $Pmodel=new Sdyeing();
        $tr=Yii::$app->db->beginTransaction();
        try{
            foreach ($tableData as $k=>$v)
            {
                $_model=clone $Pmodel;
                $_model->section_name=trim($v['0']);
                $_model->yid=$pid;
                $_model->ntype=$ntype;
                $_model->section_thickness=trim($v['1']);
                $_model->section_preprocessing=trim($v['2']);
                $_model->place=trim($v['3']);
                $_model->section_type=trim($v['4']);
                $_model->retrieve=$re.time().'D'.$k;
                $_model->add_time=date('Y-m-d H:i:s');
                $_model->add_user=Yii::$app->user->id;
                if($_model->save()){
                    CommonHelper::addlog(1,$_model->id,$_model->section_name,'sdyeing');
                }else{
                    $tr->rollBack();
                    return $this->showFlash('导入失败');
                }
            }
            $tr->commit();
            Yii::$app->getSession()->setFlash('success', '保存成功');

            return  $this->redirect(['stace/view','id'=>$pid]);


        }catch (excepetion $e)
        {
            $tr->rollBack();
            return $this->showFlash('导入失败');
        }
    }

    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex($yid=0)
    {
        //分页读取类别数据
        $search=New Sdyeing();
        $model =  Sdyeing::find();
        $search->scenario='search';

        if(isset(Yii::$app->request->queryParams['Sdyeing']))
        {

            $parms=Yii::$app->request->queryParams['Sdyeing'];
            if(isset($parms['retrieve']))
                $model->andFilterWhere(['retrieve' => $parms['retrieve'],]);
            if(isset($parms['section_name']))
                $model->andFilterWhere(['like', 'section_name', $parms['section_name']]);

        }
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $model->count(),
        ]);
        if($yid>0){
            $model->andFilterWhere(['yid'=> $yid]);
        }
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
    public function actionView($id)
    {
        $model=$this->findModel($id);
        //检测指标
        if($model->ntype==1){
            //常规H&E染色
            $norm=Routine::findOne(['id'=>$model->nid]);
            //自配试剂
            $Reagent=Reagent::find()->andFilterWhere(['id'=>json_decode($model->rgid)?:0])->all();
            $kit=array();
        }elseif ($model->ntype==2){
            $norm=Particular::findOne(['id'=>$model->nid]);
            //自配试剂
            $Reagent=Reagent::find()->andFilterWhere(['id'=>json_decode($model->rgid)?:0])->all();

            //商品试剂
            $kit=Kit::find()->andFilterWhere(['id'=>json_decode($model->kit)?:0])->all();
        }
        elseif ($model->ntype==3){
            $norm=Pna::findOne(['id'=>$model->nid,'type'=>1]);
            $kit=Kit::find()->andFilterWhere(['id'=>json_decode($model->kit)?:0])->all();
            $Reagent=[];
        }
        elseif ($model->ntype==4){
            $norm=Pna::findOne(['id'=>$model->nid,'type'=>2]);
            $Reagent=[];
            $kit=Kit::find()->andFilterWhere(['id'=>json_decode($model->kit)?:0])->all();
        }
        return $this->render('view', [
            'model' =>$model,
            'norm'=>$norm,
            'kit'=>$kit,
            'Reagent'=>$Reagent

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
            CommonHelper::addlog(4,$model->id,$model->section_name,'sdyeing');
            return $this->showFlash('删除成功','success',['stace/view','id'=>$model->yid]);
        }
        return $this->showFlash('删除失败', 'danger',Yii::$app->getUser()->getReturnUrl());
    }

    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $model->isdel=1;
        if($model->save())
        {
            CommonHelper::addlog(4,$model->id,$model->section_name,'sdyeing');
            return $this->showFlash('删除成功','success',['sdyeing/index']);
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
        if (($model = Sdyeing::findOne($id)) !== null)
        {
            return $model;

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}