<?php

use yii\grid\GridView;
$this->title = 'Film List';
?>

<? echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'film_id',
        'title',
        // [
        //     'label' => 'Tajuk',
        //     'attribute' => 'title'
        // ],
        'description',
        'release_year',
        [
            'label' => 'Language',
            'attribute' => 'language.name'
        ],
        [
            'label' => 'Categories',
            'value' => function ($query) {
                if (is_array($query->categories)) {
                    $categories_array = [];
                    foreach ($query->categories as $category) {
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