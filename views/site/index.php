<?php

use yii\widgets\ListView;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-10">
                <?= Listview::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_blog',
                    'layout' => "{items}\n{summary}\n{pager}",
                ]) ?>
            </div>
        </div>

    </div>
</div>
