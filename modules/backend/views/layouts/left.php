<?php
use yii\helpers\Json;
use mdm\admin\components\MenuHelper;
use yii\web\UrlManager;
/**
 * @var \yii\web\View $this
 */
?>
<aside class="main-sidebar">
    <section class="sidebar" style="height: auto;">
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" id="menu-keyword" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='button' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <li><a href="/backend/project/index.html"><i class="fa fa-bars"></i>
                <span>实验项目</span></a>
        </li>
        <li><a href="/backend/detection/index.html"><i class="fa fa-bars"></i>  <span>检测指标</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
            <ul class="treeview-menu">
                <li><a href="/backend/routine/index.html"><i class="	glyphicon glyphicon-th-large"></i>  <span>常规染色</span></a></li>
                <li><a href="/backend/pna/index.html?type=2"><i class="glyphicon glyphicon-th-large"></i>  <span>核酸指标</span></a></li>
                <li><a href="/backend/particular/index.html"><i class="glyphicon glyphicon-th-large"></i>  <span>特殊染色</span></a></li>
                <li><a href="/backend/pna/index.html?type=1"><i class="glyphicon glyphicon-th-large"></i>  <span>蛋白指标</span></a></li>
            </ul>
        </li>

        <li><a href="/backend/group/index.html"><i class="fa fa-bars"></i>
                <span>分组列表</span></a>
        </li>
        <li><a href="/backend/sample/index.html"><i class="fa fa-bars"></i>
                <span>样品列表</span></a>
        </li>
        <li><a href="/backend/stace/index.html"><i class="fa fa-bars"></i>
                <span>标本列表</span></a>
        </li>
        <li><a href="/backend/sdyeing/index.html"><i class="fa fa-bars"></i>
                <span>实验结果</span></a>
        </li>
        <li><a href="/backend/pna/show.html?type=1"><i class="fa fa-bars"></i>
                <span>抗体列表</span></a>
        </li>
        <li><a href="/backend/config/index.html"><i class="fa fa-bars"></i>
                <span>网站配置</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
            <ul class="treeview-menu">
                <li><a href="/backend/config/base-config.html"><i class="glyphicon glyphicon-th-large"></i>  <span>基础配置</span></a></li>
            </ul>
        </li>
        <li><a href="/backend/rbac/route/index.html"><i class="fa fa-bars"></i>
                <span>后台配置</span> <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i></span></a>
            <ul class="treeview-menu">
                <li><a href="/backend/admin-user/index.html"><i class="glyphicon glyphicon-th-large"></i>  <span>管理员列表</span></a></li>
                <li><a href="/backend/rbac/assignment/index.html"><i class="glyphicon glyphicon-th-large"></i>  <span>权限配置</span></a></li>
                <li><a href="/backend/rbac/role/index.html"><i class="glyphicon glyphicon-th-large"></i>  <span>角色列表</span></a></li>
                <li><a href="/backend/rbac/permission/index.html"><i class="glyphicon glyphicon-th-large"></i>  <span>权限列表</span></a></li>
                <li><a href="/backend/rbac/rule/index.html"><i class="glyphicon glyphicon-th-large"></i>  <span>规则列表</span></a></li>
            </ul>
        </li>
        <li><a href="/gii.html"><i class="fa fa-share"></i>  <span>开发工具</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
            <ul class="treeview-menu">
                <li><a href="/debug/default/index.html"><i class="fa fa-circle-o"></i>  <span>debug</span></a></li>
                <li><a href="/gii.html"><i class="fa fa-circle-o"></i>  <span>gii</span></a></li>
            </ul>
        </li>
    </section>
</aside>
