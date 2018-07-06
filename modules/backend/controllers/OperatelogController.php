<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use app\models\Kit;
use yii;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\backend\Models\Operatelog;

use app\models\Reagent;
use yii\data\Pagination;
use app\helpers\CommonHelper;


class OperatelogController extends BackendController
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
        $model =  Operatelog::find();


        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $model->count(),
        ]);
        $model = $model->orderBy('id desc')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'model' => $model,
            'pagination' => $pagination,
        ]);


    }
    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionShow($type,$ret=0)
    {

        //分页读取类别数据
        $search=New Kit();
        $model =  Kit::find();
        $search->scenario='search';

        if(isset(Yii::$app->request->queryParams['Kit']))
        {

            $parms=Yii::$app->request->queryParams['Kit'];
            if(isset($parms['retrieve']))
                $model->andFilterWhere(['retrieve' => $parms['retrieve'],]);
            if(isset($parms['name']))
                $model->andFilterWhere(['like', 'name', $parms['name']]);

        }
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $model->count(),
        ]);
        $model->andFilterWhere(['isdel'=> 0,'typeid'=>$type,'type'=>'testmethod']);
        $model = $model->orderBy('id ASC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('show', [
            'model' => $model,
            'pagination' => $pagination,
            'search'=>$search,
            'type'=>$type,
            'ret'=>$ret,
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
        $Pmodel=new Testmethod();
        $tr=Yii::$app->db->beginTransaction();
        try{
            foreach ($tableData as $k=>$v)
            {


                $_model=clone $Pmodel;
                $_model->name=trim($v['0']);
                $_model->pid=$pid;
                $_model->positive=trim($v['1']);
                $_model->negative=trim($v['2']);
                $_model->judge=trim($v['3']);
                $_model->matters=trim($v['4']);
                $_model->retrieve='ETM'.time().'D'.$k;
                $_model->add_time=date('Y-m-d H:i:s');

                if($_model->save()){
                    CommonHelper::addlog(1,$_model->id,$_model->name,'testmethod');
                }else{
                    $tr->rollBack();
                    return $this->showFlash('导入失败');
                }
            }

            $tr->commit();
            Yii::$app->getSession()->setFlash('success', '保存成功');
            return  $this->redirect(['particular/view','id'=>$pid]);


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

        $child=Reagent::find()->andFilterWhere(['tid'=>$id,'isdel'=>0,'type'=>'testmethod'])->all();
        $kit=Kit::find()->andFilterWhere(['tid'=>$id,'isdel'=>0,'type'=>'testmethod'])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'child'=>$child,
            'kit'=>$kit,
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
        $model = new Testmethod();
        $model->pid=$id;
        $post = Yii::$app->request->post();
        if ($post) {
            $tr=Yii::$app->db->beginTransaction();
            try{
                $model->setAttributes($_POST['Testmethod'],false);
                $model->add_time=date('Y-m-d H:i:s');
                $model->retrieve='ETM'.time().'A'.rand(0,9);

                if ($model->load($post)&&$model->save())
                {
                    CommonHelper::addlog(1,$model->id,$model->name,'testmethod');

                    $tr->commit();
                    return $this->showFlash('添加成功','success',['particular/view','id'=>$id]);


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
    public function actionUpdate($id,$ret=0)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try {
                $model->setAttributes($_POST['Testmethod'], false);
                if ($model->load($post) && $model->save())
                {

                    CommonHelper::addlog(3, $model->id, $model->name, 'testmethod');
                    $tr->commit();
                    if($ret==1){
                        return $this->showFlash('修改成功','success',['testmethod/index']);

                    }else{
                        return $this->showFlash('修改成功','success',['particular/view','id'=>$model->pid]);

                    }

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
            CommonHelper::addlog(4,$model->id,$model->name,'testmethod');
            return $this->showFlash('删除成功','success',['particular/view','id'=>$model->pid]);
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
        if (($model = Testmethod::findOne($id)) !== null)
        {
            return $model;

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}