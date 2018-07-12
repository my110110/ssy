<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use app\models\Group;
use app\modules\backend\models\AdminUser;
use yii;
use app\models\Project;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Principal;
use yii\web\Response;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_CSV;
use PHPExcel_Reader_Excel5;
use app\models\UploadFile;
use yii\web\UploadedFile;
use app\helpers\CommonHelper;
use moonland\phpexcel\Excel;
use \PHPExcel_Worksheet_Drawing;
class ProjectController extends BackendController
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

    public function actionDelete_all()
   {
           Yii::$app->response->format = Response::FORMAT_JSON;

           $ids =  Yii::$app->request->post('ids');
           if(empty($ids)){
               return ['data'=>'至少选择一个','code'=>1];
           }
           $attr = ['isdel'=>1];
           /** @var $query ContentQuery */
           $query = Project::find();

           $query->andFilterWhere([
               'in', 'pro_id', $ids
           ]);
           try {
               Project::updateAll($attr,$query->where);
               return [
                   'code'=>0,
                   'data'=>'操作成功'
               ];
           }catch(Exception $e)
           {
               return [
                   'code'=>1,
                   'data'=>$e->getMessage()
               ];
           }
   }



    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {

        //分页读取类别数据
        $search=New Project();
        $model =  Project::find();

        if(isset(Yii::$app->request->queryParams['Project']))
        {
            $parms=Yii::$app->request->queryParams['Project'];
            if(isset($parms['pro_retrieve']))
                $model->andFilterWhere(['pro_retrieve' => $parms['pro_retrieve'],]);
            if(isset($parms['pro_name']))
                $model->andFilterWhere(['like', 'pro_name', $parms['pro_name']]);
        }
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $model->count(),
        ]);
        $model->andFilterWhere(['isdel'=> 0,'pro_pid'=>0]);
        $model = $model->orderBy('pro_id ASC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $child=Project::find()->andFilterWhere(['>', 'pro_pid', 0])->andFilterWhere(['isdel'=> 0])->all();
        $child = ArrayHelper::toArray($child);
        $model = ArrayHelper::toArray($model);
        foreach ($model as $k=>$md){
            foreach ($child as $c){
                if($c['pro_pid']==$md['pro_id']){
                    $model[$k]['child'][]=$c;
                }
            }


        }
        return $this->render('index', [
            'model' => $model,
            'pagination' => $pagination,
            'search'=>$search,
            'child'=>$child,
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
        $Promodel=new Project();
        $principal=new Principal();
        $tr=Yii::$app->db->beginTransaction();
        try{
                foreach ($tableData as $k=>$v)
                {


                       $_model=clone $Promodel;
                       $_principal=clone $principal;
                       $_model->scenario='create';
                       $_model->pro_name=trim($v['0']);
                       $_model->pro_pid=$pid;
                       $_model->pro_keywords=trim($v['1']);
                       $_model->pro_kind_id=trim($v['2']);
                       $_model->pro_sample_count=intval($v['3']);
                       $_model->pro_description=trim($v['8']);
                       $_model->pro_retrieve='PDS'.time().'D'.$k;
                       $_model->pro_add_time=date('Y-m-d H:i:s');
                       $_model->pro_user=Yii::$app->user->id;
                       $_principal->name=trim($v['4']);
                       $_principal->department=trim($v['5']);
                       $_principal->email=trim($v['6']);
                       $_principal->telphone=trim($v['7']);
                       if($_model->save()){
                           CommonHelper::addlog(1,$_model->pro_id,$_model->pro_name,'project');
                           $_principal->pro_id=$_model->attributes['pro_id'];
                           if(!$_principal->save()){
                               $tr->rollBack();
                               return $this->showFlash($_principal->getErrors());
                           }
                       }else{
                           $tr->rollBack();
                           return $this->showFlash('导入失败');
                       }
                   }

            $tr->commit();
                if($pid>0){
                    return $this->showFlash('添加成功','success',['project/view','id'=>$pid]);

                }else{
                    return $this->showFlash('导入成功','success',['project/index']);

                }
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

        $Principal=Principal::find()->andFilterWhere(['pro_id'=>$id,'status'=>0])->all();
        $chid=Project::find()->andFilterWhere(['pro_pid'=>$id,'isdel'=>0])->all();
        $group=Group::find()->andFilterWhere(['pro_id'=>$id,'isdel'=>0])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'child'=>$chid,
            'Principal'=>$Principal,
            'group'=>$group,
            'file'=>new UploadFile()
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Project();
        $principal=new Principal();
        $model->pro_pid=Yii::$app->request->get('pro_pid');
        $model->scenario='create';
        $post = Yii::$app->request->post();
        if ($post) {
            $tr=Yii::$app->db->beginTransaction();
            try{

                $model->setAttributes($_POST['Project'],false);
                $model->pro_add_time=date('Y-m-d H:i:s');
                $model->pro_retrieve='PDS'.time().'A'.rand(0,9);
                $model->pro_user=Yii::$app->user->id;
                $principal->attributes=$_POST['Principal'];
                if ($model->load($post)&&$model->save() )
                {


                    $principal->pro_id= $model->attributes['pro_id'];

                    if( $principal->save())
                    {
                        CommonHelper::addlog(1,$model->pro_id,$model->pro_name,'project');
                         $tr->commit();
                         if($model->pro_pid>0)
                         {

                             return $this->showFlash('添加成功','success',['project/view','id'=>$model->pro_pid]);

                         }else{
                             return $this->showFlash('添加成功','success',['project/index']);

                         }
                    }else{
                        $tr->rollBack();
                        return $this->showFlash('添加失败');
                    }
                }
            }catch (excepetion $e)
            {
                $tr->rollBack();
                return $this->showFlash('添加失败');
            }


        }
        return $this->render('create', [
            'model' => $model,
            'principal'=>$principal
        ]);
    }
    public  function actionExport($id)
    {
        ini_set("memory_limit", "2048M");
        set_time_limit(0);

        //获取用户ID

        //去用户表获取用户信息

        $data=Project::find()->andFilterWhere(['pro_id'=>$id])->all();
        //获取传过来的信息（时间，公司ID之类的，根据需要查询资料生成表格）
        $objectPHPExcel = new \PHPExcel();

        //设置表格头的输出
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('A1', '项目名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('B1', '检索号');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('C1', '项目关键字');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('D1', '实验项目描述');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('E1', '实验项目种属');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('F1', '实验样本总数 ');

        //跳转到recharge这个model文件的statistics方法去处理数据

        //指定开始输出数据的行数
        $n = 2;
        foreach ($data as $v){
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['pro_name']);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,$v['pro_retrieve']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['pro_keywords']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['pro_description']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['pro_kind_id']);
            $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n) ,$v['pro_sample_count']);
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
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $principal=Principal::findOne(['pro_id'=>$id]);
        $model->scenario='create';
        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try{
                $model->setAttributes($_POST['Project'],false);
                $model->pro_change_user=Yii::$app->user->id;
                $principal->attributes=$_POST['Principal'];
                if ($model->load($post)&&$model->save() )
                {


                    $principal->pro_id= $model->attributes['pro_id'];

                    if( $principal->save())
                    {
                        CommonHelper::addlog(3,$model->pro_id,$model->pro_name,'project');
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '修改成功');
                        return  $this->redirect(['project/index']);
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
                'principal'=>$principal
            ]);
        }
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $model->scenario='update';
        $model->isdel=1;
        $model->pro_del_time=date('Y-m-d H:i:s');
        $model->pro_del_user=Yii::$app->user->id;
        if($model->save())
        {
            CommonHelper::addlog(4,$model->pro_id,$model->pro_name,'project');

            return $this->showFlash('删除成功','success',['index']);
        }
        return $this->showFlash('删除失败', 'danger',Yii::$app->getUser()->getReturnUrl());
    }
    public function actionDel($id)
    {
        $model=$this->findModel($id);
        $model->scenario='update';
        $model->isdel=1;
        if($model->save())
        {
            CommonHelper::addlog(4,$model->pro_id,$model->pro_name,'project');
            return $this->showFlash('删除成功','success',['project/view','id'=>$model->pro_pid]);
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
        if (($model = Project::findOne($id)) !== null) {
            return $model;

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}