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
use app\models\Particular;
use app\models\Sdyeing;
use app\models\Testmethod;
use app\models\Kit;
use app\models\Reagent;
use yii\web\Response;
use yii\data\Pagination;
use app\helpers\CommonHelper;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_CSV;
use PHPExcel_Reader_Excel5;
use app\models\UploadFile;
use yii\web\UploadedFile;
class ParticularController extends BackendController
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

        $model =  Particular::find();


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
            'pagination'=>$pagination,
            'file'=>new UploadFile()
        ]);


    }

    public function actionUploadfile()
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
        $Pmodel=new Particular();
        $tr=Yii::$app->db->beginTransaction();
        try{
            foreach ($tableData as $k=>$v)
            {


                $_model=clone $Pmodel;
                $_model->name=trim($v['0']);
                $_model->retrieve='ETS'.time().'D'.$k;
                $_model->add_time=date('Y-m-d H:i:s');

                if($_model->save()){
                    CommonHelper::addlog(1,$_model->id,$_model->name,'particular');
                }else{
                    $tr->rollBack();
                    return $this->showFlash('导入失败');
                }
            }

            $tr->commit();
            Yii::$app->getSession()->setFlash('success', '保存成功');

            return  $this->redirect(['particular/index']);


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
    public function actionView($id)
    {

        $child=Testmethod::find()->andFilterWhere(['pid'=>$id,'isdel'=>0])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'child'=>$child,
            'file'=>new UploadFile()

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
        $particular=Particular::find()->andFilterWhere(['isdel'=>'0'])->all();

        $reagent=Reagent::find()->andFilterWhere(['isdel'=>0,'type'=>'testmethod'])->all();
        $kit=Kit::find()->andFilterWhere(['isdel'=>0,'type'=>'testmethod'])->all();

        $model ->yid= $id;
        $post = Yii::$app->request->post();
        if ($post) {
            $tr=Yii::$app->db->beginTransaction();
            try{
                $post['Sdyeing']['kit']=isset($post['Sdyeing']['kit']) ? json_encode(  $post['Sdyeing']['kit']) : '';;
                $post['Sdyeing']['rgid']=isset($post['Sdyeing']['rgid']) ? json_encode(  $post['Sdyeing']['rgid']) : '';
                $model->setAttributes($_POST['Sdyeing'],false);
                $model->add_time=date('Y-m-d H:i:s');
                $model->ntype=2;
                $model->retrieve='ERSS'.time().'A'.rand(0,9);
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
            'particular'=>$particular,
            'reagent'=>$reagent,
            'kit'=>$kit
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionChange($id,$ret=0)
    {
        $model =Sdyeing::findOne($id);
        $particular=Particular::find()->andFilterWhere(['isdel'=>'0'])->all();
        $reagent=Reagent::find()->andFilterWhere(['isdel'=>0,'type'=>'testmethod'])->all();
        $kit=Kit::find()->andFilterWhere(['isdel'=>0,'type'=>'testmethod'])->all();

        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try {
                $model->setAttributes($_POST['Sdyeing'], false);
                $newkit = Kit::find()->select('id')->andFilterWhere(['type' => 'testmethod', 'rid' => $post['Sdyeing']['nid']])->asArray()->all();
                $kid = [];
                foreach ($newkit as $vn) {
                    $kid[] = $vn['id'];
                }
                $newk=isset($post['Sdyeing']['kit']) ? $post['Sdyeing']['kit']: [ ];
                $kids = array_values(array_intersect($newk, $kid));
                $post['Sdyeing']['kit'] = !empty($kids) ? json_encode($kids) : '';


                $newrg = Reagent::find()->select('id')->andFilterWhere(['type' => 'testmethod', 'sid' => $post['Sdyeing']['nid']])->asArray()->all();
                $rgid = [];
                foreach ($newrg as $v) {
                    $rgid[] = $v['id'];
                }
                $nwrg=isset($post['Sdyeing']['rgid']) ? $post['Sdyeing']['rgid']:array();
                $rgids = array_values(array_intersect($nwrg, $rgid));
                $post['Sdyeing']['rgid'] = !empty($rgids) ? json_encode($rgids) : '';


                if ($model->load($post) && $model->save())
                {

                    CommonHelper::addlog(3, $model->id, $model->section_name, 'sdyeing');
                    $tr->commit();
                    if($ret==1){
                        return $this->showFlash('修改成功', 'success', ['sdyeing/index']);
                    }else{
                        return $this->showFlash('修改成功', 'success', ['stace/view', 'id' => $model->yid]);

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
            return $this->render('change', [
                'model' => $model,
                'particular'=>$particular,
                'reagent'=>$reagent,
                'kit'=>$kit
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
        $model = new Particular();
        $model->retrieve='ETS'.time().'A'.rand(0,9);
        $post = Yii::$app->request->post();
        if ($post) {
            $tr=Yii::$app->db->beginTransaction();
            try{

                $model->setAttributes($_POST['Particular'],false);
                $model->add_time=date('Y-m-d H:i:s');

                if ($model->load($post)&&$model->save())
                {
                    CommonHelper::addlog(1,$model->id,$model->name,'particular');

                    $tr->commit();
                    return $this->showFlash('添加成功','success',['particular/index']);


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
                $model->setAttributes($_POST['Particular'], false);
                if ($model->load($post) && $model->save())
                {

                    CommonHelper::addlog(3, $model->id, $model->name, 'particular');
                    $tr->commit();
                    return $this->showFlash('修改成功','success',['particular/index']);
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
        if (($model = Particular::findOne($id)) !== null)
        {
            return $model;

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}