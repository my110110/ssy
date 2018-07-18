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
use app\models\Pna;
use app\modules\backend\models\AdminUser;

use app\models\Sdyeing;
use yii\data\Pagination;
use app\helpers\CommonHelper;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_CSV;
use PHPExcel_Reader_Excel5;
use app\models\UploadFile;
use yii\web\UploadedFile;
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

    public function beforeAction($action)
    {
        if((!in_array($this->action->id,['index','view','export']))&&(AdminUser::getUserRole(Yii::$app->user->id)!=1))
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
            'type'=>$type,
            'file'=>new UploadFile()
        ]);


    }

    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionShow($type)
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
        $model->andFilterWhere(['isdel'=> 0,'typeid'=>$type,'type'=>'pna']);
        $model = $model->orderBy('id ASC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('show', [
            'model' => $model,
            'pagination' => $pagination,
            'search'=>$search,
            'type'=>$type,
            'file'=>new UploadFile()
        ]);


    }


    public  function actionExport($id,$type)
    {
        ini_set("memory_limit", "2048M");
        set_time_limit(0);

        //获取用户ID

        //去用户表获取用户信息

        $data=Pna::find()->andFilterWhere(['id'=>$id,'type'=>$type])->all();
        if($type==1){
            $kit=Kit::find()->andFilterWhere(['rid'=>$id,'typeid'=>'1'])->all();
        }
        $sdy=[];
        foreach ($kit as $k=>$v){
            $sdy[$k]['A']=$data->name;
            $sdy[$k]['B']=$data->retrieve;
            $sdy[$k]['C']=$data->OfficialSymbol;
            $sdy[$k]['D']=$data->OfficialFullName;
            $sdy[$k]['E']=$data->GeneID;
            $sdy[$k]['F']=$data->function;
            $sdy[$k]['G']=$data->NCBIgd;
            $sdy[$k]['H']=$data->GeneGards;

            $sdy[$k]['I']=$data->standard;
            $sdy[$k]['J']=$data->cells;
            $sdy[$k]['K']=$v->name;
            $sdy[$k]['L']=$v->retrieve;
            $sdy[$k]['M']=$v->company;
            $sdy[$k]['N']=$v->http;
            $sdy[$k]['O']=$v->attention;
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
            $objectPHPExcel->getActiveSheet()->setCellValue('M'.($n) ,$v['M']);
            $objectPHPExcel->getActiveSheet()->setCellValue('N'.($n) ,$v['N']);
            $objectPHPExcel->getActiveSheet()->setCellValue('O'.($n) ,$v['O']);



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


    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdd($id,$ntype)
    {
        $model = new Sdyeing();
        if($ntype==3){

            $type=1;//蛋白
        }else{
            $type=2;//核酸
        }
        $pna=Pna::find()->andFilterWhere(['isdel'=>'0','type'=>$type])->all();

        $kit=Kit::find()->andFilterWhere(['isdel'=>0,'type'=>'pna'])->all();

        $model ->yid= $id;
        $model ->ntype= $ntype;
        $post = Yii::$app->request->post();
        if ($post) {
            $tr=Yii::$app->db->beginTransaction();
            try{
                $post['Sdyeing']['kit']=isset($post['Sdyeing']['kit']) ? json_encode(  $post['Sdyeing']['kit']) : '';;
                $post['Sdyeing']['rgid']=isset($post['Sdyeing']['rgid']) ? json_encode(  $post['Sdyeing']['rgid']) : '';
                $model->setAttributes($_POST['Sdyeing'],false);
                $model->add_time=date('Y-m-d H:i:s');
                if($model->ntype==3){
                    $model->retrieve='ERP'.time().'A'.rand(0,9);

                }elseif ($model->ntype==4){
                    $model->retrieve='ERN'.time().'A'.rand(0,9);

                }
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
            'pna'=>$pna,
            'kit'=>$kit
        ]);
    }


    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionChange($id,$ntype,$ret=0)
    {
        $model =Sdyeing::findOne($id);
        if($ntype==3){

            $type=1;//蛋白
        }elseif($ntype==4){
            $type=2;//核酸
        }
        $pna=Pna::find()->andFilterWhere(['isdel'=>'0','type'=>$type])->all();

        $kit=Kit::find()->andFilterWhere(['isdel'=>0,'type'=>'pna'])->all();

        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try {
                $model->setAttributes($_POST['Sdyeing'], false);
                $newkit = Kit::find()->select('id')->andFilterWhere(['type' => 'pna', 'rid' => $post['Sdyeing']['nid']])->asArray()->all();
                $kid = [];
                foreach ($newkit as $vn) {
                    $kid[] = $vn['id'];
                }
                $newk=isset($post['Sdyeing']['kit']) ? $post['Sdyeing']['kit']: [ ];
                $kids = array_values(array_intersect($newk, $kid));
                $post['Sdyeing']['kit'] = !empty($kids) ? json_encode($kids) : '';


                if ($model->load($post) && $model->save())
                {

                    CommonHelper::addlog(3, $model->id, $model->section_name, 'sdyeing');
                    $tr->commit();
                    if($ret==1){
                        return $this->showFlash('修改成功', 'success', ['sdyeing/index']);
                    }else{
                        return $this->showFlash('修改成功', 'success', ['stace/view', 'id' => $model->yid]);

                    }                } else {
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
                'pna'=>$pna,
                'kit'=>$kit
            ]);
        }
    }



    public function actionUploadfile($type=0)
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
        $Pmodel=new Pna();
        $tr=Yii::$app->db->beginTransaction();
        try{
            foreach ($tableData as $k=>$v)
            {


                $_model=clone $Pmodel;
                $_model->name=trim($v['0']);
                $_model->OfficialSymbol=trim($v['1']);
                $_model->OfficialFullName=trim($v['2']);
                $_model->GeneID=trim($v['3']);
                $_model->function=trim($v['4']);
                $_model->NCBIgd=trim($v['5']);
                $_model->GeneGards=trim($v['6']);
                $_model->standard=trim($v['7']);
                $_model->cells=trim($v['8']);
                $_model->type=$type;
                if($type==1){
                    $_model->retrieve='ETP'.time().'D'.$k;
                }elseif ($type==2){
                    $_model->retrieve='ETN'.time().'D'.$k;
                }

                $_model->add_time=date('Y-m-d H:i:s');

                if($_model->save()){
                    CommonHelper::addlog(1,$_model->id,$_model->name,'pna');
                }else{
                    $tr->rollBack();
                    return $this->showFlash('导入失败');
                }
            }

            $tr->commit();
            Yii::$app->getSession()->setFlash('success', '保存成功');

            return  $this->redirect(['pna/index','type'=>$type]);


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

        $child=Kit::find()->andFilterWhere(['rid'=>$id,'isdel'=>0,'type'=>'pna'])->all();
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
    public function actionCreate($type)
    {
        $model = new Pna();
        $model->type=$type;
        if($type==1){
            $model->retrieve='ETP'.time().'A'.rand(0,9);
        }elseif ($type==2){
            $model->retrieve='ETN'.time().'A'.rand(0,9);
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
    public function actionUpdate($id,$type)
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
                'type'=>$type
            ]);
        }
    }


    public function actionDel($id)
    {
        $model=$this->findModel($id);
        $model->isdel=1;
        if($model->save())
        {
            CommonHelper::addlog(4,$model->id,$model->name,'pna');
            return $this->showFlash('删除成功','success',['pna/index','id'=>$model->id]);
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