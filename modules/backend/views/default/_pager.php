    <div class="list-table-pages">
        <table class="table table-hover text-center">
            <tr>
                <td>
                    <div class="list-table-pages-div">
                    <?php
                        $end=$pager->pageSize*($pager->currentPage+1);
                        $end=$end>$pager->itemCount?$pager->itemCount:$end;
                    ?>

                    <?php if($pager->itemCount == 0):?>
                        <div class="dataTables_info"></div>
                    <?php elseif($pager->itemCount > $pager->pageSize):?>

                        <div class="dataTables_info">当前显示 <?php echo $pager->pageSize*$pager->currentPage+1;?> 到 <?php echo $end;?> 条，共 <?php echo $pager->itemCount;?> 条记录</div>

                    <?php else: ?>
                        <!--0分页-->
                        <div class="dataTables_info">当前显示 <?php echo $pager->pageSize*$pager->currentPage+1;?> 到 <?php echo $end;?> 条，共 <?php echo $pager->itemCount;?> 条记录</div>

                    <?php endif; ?>

                    <div class="pagination dataTables_paginate paging_full_numbers">
                        <?php
                        $this->widget('CLinkPager',array(
                            'header'=>'',
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '末页',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'pages' => $pager,
                            'maxButtonCount'=>8,
                            'htmlOptions'=>array(
                               // 'class'=>'ajax-page'
                                'class'=>''
                            ),
                        ));?>
                    </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>


<div class="keys list-table-keys" title="<?php echo Yii::app()->request->getRequestUri();?>"></div>

