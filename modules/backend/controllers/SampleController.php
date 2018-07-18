<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use app\models\Stace;
use app\modules\backend\models\AdminUser;

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

    public function beforeAction($action)
    {
        if((!in_array($this->action->id,['index','view','export']))&&(AdminUser::getUserRole(Yii::$app->user->id)!=1))
        {
            return $this->showFlash('没有权限', 'error',Yii::$app->getUser()->getReturnUrl());

        }else{
            return parent::beforeAction($action);
        }


    }


    public  function actionExports($id)
    {
        ini_set("memory_limit", "2048M");
        set_time_limit(0);

        //获取用户ID

        //去用户表获取用户信息

        //获取传过来的信息（时间，公司ID之类的，根据需要查询资料生成表格）
        $objectPHPExcel = new \PHPExcel();
        $sample=Sample::find()->andFilterWhere(['gid'=>$id,'isdel'=>'0'])->all();
        if(count($sample)>0)
        {
            $sm = [];
            $m = 0;
            foreach ($sample as $v1) {
                $stace = Stace::find()->andFilterWhere(['sid' => $v1->id, 'isdel' => '0'])->all();
                if (count($stace) > 0)
                {

                    foreach ($stace as $v2) {
                        $sm[$m] = [
                            'A' => $v1->name,
                            'B' => $v1->retrieve,
                            'C' => $v1->descript,
                            'D' => $v2->name,
                            'E' => $v2->retrieve,
                            'F' => $v2->description,
                            'G' => $v2->postion,
                            'H' => $v2->handle,
                            'I' => $v2->place,
                            'J' => $v1->gid,
                            'K' => $v2->id
                        ];
                        $m = $m + 1;
                    }
                }
                else
                {
                    $sm[$m] = [
                        'A' => $v1->name,
                        'B' => $v1->retrieve,
                        'C' => $v1->descript,
                        'D' => '',
                        'E' => '',
                        'F' => '',
                        'G' => '',
                        'H' => '',
                        'I' => '',
                        'J' => $v1->gid,
                        'K' => '0'
                    ];
                }

                $m = $m + 1;
            }
        }
        //设置表格头的输出
        $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objectPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);





        //跳转到recharge这个model文件的statistics方法去处理数据

        //指定开始输出数据的行数







              $n=1;
              //合并单元格
              $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n),'包含的样本信息');
              $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getFont()->setName('宋体') //字体
              ->setSize(15) //字体大小
              ->setBold(true); //字体加粗
              $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $objectPHPExcel->getActiveSheet()->mergeCells('A'.($n).':'.'J'.($n));
              $n=$n+1;
              $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getFont()->setName('宋体') //字体
              ->setSize(10) //字体大小
              ->setBold(true); //字体加粗
              $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getFont()->setName('宋体') //字体
              ->setSize(10) //字体大小
              ->setBold(true); //字体加
              $objectPHPExcel->setActiveSheetIndex()->getStyle('C'.($n))->getFont()->setName('宋体') //字体
              ->setSize(10) //字体大小
              ->setBold(true); //字体加粗
              $objectPHPExcel->setActiveSheetIndex()->getStyle('D'.($n))->getFont()->setName('宋体') //字体
              ->setSize(10) //字体大小
              ->setBold(true); //字体加粗
              $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getFont()->setName('宋体') //字体
              ->setSize(10) //字体大小
              ->setBold(true); //字体加粗
              $objectPHPExcel->setActiveSheetIndex()->getStyle('F'.($n))->getFont()->setName('宋体') //字体
              ->setSize(10) //字体大小
              ->setBold(true); //字体加粗
              $objectPHPExcel->setActiveSheetIndex()->getStyle('G'.($n))->getFont()->setName('宋体') //字体
              ->setSize(10) //字体大小
              ->setBold(true); //字体加粗
              $objectPHPExcel->setActiveSheetIndex()->getStyle('H'.($n))->getFont()->setName('宋体') //字体
              ->setSize(10) //字体大小
              ->setBold(true); //字体加粗
              $objectPHPExcel->setActiveSheetIndex()->getStyle('I'.($n))->getFont()->setName('宋体') //字体
              ->setSize(10) //字体大小
              ->setBold(true); //字体加粗
              $objectPHPExcel->setActiveSheetIndex()->getStyle('J'.($n))->getFont()->setName('宋体') //字体
              ->setSize(10) //字体大小
              ->setBold(true); //字体加粗
              $objectPHPExcel->setActiveSheetIndex()->setCellValue('A'.($n), '样品名称');
              $objectPHPExcel->setActiveSheetIndex()->setCellValue('B'.($n), '所属分组');
              $objectPHPExcel->setActiveSheetIndex()->setCellValue('C'.($n), '样品检索号');
              $objectPHPExcel->setActiveSheetIndex()->setCellValue('D'.($n), '样品描述');
              $objectPHPExcel->setActiveSheetIndex()->setCellValue('E'.($n), '样本名称');
              $objectPHPExcel->setActiveSheetIndex()->setCellValue('F'.($n), '样本检索号');
              $objectPHPExcel->setActiveSheetIndex()->setCellValue('G'.($n), '组织/细胞位置');
              $objectPHPExcel->setActiveSheetIndex()->setCellValue('H'.($n), '处理方式');
              $objectPHPExcel->setActiveSheetIndex()->setCellValue('I'.($n), '存放位置');
              $objectPHPExcel->setActiveSheetIndex()->setCellValue('J'.($n), '样本描述');
              $n = $n +1;
              foreach ($sm as $v)
              {
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('C'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('D'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('F'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('G'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('H'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('I'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('J'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('G'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('H'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('I'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                  $objectPHPExcel->setActiveSheetIndex()->getStyle('J'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                  $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['A']);
                  $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,Group::getParName($v['J']));
                  $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['B']);
                  $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['C']);
                  $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['D']);
                  $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n) ,$v['E']);
                  $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n) ,$v['G']);
                  $objectPHPExcel->getActiveSheet()->setCellValue('H'.($n) ,$v['H']);
                  $objectPHPExcel->getActiveSheet()->setCellValue('I'.($n) ,$v['I']);
                  $objectPHPExcel->getActiveSheet()->setCellValue('J'.($n) ,$v['F']);
                  $n = $n +1;

                  $syid[]=$v['K'];




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