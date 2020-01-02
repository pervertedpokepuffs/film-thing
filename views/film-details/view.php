<?php

use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\helpers\Html;

$this->title = $model->attributes['film_id'] .  ': ' . $model->attributes['title'];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Update', ['update', 'id' => $model->film_id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->film_id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
</p>
<?
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'film_id',
        'title',
        'description',
        'release_year',
        [
            'label' => 'Language',
            'attribute' => 'language.name'
        ],
        [
            'label' => 'Length',
            'value' => function ($model) {
                return $model->attributes['length'] . ($model->attributes['length'] > 1 ? ' minutes' : ' minute');
            }
        ],
        'rating',
        [
            'label' => 'Special Features',
            'value' => function ($model) {
                $temp_array = explode(',', $model->attributes['special_features']);
                return implode(', ', $temp_array);
            }
        ],
        [
            'label' => 'Original Language',
            'value' => function ($model) {
                return $model->originalLanguage->attributes['name'] === NULL ? 'N/a' : $model->originalLanguage->attributes['name'];
            }
        ],
        [
            'label' => 'Rental Rate',
            'value' => function ($model) {
                return '₽ ' . $model->attributes['rental_rate'];
            }
        ],
        [
            'label' => 'Rental Duration',
            'value' => function ($model) {
                return $model->attributes['rental_duration'] . ($model->attributes['rental_duration'] > 1 ? ' days' : ' day');
            }
        ],
        [
            'label' => 'Replacement Cost',
            'value' => function ($model) {
                return '₽ ' . $model->attributes['replacement_cost'];
            }
        ],
    ]
]);
echo GridView::widget([
    'dataProvider' => $category_provider,
    'columns' => [
        [
            'label' => 'Categories',
            'value' => function ($query) {
                if (is_array($query->category)) {
                    $categories_array = [];
                    foreach ($query->category as $category) {
                        $categories_array[] = $category->attributes['name'];
                    }
                    return implode(', ', $categories_array);
                } else return $query->category->attributes['name'];
            }
        ],
    ]
])
?>