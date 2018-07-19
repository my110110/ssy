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
use app\modules\backend\models\AdminUser;

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

    public function beforeAction($action)
    {
        if((!in_array($this->action->id,['index','view','export']))&&(AdminUser::getUserRole(Yii::$app->user->id)!=1))
        {
            return $this->showFlash('没有权限', 'error',Yii::$app->getUser()->getReturnUrl());

        }else{
            return parent::beforeAction($action);
        }


    }

    public  function actionExport($id)
    {
        ini_set("memory_limit", "2048M");
        set_time_limit(0);

        //获取用户ID

        //去用户表获取用户信息

        $data=Particular::find()->andFilterWhere(['id'=>$id])->One();
        $test=Testmethod::find()->andFilterWhere(['pid'=>$id])->all();
        $arr=[];
        $m=0;
        foreach ($test as $k1=>$v1)
        {
            $Reagent=Reagent::find()->andFilterWhere(['tid'=>$v1->id])->all();
            $kit=Kit::find()->andFilterWhere(['tid'=>$v1->id])->all();
            if(count($Reagent)>0){
                foreach ($Reagent as $k2=>$v2){
                    $arr[$m]['A']=$data->name;
                    $arr[$m]['B']=$data->retrieve;

                    $arr[$m]['C']=$v1->name;
                    $arr[$m]['D']=$v1->retrieve;
                    $arr[$m]['E']=$v1->positive;
                    $arr[$m]['F']=$v1->negative;
                    $arr[$m]['G']=$v1->judge;
                    $arr[$m]['H']='自配试剂';
                    $arr[$m]['I']=$v2->name;
                    $arr[$m]['J']=$v2->retrieve;
                    $arr[$m]['K']='';
                    $arr[$m]['L']='';
                    $arr[$m]['M']='';
                    $m=$m+1;

                }
            }
            if(count($kit)>0){
                foreach ($kit as $k3=>$v3){
                    $arr[$m]['A']=$data->name;
                    $arr[$m]['B']=$data->retrieve;
                    $arr[$m]['C']=$v1->name;
                    $arr[$m]['D']=$v1->retrieve;
                    $arr[$m]['E']=$v1->positive;
                    $arr[$m]['F']=$v1->negative;
                    $arr[$m]['G']=$v1->judge;
                    $arr[$m]['H']='商品试剂';
                    $arr[$m]['I']=$v3->name;
                    $arr[$m]['J']=$v3->retrieve;
                    $arr[$m]['K']=$v3->company;
                    $arr[$m]['L']=$v3->http;
                    $arr[$m]['M']=$v3->pdf;
                    $m=$m+1;

                }
            }
            if(count($Reagent)<=0&&count($kit)<=0){
                $arr[$m]['A']=$data->name;
                $arr[$m]['B']=$data->retrieve;
                $arr[$m]['C']='';
                $arr[$m]['D']='';
                $arr[$m]['E']='';
                $arr[$m]['G']='';
                $arr[$m]['H']='';
                $arr[$m]['I']='';
                $arr[$m]['J']='';
                $arr[$m]['K']='';
                $arr[$m]['L']='';
                $arr[$m]['M']='';

                $m=$m+1;
            }
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

        $objectPHPExcel->setActiveSheetIndex()->setCellValue('A1', '指标名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('B1', '检索号');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('C1', '测试方法名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('D1', '检索号');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('E1', '阳性对照');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('F1', '阴性对照');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('G1', '结果判断');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('H1', '注意事项');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('I1', '试剂名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('J1', '检索号');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('K1', '公司名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('L1', '官网地址');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('M1', '说明');

        //跳转到recharge这个model文件的statistics方法去处理数据

        //指定开始输出数据的行数
        $n = 2;
        foreach ($arr as $v)
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

            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['A']);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,$v['B']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['C']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['D']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['E']);
            $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n) ,$v['F']);
            $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n) ,$v['G']);
            $objectPHPExcel->getActiveSheet()->setCellValue('H'.($n) ,$v['H']);
            $objectPHPExcel->getActiveSheet()->setCellValue('I'.($n) ,$v['I']);
            $objectPHPExcel->getActiveSheet()->setCellValue('J'.($n) ,$v['J']);
            $objectPHPExcel->getActiveSheet()->setCellValue('K'.($n) ,$v['K']);
            $objectPHPExcel->getActiveSheet()->setCellValue('L'.($n) ,$v['L']);
            $objectPHPExcel->getActiveSheet()->setCellValue('M'.($n) ,$v['M']);




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
        unset($kit);
        unset($arr);
        unset($data);
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