<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = $model->attributes['film_id'] . ': ' .  $model->attributes['title'];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?
$listData = ArrayHelper::map($allLanguages, 'language_id', 'name');
$listData2 = ArrayHelper::map($allCategories, 'category_id', 'name');
$form = ActiveForm::begin();
echo $form->field($model, 'title')->textInput();
echo $form->field($model, 'description')->textarea();
echo $form->field($model, 'release_year')->textInput(['type' => 'number']);
echo $form->field($model, 'language_id')->dropDownList($listData)->label('Language');
echo $form->field($model, 'original_language_id')->dropDownList($listData)->label('Original Language');
echo $form->field($model, 'rental_duration')->textInput(['type' => 'number']);
echo $form->field($model, 'rental_rate')->textInput(['type' => 'number']);
echo $form->field($model, 'length')->textInput(['type' => 'number']);
echo $form->field($model, 'replacement_cost')->textInput(['type' => 'number']);
echo $form->field($model, 'rating')->textInput();
echo $form->field($model, 'special_features')->textInput();
echo $form->field($model_film, 'category_id[]')->checkboxList($listData2, ['separator' => '<br />'])->label('New Category');
?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>
<?
ActiveForm::end();
?>