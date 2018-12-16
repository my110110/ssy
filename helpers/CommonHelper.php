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
use app\models\Group;
use app\models\Project;
use app\models\Sample;
use app\models\Stace;
use app\models\Zipdel;
use Yii;
use app\modules\backend\models\Operatelog;

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
        $model=new Operatelog();
        $model->operate=$operate;
        $model->object=$object;
        $model->user=Yii::$app->user->id;
        $model->objectname=$objectname;
        $model->operate_kind=$operate_kind;
        $model->save();

    }
    /*
     * 生成项目EXCEL文件
     */
    static public function export_project($id,$dir_name)
    {

        $gid = [];
        $files = [];
        //获取用户ID

        //去用户表获取用户信息

        $data = Project::find()->andFilterWhere(['pro_id'=>$id])->all();

        $objectPHPExcel = new \PHPExcel();
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
            $gid[] = $v['pro_id'];
        }

        $name=$data[0]->pro_name;
        $phpWriter = \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $phpWriter->save('uploads/excel/'.$dir_name."/$name.xls");//生成表格( 活动 )
        if($data[0]->pro_pid == 0)
        {
            $gid = [];
            //获取子项目
            unset($gid);
            $re = self::export_child_project($data[0]->pro_id,$dir_name,$files);

        }else{
            $re = self::export_group($gid,$dir_name,$files);
        }
        $files = $re['files'];
        $files[]= 'uploads/excel/'.$dir_name."/$name.xls";
        $res['dir_name'] = $dir_name;
        $res['files'] = $files;
        return $res;
    }

    /**
     * @param $id 父级项目ID
     * @param $dir_name  生成的EXCEL 存放的文件夹名称
     * @param array $files 文件夹内所有文件路径
     * @return mixed
     */

    static public function export_child_project($id,$dir_name,$files = []){
        ini_set("memory_limit", "2048M");
        set_time_limit(0);
        $gid = [];
        $data = Project::find()->andFilterWhere(['pro_pid'=>$id,'isdel'=>0])->all();
        if(count($data) < 1){
            return true;
        }
        $objectPHPExcel = new \PHPExcel();
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

        $objectPHPExcel->setActiveSheetIndex()->setCellValue('A2', '子项目名称');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('B2', '子检索号');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('C2', '子项目关键字');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('D2', '子实验项目描述');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('E2', '子实验项目种属');
        $objectPHPExcel->setActiveSheetIndex()->setCellValue('F2', '子实验样本总数 ');

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
            $gid[]=$v['pro_id'];
        }

        $name='子项目列表';
        $phpWriter = \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $phpWriter->save('uploads/excel/'.$dir_name."/$name.xls");//生成表格( 活动 )

        $re = self::export_group($gid,$dir_name,$files);
        $files = $re['files'];
        $files[] = 'uploads/excel/'.$dir_name."/$name.xls";
        $res['dir_name'] = $dir_name;
        $res['files'] = $files;
        return $res;
    }

    /**
     * @param $gid array 分组ID
     * @param $dir_name  生成excel 存放的文件夹名称
     * @param $files array   文件夹内所有文件路径
     * @return mixed
     */
    static public function export_group($gid,$dir_name,$files){
        $group = Group::find()->where(['in','pro_id',$gid])->andFilterWhere(['isdel'=>'0'])->all();
        if(count($group)<1){
            return true;
        }
        $n = 1;
        //合并单元格
        $objectPHPExcel = new \PHPExcel();
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


        $name='分组列表';
        $phpWriter = \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $phpWriter->save('uploads/excel/'.$dir_name."/$name.xls");//生成表格( 活动 )
        $re = self::export_sample($sid,$dir_name,$files);
        $files = $re['files'];
        $files[] = 'uploads/excel/'.$dir_name."/$name.xls";
        $res['dir_name'] = $dir_name;
        $res['files'] = $files;
        return $res;
    }

    static public function export_sample($sid,$dir_name,$files){

        $objectPHPExcel = new \PHPExcel();
        $sample = Sample::find()->where(['in','gid',$sid])->andFilterWhere(['isdel'=>'0'])->all();
        if(count($sample)<1){
            return true;
        }
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


        $name='样本列表';
        $phpWriter = \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $phpWriter->save('uploads/excel/'.$dir_name."/$name.xls");//生成表格( 活动 )
       // $re = self::export_sample($sid,$dir_name,$files);
       // $files = $re['files'];
        $files[] = 'uploads/excel/'.$dir_name."/$name.xls";
        $res['dir_name'] = $dir_name;
        $res['files'] = $files;
        return $res;
    }
    /**
     * 下载
     * @param $filename
     * @param $files
     * @return bool
     */

    static public function down($filename,$files){
        $dir     = 'uploads/excel/'.$filename;
        $zipName = 'uploads/excel/'.$filename.'.zip';
        $zip = new \ZipArchive;//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释
        if ($zip->open($zipName, \ZIPARCHIVE::OVERWRITE | \ZIPARCHIVE::CREATE)!==TRUE) {
            exit('无法打开文件，或者文件创建失败');
        }
        foreach($files as $val){
            if(file_exists($val)){
                $zip->addFile($val, basename($val));//第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下
            }
        }

        $zip->close();//关闭
        if(!file_exists($zipName)){
            exit("无法找到文件"); //即使创建，仍有可能失败
        }
        //如果不要下载，下面这段删掉即可，如需返回压缩包下载链接，只需 return $zipName;
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename='.basename($zipName)); //文件名
       // header("Content-Type: application/zip"); //zip格式的
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
        header("Content-Type: application/force-download");
        $filesize = filesize($zipName)+100;
        header('Content-Length: '. $filesize); //告诉浏览器，文件大小

        @readfile($zipName);

         $zipdir = new Zipdel();
         $zipdir->dirname = $dir;
         $zipdir->zipname = $zipName;
         $zipdir->deltime = date('Y-m-d H:i:s',time()+5*60*60);
         $zipdir->save(false);
         return true;
    }
    static public function deldir($path)
    {
        //如果是目录则继续
        if(is_dir($path)){
            //扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($path);
            foreach($p as $val){
                //排除目录中的.和..
                if($val !="." && $val !=".."){
                    //如果是目录则递归子目录，继续操作
                    if(is_dir($path.'/'.$val)){
                        //子目录中操作删除文件夹和文件
                        deldir($path.'/'.$val.'/');
                        //目录清空后删除空文件夹
                        @rmdir($path.'/'.$val.'/');
                    }else{
                        //如果是文件直接删除
                        unlink($path.'/'.$val);
                    }
                }
            }
            rmdir($path);
        }
    }

}