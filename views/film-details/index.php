<?php

use yii\grid\GridView;
use app\models\Category;
use app\models\Language;
$this->title = 'Film List';
?>

<? echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
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
            'attribute' => 'language_id',
            'filter' => Language::get_languages(),
            'value' => 'language.name'
        ],
        [
            'attribute' => 'filmCategories.category_id',
            'label' => 'Categories',
            'value' => function ($query) {
                if (is_array($query->categories)) {
                    $categories_array = [];
                    foreach ($query->categories as $category) {
                        $categories_array[] = $category->attributes['name'];
                    }
                    return implode(', ', $categories_array);
                }
            },
            'filter' => Category::get_categories()
        ],
        [
            'label' => 'Special Features',
            'value' => function ($query) {
                $exploded_string = explode(',', $query->attributes['special_features']);
                return implode(', ', $exploded_string);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
        ]
    ]
]) ?>