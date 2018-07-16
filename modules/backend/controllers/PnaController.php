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