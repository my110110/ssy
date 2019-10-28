<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/21
 * Time: 14:54
 */

namespace app\modules\backend\controllers;

use yii;
use app\models\Project;
use app\models\Sample;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Group;
use yii\data\Pagination;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_CSV;
use PHPExcel_Reader_Excel5;
use app\models\UploadFile;
use yii\web\UploadedFile;
use moonland\phpexcel\Excel;
use app\modules\backend\models\AdminUser;
use \PHPExcel_Worksheet_Drawing;
use app\helpers\CommonHelper;
class GroupController extends BackendController
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
    public function actionIndex()
    {
        //分页读取类别数据
        $search=New Group();
        $model =  Group::find();
        $search->scenario='search';

        if(isset(Yii::$app->request->queryParams['Group']))
        {

            $parms=Yii::$app->request->queryParams['Group'];
            if(isset($parms['group_retrieve']))
                $model->andFilterWhere(['group_retrieve' => $parms['group_retrieve'],]);
            if(isset($parms['group_name']))
                $model->andFilterWhere(['like', 'group_name', $parms['group_name']]);

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
        $Pmodel=new Group();
        $tr=Yii::$app->db->beginTransaction();
        try{
            foreach ($tableData as $k=>$v)
            {


                $_model=clone $Pmodel;
                $_model->group_name=trim($v['0']);
                $_model->pro_id=$pid;
                $_model->group_experiment_type=trim($v['1']);
                $_model->group_sample_count=intval($v['2']);
                $_model->group_description=trim($v['3']);
                $_model->group_retrieve='PSEG'.time().'D'.$k;
                $_model->group_add_time=date('Y-m-d H:i:s');
                $_model->group_add_user=Yii::$app->user->id;
                if($_model->save()){
                    CommonHelper::addlog(1,$_model->id,$_model->group_name,'group');

                }else{
                    $tr->rollBack();
                    return $this->showFlash('导入失败');
                }
            }

            $tr->commit();
            if($pid>0){
                return $this->showFlash('导入成功','success',['project/view','id'=>$pid]);

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
    public function actionView($id,$ret=0)
    {
        $sample=Sample::find()->andFilterWhere(['gid'=>$id,'isdel'=>0])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'sample'=>$sample,
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
        $model=Project::findOne(['pro_id'=>$id]);

        $group=new Group();
        $group->pro_id=$id;
        $post = Yii::$app->request->post();
        if ($post)
        {
            $tr=Yii::$app->db->beginTransaction();
            try{


                $group->attributes=$_POST['Group'];
                $group->pro_id=$model->pro_id;
                $group->group_add_time=date('Y-m-d H:i:s');
                $group->group_retrieve='PSEG'.time().'A0';
                $group->group_add_user=Yii::$app->user->id;
                if ($group->load($post)&&$group->save() )
                {
                        CommonHelper::addlog(1,$group->id,$group->group_name,'group');
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '保存成功');
                        return  $this->redirect(['project/view','id'=>$model->pro_id]);

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
                'group'=>$group,
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
        $group = $this->findModel($id);
        $model=Group::findOne(['pro_id'=>$group->pro_id]);
        $post = Yii::$app->request->post();
        if ($post)
        {

            $tr=Yii::$app->db->beginTransaction();
            try{
                $group->attributes=$_POST['Group'];
                $group->group_change_time=date('Y-m-d H:i:s');
                $group->group_change_user=Yii::$app->user->id;
                if ($group->load($post) )
                {
                    CommonHelper::addlog(3,$group->id,$group->group_name,'group');
                    if( $group->save())
                    {
                        $tr->commit();
                        Yii::$app->getSession()->setFlash('success', '修改成功');
                        if($ret==1){
                            return  $this->redirect(['group/index']);

                        }else{
                            return  $this->redirect(['project/view','id'=>$model->pro_id]);
                        }

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
                'group'=>$group
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
         $model=Group::findOne(['id'=>$id]);
         $model->isdel=1;
         $model->group_del_user=Yii::$app->user->id;
         $model->group_del_time=date('Y-m-d H:i:s');
        if($model->save()){
            CommonHelper::addlog(4,$model->id,$model->group_name,'group');
            return $this->showFlash('删除成功','success',['project/view','id'=>$model->pro_id]);
        }
        return $this->showFlash('删除失败', 'danger',Yii::$app->getUser()->getReturnUrl());
    }
    public function actionDelete($id)
    {
        $model=Group::findOne(['id'=>$id]);
        $model->isdel=1;
        $model->group_del_user=Yii::$app->user->id;
        $model->group_del_time=date('Y-m-d H:i:s');
        if($model->save()){
            CommonHelper::addlog(4,$model->id,$model->group_name,'group');
            return $this->showFlash('删除成功','success',['group/index']);
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
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}