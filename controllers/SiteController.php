<?php

namespace app\controllers;

use app\models\Content;
use app\models\Project;
use app\models\Principal;
use app\models\Group;
use app\models\Sample;
use app\models\Sdyeing;
use app\models\Stace;
use Yii;
use app\components\AppController as Controller;
use app\models\Feedback;
use app\models\Config;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\Page;
use app\models\Routine;
use app\models\Reagent;
use app\models\Kit;
use app\models\Pna;

use app\models\Particular;
use yii\helpers\Html;
use yii\data\Pagination;
use PHPExcel;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;



class SiteController extends Controller
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
            ->limit($pagination->limit)->asArray()
            ->all();
        $child=Project::find()->andFilterWhere(['>', 'pro_pid', 0])->andFilterWhere(['isdel'=> 0])->asArray()->all();
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
            'at'=>1
        ]);
    }
  public function actionShow($id){
          $model=Project::findOne($id);
          $child=Project::find()->andFilterWhere(['pro_pid'=>$id,'isdel'=>0])->all();
          $Principal=Principal::find()->andFilterWhere(['pro_id'=>$id,'status'=>0])->all();
          $group=Group::find()->andFilterWhere(['pro_id'=>$id,'isdel'=>0])->all();



      return $this->render('show', [
              'model' => $model,
              'child'=>$child,
              'Principal'=>$Principal,
              'group'=>$group,
              'at'=>1
          ]);
  }
    public function actionGroup($id){
        $model=Group::findOne($id);
        $child=Sample::find()->andFilterWhere(['gid'=>$id,'isdel'=>0])->all();
        return $this->render('group', [
            'model' => $model,
            'child'=>$child,
            'at'=>1
        ]);
    }
    public function actionSample($id){
        $model=Sample::findOne($id);
        $child=Stace::find()->andFilterWhere(['sid'=>$id,'isdel'=>0])->all();
        return $this->render('sample', [
            'model' => $model,
            'child'=>$child,
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
    public function actionSdyeing($id){
        $model=Sdyeing::findOne($id);
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
        return $this->render('sdyeing', [
            'model' => $model,
            'at'=>1,
            'norm'=>$norm,
            'kit'=>$kit,
            'Reagent'=>$Reagent
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

    /**
     * Displays about page.
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAbout()
    {
        $config = Config::getByName('about_us_page_id');
        if(empty($config)){
            throw new NotFoundHttpException('页面不存在');
        }
        return $this->actionPage($config['value']);
    }
    /**
     * Displays products page
     *
     * @return string
     */
    public function actionSearch()
    {
        $keyword = Html::encode(strip_tags(Yii::$app->request->get('keyword')));
        Content::$currentType = null;
        $query = Content::find()
            ->andFilterWhere(['or',['like', 'title', $keyword],['like', 'description', $keyword]])
            ->andFilterWhere(['status'=>Content::STATUS_ENABLE]);
//        echo $query->createCommand()->getRawSql();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['id'=>SORT_DESC]],
            'pagination' => ['pageSize'=>Yii::$app->params['pageSize']]
        ]);
        $this->view->params['keyword'] = $keyword;
        return $this->render('search', [
            'searchModel' => new Content(),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * config 页面
     * @param int $id
     * @throws NotFoundHttpException
     * @return string
     */
    public function actionPage($id)
    {
        $page = Page::findOne($id);
        if(empty($page)){
            throw new NotFoundHttpException('页面不存在');
        }
        if(!empty($page->keywords)){
            $this->view->registerMetaTag(['name'=>'keywords', 'content'=>$page->keywords],'keywords');
        }
        if(!empty($page->description)){
            $this->view->registerMetaTag(['name'=>'description', 'content'=>$page->description], 'description');
        }
        return $this->render($page->template,[
            'page'=>$page
        ]);
    }

    public function actionSearchChildren()
    {
        $this->layout = false;
        return $this->render('search-children');
    }
    public  function actionExport($id)
    {
         $data=Project::find($id);
    }
}
