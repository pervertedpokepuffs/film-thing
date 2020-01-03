<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Language;
use app\models\Category;

$this->title = 'Create New Movie';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?
$form = ActiveForm::begin();
echo $form->field($model, 'title')->textInput();
echo $form->field($model, 'description')->textarea();
echo $form->field($model, 'release_year')->textInput(['type' => 'number']);
echo $form->field($model, 'language_id')->dropDownList(Language::get_languages())->label('Language');
echo $form->field($model, 'original_language_id')->dropDownList(Language::get_languages())->label('Original Language');
echo $form->field($model, 'rental_duration')->textInput(['type' => 'number']);
echo $form->field($model, 'rental_rate')->textInput(['type' => 'number', 'step' => '0.01']);
echo $form->field($model, 'length')->textInput(['type' => 'number']);
echo $form->field($model, 'replacement_cost')->textInput(['type' => 'number', 'step' => '0.01']);
echo $form->field($model, 'rating')->textInput();
echo $form->field($model, 'special_features')->textInput();
echo $form->field($model_film, 'category_id[]')->checkboxList(Category::get_categories(), ['separator' => '<br />'])->label('New Category');
?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>
<?
ActiveForm::end();
?>