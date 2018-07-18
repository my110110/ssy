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
use app\models\Stace;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Sdyeing;
use app\modules\backend\models\AdminUser;
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

    public function beforeAction($action)
    {
        if((!in_array($this->action->id,['index','view','exports']))&&(AdminUser::getUserRole(Yii::$app->user->id)!=1))
        {
            return $this->showFlash('没有权限', 'error',Yii::$app->getUser()->getReturnUrl());

        }else{
            return parent::beforeAction($action);
        }


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
    public  function actionExports($id)
    {
        ini_set("memory_limit", "2048M");
        set_time_limit(0);

        //获取用户ID

        //去用户表获取用户信息

        $data=Sdyeing::find()->andFilterWhere(['yid'=>$id])->all();
                $sdy=[];
        foreach ($data as $k=>$v){
            $sdy[$k]['A']=$v->section_name;
            $sdy[$k]['B']=Stace::getParName($v->yid);
            $sdy[$k]['C']=$v->retrieve;
            $sdy[$k]['D']=$this->getShiji($v->ntype,$v->nid);
            if($v->ntype==1){
                $sdy[$k]['E']=Reagent::getNames($v->rgid);
                $sdy[$k]['F']='';
                $sdy[$k]['G']='';
                $sdy[$k]['H']='';
            }elseif ($v->ntype==2){
                $sdy[$k]['E']=Reagent::getNames($v->rgid);
                $sdy[$k]['F']=Kit::getNames($v->kit);
                $sdy[$k]['G']='';
                $sdy[$k]['H']='';
            }elseif ($v->ntype==3){
                $sdy[$k]['E']='';
                $sdy[$k]['F']='';
                $sdy[$k]['G']=Kit::getNames($v->kit);
                $sdy[$k]['H']='';
            }
            elseif ($v->ntype==4){
                $sdy[$k]['E']='';
                $sdy[$k]['F']='';
                $sdy[$k]['G']='';
                $sdy[$k]['H']=Kit::getNames($v->kit);
            }
            $sdy[$k]['I']=$v->section_type;
            $sdy[$k]['J']=$v->section_thickness;
            $sdy[$k]['K']=$v->section_preprocessing;
            $sdy[$k]['L']=$v->place;
            $sdy[$k]['M']=$v->img;
            $sdy[$k]['N']=strip_tags($v->testflow);
            $sdy[$k]['O']=strip_tags($v->attention);
        }
        //获取传过来的信息（时间，公司ID之类的，根据需要查询资料生成表格）
        $objectPHPExcel = new \PHPExcel();

        //设置表格头的输出
            $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(18);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('A1', '切片名称');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('B1', '所属样本');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('C1', '检索号');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('D1', '检测指标');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('E1', '使用自配试剂');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('F1', '使用商品试剂');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('G1', '使用抗体');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('H1', '使用核算试剂盒');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('I1', '切片类型');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('J1', '切片厚度');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('K1', '切片预处理');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('L1', '存放位置');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('M1', '切片数字图像文件');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('N1', '实验流程');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('O1', '注意事项');
        //跳转到recharge这个model文件的statistics方法去处理数据

        //指定开始输出数据的行数
        $n = 2;
        foreach ($sdy as $v)
        {
                $objectPHPExcel->getActiveSheet()->getRowDimension($n)->setRowHeight(80);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('C'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('D'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('F'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('G'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('H'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('I'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('J'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('K'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('L'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('M'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('N'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('O'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);

                $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['A']);
                $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,$v['B']);
                $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['B']);
                $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['D']);
                $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['E']);
                $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n) ,$v['F']);
                $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n) ,$v['G']);
                $objectPHPExcel->getActiveSheet()->setCellValue('H'.($n) ,$v['H']);
                $objectPHPExcel->getActiveSheet()->setCellValue('I'.($n) ,$v['I']);
                $objectPHPExcel->getActiveSheet()->setCellValue('J'.($n) ,$v['J']);
                $objectPHPExcel->getActiveSheet()->setCellValue('K'.($n) ,$v['K']);
                $objectPHPExcel->getActiveSheet()->setCellValue('L'.($n) ,$v['L']);
                $objectPHPExcel->getActiveSheet()->setCellValue('N'.($n) ,$v['N']);
                $objectPHPExcel->getActiveSheet()->setCellValue('O'.($n) ,$v['O']);

                if(!empty($v['M']))
                {
                    $image ='./'.$v['M'];
                    if (@fopen($image, 'r')) {
                        //这是一个坑,刚开始我把实例化图片类放在了循环外面,但是失败了,也就是每个图片都要实例化一次
                        $objDrawing = new \PHPExcel_Worksheet_Drawing();
                        $objDrawing->setPath($image);
                        // 设置图片的宽度
                        $objDrawing->setHeight(100);
                        $objDrawing->setWidth(100);
                        $objDrawing->setCoordinates('M' . $n);
                        $objDrawing->setWorksheet($objectPHPExcel->getActiveSheet());
                    }
                }

                $n = $n +1;
        }

        ob_end_clean();
        ob_start();
        header('Content-Type : application/vnd.ms-excel');

        //设置输出文件名及格式
        header('Content-Disposition:attachment;filename="'.date("YmdHis").'.xls"');

        //导出.xls格式的话使用Excel5,若是想导出.xlsx需要使用Excel2007
        $objWriter= \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $objWriter->save('php://output');
        ob_end_flush();

        //清空数据缓存
        unset($data);
    }
public function getShiji($type,$nid){
        switch ($type){
            case 1:
                $data=Routine::findOne($nid);
                if($data){
                    return $data->name;
                }else{
                    return '';
                }
                break;
            case 2:
                $data=Particular::findOne($nid);
                if($data){
                    return $data->name;
                }else{
                    return '';
                }
                break;
            case 3:
                $data=Kit::findOne($nid);
                if($data){
                    return $data->name;
                }else{
                    return '';
                }
                break;
            case 4:
                $data=Kit::findOne($nid);
                if($data){
                    return $data->name;
                }else{
                    return '';
                }

                break;
        }
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