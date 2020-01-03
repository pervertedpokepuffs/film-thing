<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Index';
?>

<div class="container-fluid">
    <div class="row">
        <? echo Html::a('Create New Inventory', 'create', [
            'class' => 'btn btn-primary'
        ]) ?>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <? echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                // 'inventory_id',
                'film.title',
                'film.description',
                'film.release_year',
                [
                    'label' => 'Language',
                    'attribute' => 'film.language.name'
                ],
                [
                    'label' => 'Categories',
                    'value' => function ($query) {
                        if (is_array($query->film->categories)) {
                            $categories_array = [];
                            foreach ($query->film->categories as $category) {
                                $categories_array[] = $category->attributes['name'];
                            }
                            return implode(', ', $categories_array);
                        }
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                ]
            ]
        ]) ?>
    </div>
</div>