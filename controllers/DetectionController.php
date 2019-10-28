<?php

namespace app\controllers;

use app\models\Content;
use app\models\Project;
use app\models\Principal;
use app\models\Group;
use app\models\Sample;
use app\models\Sdyeing;
use app\models\Stace;
use app\models\Testmethod;
use Yii;
use app\components\AppController as Controller;
use app\models\Feedback;
use app\models\Config;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\Page;
use app\models\Routine;
use app\models\Reagent;
use app\models\Company;
use app\models\Kit;
use app\models\Pna;

use app\models\Particular;
use yii\helpers\Html;
use yii\data\Pagination;



class DetectionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //分页读取类别数据
        $routine=Routine::find()->andFilterWhere(['isdel'=>0])->all();
        $Particular=Particular::find()->andFilterWhere(['isdel'=>0])->all();
        $pna=Pna::find()->andFilterWhere(['isdel'=>0])->all();
        return $this->render('index', [
            'pna' => $pna,
            'routine'=>$routine,
            'Particular'=>$Particular,
            'at'=>2
        ]);
    }
  public function actionRoutine($id){
          $model=Routine::findOne($id);
          $child=Reagent::find()->andFilterWhere(['sid'=>$id,'isdel'=>0,'type'=>'routine'])->all();



      return $this->render('routine', [
              'model' => $model,
              'child'=>$child,

              'at'=>2
          ]);
  }
    public function actionPna($id){
        $model=Pna::findOne($id);
        $child=Kit::find()->andFilterWhere(['rid'=>$id,'isdel'=>0])->all();

        return $this->render('pna', [
            'model' => $model,
            'child'=>$child,

            'at'=>2
        ]);
    }
    public function actionParticular($id){
        $model=Particular::findOne($id);
        $child=Testmethod::find()->andFilterWhere(['pid'=>$id,'isdel'=>0])->all();
        return $this->render('particular', [
            'model' => $model,
            'child'=>$child,

            'at'=>2
        ]);
    }


    public function actionTestmethod($id){
        $model=Testmethod::findOne($id);
        $child=Reagent::find()->andFilterWhere(['tid'=>$id,'isdel'=>0,'type'=>'testmethod'])->all();
        $kit=Kit::find()->andFilterWhere(['tid'=>$id,'isdel'=>0,'type'=>'testmethod'])->all();
        return $this->render('testmethod', [
            'model' => $model,
            'child'=>$child,
            'kit'=>$kit,
            'at'=>1
        ]);
    }
    public function actionKit($id){
        $model=Kit::findOne($id);
        return $this->render('kit', [
            'model' => $model,
            'at'=>1
        ]);
    }
    public function actionStace($id){
        $model=Stace::findOne($id);
        $child=Sdyeing::find()->andFilterWhere(['yid'=>$id,'isdel'=>0])->all();
        return $this->render('stace', [
            'model' => $model,
            'child'=>$child,
            'at'=>1
        ]);
    }
    public function actionReagent($id){
        $model=Reagent::findOne($id);
        $child=Company::find()->andFilterWhere(['rid'=>$id,'isdel'=>'0'])->all();

        return $this->render('reagent', [
            'model' => $model,
            'at'=>2,
            'child'=>$child,
        ]);
    }
    /**
     * 修改语言
     * @param string $language
     * @return string
     */
    public function actionLanguage($language)
    {
        Yii::$app->session->set('language', $language);
        $referrer = Yii::$app->request->getReferrer();
        return $this->redirect($referrer?$referrer:Yii::$app->getHomeUrl());
    }
    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new Feedback();
        /** @var Config $config */
        $config = Config::getByName('contact_us_page_id');
        if($config) {
            $page = Page::find()->where(['id' => $config->value])->one();
        } else {
            $page = null;
        }
        if(!empty($page->keywords)){
            $this->view->registerMetaTag(['name'=>'keywords', 'content'=>$page->keywords],'keywords');
        }
        if(!empty($page->description)){
            $this->view->registerMetaTag(['name'=>'description', 'content'=>$page->description], 'description');
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(isset(Yii::$app->params['adminEmail'])) {
                $model->sendEmail(Yii::$app->params['adminEmail']);
            }
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
            'page' =>$page
        ]);
    }

    public  function actionExportroutine($id)
    {
        ini_set("memory_limit", "2048M");
        set_time_limit(0);

        //获取用户ID

        //去用户表获取用户信息

        $data=Routine::find()->andFilterWhere(['id'=>$id])->all();
        //获取传过来的信息（时间，公司ID之类的，根据需要查询资料生成表格）
        $objectPHPExcel = new \PHPExcel();

        //设置表格头的输出
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('A1', '指标名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('B1', '检索号');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('C1', '常规染色检测原理');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('D1', '流程');

        //跳转到recharge这个model文件的statistics方法去处理数据

        //指定开始输出数据的行数
        $n = 2;
        foreach ($data as $v){
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['name']);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,$v['retrieve']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['axiom']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['process']);
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
    public  function actionExportparticular($id)
    {
        ini_set("memory_limit", "2048M");
        set_time_limit(0);

        //获取用户ID

        //去用户表获取用户信息

        $data=Particular::findOne($id);
        $chid=Testmethod::find()->andFilterWhere(['pid'=>$id])->asArray()->all();

        foreach ($chid as $k=>$v){
            $chid[$k]['Rname']=$data->name;
            $chid[$k]['Rretrieve']=$data->retrieve;
        }

        //获取传过来的信息（时间，公司ID之类的，根据需要查询资料生成表格）
        $objectPHPExcel = new \PHPExcel();

        //设置表格头的输出
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('A1', '指标名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('B1', '指标检索号');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('C1', '检测方法名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('D1', '检测方法检索号');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('E1', '阳性对照');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('F1', '阴性对照');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('G1', '结果判断');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('H1', '注意事项');

        //指定开始输出数据的行数
        $n = 2;
        foreach ($chid as $v){
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['Rname']);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,$v['Rretrieve']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['name']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['retrieve']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['positive']);
            $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n) ,$v['negative']);
            $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n) ,$v['judge']);
            $objectPHPExcel->getActiveSheet()->setCellValue('H'.($n) ,$v['matters']);

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
        unset($chid);
    }

    public  function actionExportpna($id)
    {
        ini_set("memory_limit", "2048M");
        set_time_limit(0);

        //获取用户ID

        //去用户表获取用户信息

        $data=Pna::find()->andFilterWhere(['id'=>$id])->asArray()->all();



        //获取传过来的信息（时间，公司ID之类的，根据需要查询资料生成表格）
        $objectPHPExcel = new \PHPExcel();

        //设置表格头的输出
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('A1', '指标名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('B1', '指标检索号');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Official Symbol');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Official Full Name');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Gene ID');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('F1', '基因/核酸功能');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'NCBI Gene Database ');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'GeneGards网址');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('I1', '阳性结果判定标准');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('J1', '阳性对照组织/细胞');


        //指定开始输出数据的行数
        $n = 2;
        foreach ($data as $v){
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n) ,$v['name']);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n) ,$v['retrieve']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n) ,$v['OfficialSymbol']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n) ,$v['OfficialFullName']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n) ,$v['GeneID']);
            $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n) ,$v['function']);
            $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n) ,$v['NCBIgd']);
            $objectPHPExcel->getActiveSheet()->setCellValue('H'.($n) ,$v['GeneGards']);
            $objectPHPExcel->getActiveSheet()->setCellValue('I'.($n) ,$v['standard']);
            $objectPHPExcel->getActiveSheet()->setCellValue('J'.($n) ,$v['cells']);
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

}
