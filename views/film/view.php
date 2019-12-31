<?php
use yii\widgets\DetailView;

$this->title = $model->film->attributes['title'];
$this->params['breadcrumbs'][] = $this->title;
?>

<? 
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'film.title',
            'film.description',
            'film.release_year',
            [
                'label' => 'Language',
                'attribute' => 'film.language.name'
            ],
            [
                'label' => 'Length',
                'value' => function($model){
                    return $model->film->attributes['length'] . ($model->film->attributes['length'] > 1 ? ' minutes' : ' minute');
                }
            ],
            'film.rating',
            [
                'label' => 'Special Features',
                'value' => function($model){
                    $temp_array = explode(',', $model->film->attributes['special_features']);
                    return implode(', ', $temp_array);
                }
            ],
            [
                'label' => 'Original Language',
                'value' => function($model){
                    return $model->film->originalLanguage->attributes['name'] === NULL ? 'N/a' : $model->film->originalLanguage->attributes['name'];
                }
            ],
            [
                'label' => 'Rental Rate',
                'value' => function($model){
                    return '₽ ' . $model->film->attributes['rental_rate'];
                }
            ],
            [
                'label' => 'Rental Duration',
                'value' => function($model){
                    return $model->film->attributes['rental_duration'] . ($model->film->attributes['rental_duration'] > 1 ? ' days' : ' day');
                }
            ],
            [
                'label' => 'Replacement Cost',
                'value' => function($model){
                    return '₽ ' . $model->film->attributes['replacement_cost'];
                }
            ],
        ]
    ])
?>