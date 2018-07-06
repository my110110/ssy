<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2017/1/24
 * Time: 13:45
 * Email:liyongsheng@meicai.cn
 */

namespace app\helpers;
use app\models\Category;
use app\models\Content;
use Yii;
use app\modules\backend\models\OperateLog;

class CommonHelper
{
    /**
     * 递归翻译导航内容
     * @param array $nav
     * @param string $category
     * @return mixed
     */
    static public function navTranslation($nav, $category='app')
    {
        $nav['items'] = self::navItemsTranslation($nav['items'], $category);
        return $nav;
    }

    /**
     * 递归翻译导航内容
     * @param array $navItems
     * @param string $category
     * @return mixed
     */
    static public function navItemsTranslation($navItems, $category='app')
    {
        foreach($navItems as &$item){
            if(isset($item['items']) && is_array($item['items'])){
                $item['items']= self::navItemsTranslation($item['items']);
            }
            $item['label'] = Yii::t($category, $item['label']);
        }
        return $navItems;
    }

    /**
     * 分类信息转化为面包屑数组
     * @param Category $category
     * @param array $breadcrumbs
     */
    static public function categoryBreadcrumbs(Category $category, array &$breadcrumbs)
    {
        $type =  Content::type2String($category->type);
        $breadcrumbs[] = [
            'label'=>$category->getTypeText(),
            'url'=>['/'.$type.'/list']
        ];
        $parents = $category->fullParent;
        if(is_array($parents)) {
            foreach ($parents as &$item) {
                $breadcrumbs[] = [
                    'label' => $item['name'],
                    'url' => ['/' . $type . '/list', 'category-id' => $item['id']]
                ];
            }
        }
        if(isset($category['id'])) {
            $breadcrumbs[] = [
                'label' => $category['name'],
                'url' => ['/' . $type . '/list', 'category-id' => $category['id']]
            ];
        }
    }
    static public function addLog($operate,$object,$objectname,$operate_kind)
    {
        $model=new OperateLog();
        $model->operate=$operate;
        $model->object=$object;
        $model->user=Yii::$app->user->id;
        $model->objectname=$objectname;
        $model->operate_kind=$operate_kind;
        $model->save();

    }
}