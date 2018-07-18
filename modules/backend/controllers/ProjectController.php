<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use app\models\Group;
use app\models\Particular;
use app\models\Reagent;
use app\models\Routine;
use app\models\Sample;
use app\models\Sdyeing;
use app\models\Stace;
use app\modules\backend\models\AdminUser;
use app\models\Kit;
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
        if($data[0]->pro_pid==0)
        {
           $child=Project::find()->andFilterWhere(['pro_pid'=>$id,'isdel'=>0])->all();
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

        $objectPHPExcel->getActiveSheet()->setCellValue('A1','项目信息');
        $objectPHPExcel->setActiveSheetIndex()->getStyle('A1')->getFont()->setName('宋体') //字体
        ->setSize(15) //字体大小
        ->setBold(true); //字体加粗
        $objectPHPExcel->setActiveSheetIndex()->getStyle('A1')->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objectPHPExcel->getActiveSheet()->mergeCells('A1:F1');

        $objectPHPExcel->setActiveSheetIndex()->setCellValue('A2', '项目名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('B2', '检索号');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('C2', '项目关键字');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('D2', '实验项目描述');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('E2', '实验项目种属');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('F2', '实验样本总数 ');

        //跳转到recharge这个model文件的statistics方法去处理数据

        //指定开始输出数据的行数
        $n =3;
        foreach ($data as $v)
        {
            $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('C'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('D'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->setActiveSheetIndex()->getStyle('F'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['pro_name']);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,$v['pro_retrieve']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['pro_keywords']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['pro_description']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['pro_kind_id']);
            $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n) ,$v['pro_sample_count']);
            $n = $n +1;
        }
        if(count($child))
        {
            $n=$n +3;
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n),'包含的子项目');
            $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getFont()->setName('宋体') //字体
            ->setSize(15) //字体大小
            ->setBold(true); //字体加粗
            $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objectPHPExcel->getActiveSheet()->mergeCells('A'.($n).':'.'F'.($n));

            $n=$n+1;
            $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getFont()->setName('宋体') //字体
            ->setSize(10) //字体大小
            ->setBold(true); //字体加粗
            $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getFont()->setName('宋体') //字体
            ->setSize(10) //字体大小
            ->setBold(true); //字体加粗
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
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('A'.($n), '子项目名称');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('B'.($n), '子检索号');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('C'.($n), '子项目关键字');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('D'.($n), '子实验项目描述');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('E'.($n), '子实验项目种属');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('F'.($n), '子实验样本总数 ');
            $n = $n +1;
            foreach ($child as $v)
            {
                $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('C'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('D'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('F'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['pro_name']);
                $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,$v['pro_retrieve']);
                $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['pro_keywords']);
                $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['pro_description']);
                $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['pro_kind_id']);
                $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n) ,$v['pro_sample_count']);
                $n = $n +1;

                $gid[]=$v['pro_id'];
            }
         unset($child);
        }
        if(count($gid)>0)
        {
            $group=Group::find()->where(['in','pro_id',$gid])->andFilterWhere(['isdel'=>'0'])->all();
        }

        if(count($group)>0)
        {
            $n=$n +3;
            //合并单元格
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n),'包含的实验分组');
            $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getFont()->setName('宋体') //字体
            ->setSize(15) //字体大小
            ->setBold(true); //字体加粗
            $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objectPHPExcel->getActiveSheet()->mergeCells('A'.($n).':'.'F'.($n));

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
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('A'.($n), '分组名称');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('B'.($n), '所属项目');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('C'.($n), '分组检索号');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('D'.($n), '样品处理方式');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('E'.($n), '分组描述');
            $objectPHPExcel->setActiveSheetIndex()->setCellValue('F'.($n), '样本图片');
            $n = $n +1;
            foreach ($group as $v)
            {
                $objectPHPExcel->getActiveSheet()->getRowDimension($n)->setRowHeight(80);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('C'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('D'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['group_name']);
                $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,Project::getProName($v['pro_id']));
                $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['group_retrieve']);
                $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['group_experiment_type']);
                $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['group_description']);
                if(!empty($v['url'])) {
                    $image ='./'.$v['url'];
                    if (@fopen($image, 'r')) {
                        //这是一个坑,刚开始我把实例化图片类放在了循环外面,但是失败了,也就是每个图片都要实例化一次
                        $objDrawing = new \PHPExcel_Worksheet_Drawing();
                        $objDrawing->setPath($image);
                        // 设置图片的宽度
                        $objDrawing->setHeight(100);
                        $objDrawing->setWidth(100);
                        $objDrawing->setCoordinates('F' . $n);
                        $objDrawing->setWorksheet($objectPHPExcel->getActiveSheet());
                    }
                }

                $n = $n +1;
                $sid[]=$v['id'];
            }
            unset($group);
        }

//        if(count($sid)>0)
//        {
//            $sample=Sample::find()->where(['in','gid',$sid])->andFilterWhere(['isdel'=>'0'])->all();
//
//        }
//        if(count($sample)>0)
//        {
//            $sm=[];
//            $m=0;
//            foreach ($sample as $v1)
//            {
//                $stace=Stace::find()->andFilterWhere(['sid'=>$v1->id,'isdel'=>'0'])->all();
//                if(count($stace)>0)
//                {
//
//                    foreach ($stace as $v2)
//                    {
//                        $sm[$m]=[
//                            'A'=>$v1->name,
//                            'B'=>$v1->retrieve,
//                            'C'=>$v1->descript,
//                            'D'=>$v2->name,
//                            'E'=>$v2->retrieve,
//                            'F'=>$v2->description,
//                            'G'=>$v2->postion,
//                            'H'=>$v2->handle,
//                            'I'=>$v2->place,
//                            'J'=>$v1->gid,
//                            'K'=>$v2->id
//                        ];
//                        $m=$m+1;
//                    }
//                }else{
//                    $sm[$m]=[
//                        'A'=>$v1->name,
//                        'B'=>$v1->retrieve,
//                        'C'=>$v1->descript,
//                        'D'=>'',
//                        'E'=>'',
//                        'F'=>'',
//                        'G'=>'',
//                        'H'=>'',
//                        'I'=>'',
//                        'J'=>$v1->gid,
//                        'K'=>'0'
//                    ];
//                }
//
//                $m=$m+1;
//            }
//
//
//          if(count($sm)>0)
//          {
//              $n=$n +3;
//              //合并单元格
//              $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n),'包含的样本信息');
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(15) //字体大小
//              ->setBold(true); //字体加粗
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//              $objectPHPExcel->getActiveSheet()->mergeCells('A'.($n).':'.'J'.($n));
//              $n=$n+1;
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(10) //字体大小
//              ->setBold(true); //字体加粗
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(10) //字体大小
//              ->setBold(true); //字体加
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('C'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(10) //字体大小
//              ->setBold(true); //字体加粗
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('D'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(10) //字体大小
//              ->setBold(true); //字体加粗
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(10) //字体大小
//              ->setBold(true); //字体加粗
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('F'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(10) //字体大小
//              ->setBold(true); //字体加粗
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('G'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(10) //字体大小
//              ->setBold(true); //字体加粗
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('H'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(10) //字体大小
//              ->setBold(true); //字体加粗
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('I'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(10) //字体大小
//              ->setBold(true); //字体加粗
//              $objectPHPExcel->setActiveSheetIndex()->getStyle('J'.($n))->getFont()->setName('宋体') //字体
//              ->setSize(10) //字体大小
//              ->setBold(true); //字体加粗
//              $objectPHPExcel->setActiveSheetIndex()->setCellValue('A'.($n), '样品名称');
//              $objectPHPExcel->setActiveSheetIndex()->setCellValue('B'.($n), '所属分组');
//              $objectPHPExcel->setActiveSheetIndex()->setCellValue('C'.($n), '样品检索号');
//              $objectPHPExcel->setActiveSheetIndex()->setCellValue('D'.($n), '样品描述');
//              $objectPHPExcel->setActiveSheetIndex()->setCellValue('E'.($n), '样本名称');
//              $objectPHPExcel->setActiveSheetIndex()->setCellValue('F'.($n), '样本检索号');
//              $objectPHPExcel->setActiveSheetIndex()->setCellValue('G'.($n), '组织/细胞位置');
//              $objectPHPExcel->setActiveSheetIndex()->setCellValue('H'.($n), '处理方式');
//              $objectPHPExcel->setActiveSheetIndex()->setCellValue('I'.($n), '存放位置');
//              $objectPHPExcel->setActiveSheetIndex()->setCellValue('J'.($n), '样本描述');
//              $n = $n +1;
//              foreach ($sm as $v)
//              {
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('C'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('D'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('F'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('G'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('H'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('I'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('J'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('G'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('H'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('I'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                  $objectPHPExcel->setActiveSheetIndex()->getStyle('J'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                  $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['A']);
//                  $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,Group::getParName($v['J']));
//                  $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['B']);
//                  $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['C']);
//                  $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['D']);
//                  $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n) ,$v['E']);
//                  $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n) ,$v['G']);
//                  $objectPHPExcel->getActiveSheet()->setCellValue('H'.($n) ,$v['H']);
//                  $objectPHPExcel->getActiveSheet()->setCellValue('I'.($n) ,$v['I']);
//                  $objectPHPExcel->getActiveSheet()->setCellValue('J'.($n) ,$v['F']);
//                  $n = $n +1;
//
//                  $syid[]=$v['K'];
//
//              }
//          }
//
//        }
//        $sdyeing=Sdyeing::find()->where(['in','yid',$syid])->andFilterWhere(['isdel'=>'0'])->all();
//        $sdy=[];
//        foreach ($sdyeing as $k=>$v){
//            $sdy[$k]['A']=$v->section_name;
//            $sdy[$k]['B']=Stace::getParName($v->yid);
//            $sdy[$k]['C']=$v->retrieve;
//            $sdy[$k]['D']=$this->getShiji($v->ntype,$v->nid);
//            if($v->ntype==1){
//                $sdy[$k]['E']=Reagent::getNames($v->rgid);
//                $sdy[$k]['F']='';
//            }elseif ($v->ntype==2){
//                $sdy[$k]['E']=Reagent::getNames($v->rgid);
//                $sdy[$k]['F']=Kit::getNames($v->kit);
//            }elseif ($v->ntype==3){
//                $sdy[$k]['E']='';
//                $sdy[$k]['F']='';
//                $sdy[$k]['G']=Kit::getNames($v->kit);
//            }
//            elseif ($v->ntype==4){
//                $sdy[$k]['E']='';
//                $sdy[$k]['F']='';
//                $sdy[$k]['G']='';
//                $sdy[$k]['H']=Kit::getNames($v->kit);
//            }
//            $sdy[$k]['I']=$v->section_type;
//            $sdy[$k]['J']=$v->section_thickness;
//            $sdy[$k]['K']=$v->section_preprocessing;
//            $sdy[$k]['L']=$v->place;
//            $sdy[$k]['M']=$v->img;
//            $sdy[$k]['N']=$v->testflow;
//            $sdy[$k]['O']=$v->attention;
//        }
//        if(count($sdy)>0)
//        {
//            $n=$n +3;
//            //合并单元格
//            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n),'实验结果系列');
//            $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getFont()->setName('宋体') //字体
//            ->setSize(15) //字体大小
//            ->setBold(true); //字体加粗
//            $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//
//            $objectPHPExcel->getActiveSheet()->mergeCells('A'.($n).':'.'0'.($n));
//
//            $n=$n+1;
//            $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getFont()->setName('宋体') //字体
//            ->setSize(10) //字体大小
//            ->setBold(true); //字体加粗
//            $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getFont()->setName('宋体') //字体
//            ->setSize(10) //字体大小
//            ->setBold(true); //字体加
//            $objectPHPExcel->setActiveSheetIndex()->getStyle('C'.($n))->getFont()->setName('宋体') //字体
//            ->setSize(10) //字体大小
//            ->setBold(true); //字体加粗
//            $objectPHPExcel->setActiveSheetIndex()->getStyle('D'.($n))->getFont()->setName('宋体') //字体
//            ->setSize(10) //字体大小
//            ->setBold(true); //字体加粗
//            $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getFont()->setName('宋体') //字体
//            ->setSize(10) //字体大小
//            ->setBold(true); //字体加粗
//            $objectPHPExcel->setActiveSheetIndex()->getStyle('F'.($n))->getFont()->setName('宋体') //字体
//            ->setSize(10) //字体大小
//            ->setBold(true); //字体加粗
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('A'.($n), '切片名称');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('B'.($n), '所属样本');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('C'.($n), '检索号');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('D'.($n), '检测指标');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('E'.($n), '使用自配试剂');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('F'.($n), '使用商品试剂');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('G'.($n), '使用抗体');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('H'.($n), '使用核算试剂盒');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('I'.($n), '切片类型');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('J'.($n), '切片厚度');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('K'.($n), '切片预处理');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('L'.($n), '存放位置');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('M'.($n), '切片数字图像文件');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('N'.($n), '实验流程');
//            $objectPHPExcel->setActiveSheetIndex()->setCellValue('O'.($n), '注意事项');
//            $n = $n +1;
//            foreach ($sdy as $v)
//            {
//                $objectPHPExcel->getActiveSheet()->getRowDimension($n)->setRowHeight(80);
//                $objectPHPExcel->setActiveSheetIndex()->getStyle('A'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                $objectPHPExcel->setActiveSheetIndex()->getStyle('B'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                $objectPHPExcel->setActiveSheetIndex()->getStyle('C'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                $objectPHPExcel->setActiveSheetIndex()->getStyle('D'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
//                $objectPHPExcel->setActiveSheetIndex()->getStyle('E'.($n))->getAlignment()->setWrapText(true)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//
//
//                $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['A']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,$v['B']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['B']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['D']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['E']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n) ,$v['F']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n) ,$v['G']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('H'.($n) ,$v['H']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('I'.($n) ,$v['I']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('J'.($n) ,$v['J']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('K'.($n) ,$v['K']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('L'.($n) ,$v['L']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('M'.($n) ,$v['M']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('N'.($n) ,$v['N']);
//                $objectPHPExcel->getActiveSheet()->setCellValue('O'.($n) ,$v['O']);
//
//                if(!empty($v['img'])) {
//                    $image ='./'.$v['img'];
//                    if (@fopen($image, 'r')) {
//                        //这是一个坑,刚开始我把实例化图片类放在了循环外面,但是失败了,也就是每个图片都要实例化一次
//                        $objDrawing = new \PHPExcel_Worksheet_Drawing();
//                        $objDrawing->setPath($image);
//                        // 设置图片的宽度
//                        $objDrawing->setHeight(100);
//                        $objDrawing->setWidth(100);
//                        $objDrawing->setCoordinates('O' . $n);
//                        $objDrawing->setWorksheet($objectPHPExcel->getActiveSheet());
//                    }
//                }
//
//                $n = $n +1;
//                $sid[]=$v['id'];
//            }
//        }


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


//public function getShiji($type,$nid){
//        switch ($type){
//            case 1:
//                $data=Routine::findOne($nid);
//                if($data){
//                    return $data->name;
//                }else{
//                    return '';
//                }
//                break;
//            case 2:
//                $data=Particular::findOne($nid);
//                if($data){
//                    return $data->name;
//                }else{
//                    return '';
//                }
//                break;
//            case 3:
//                $data=Kit::findOne($nid);
//                if($data){
//                    return $data->name;
//                }else{
//                    return '';
//                }
//                break;
//            case 4:
//                $data=Kit::findOne($nid);
//                if($data){
//                    return $data->name;
//                }else{
//                    return '';
//                }
//
//                break;
//        }
//}

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