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

}
