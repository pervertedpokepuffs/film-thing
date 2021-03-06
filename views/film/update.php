<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Film;

$this->title = $model->attributes['inventory_id'] . ': ' .  $model->film->attributes['title'];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?
$form = ActiveForm::begin([
    'id' => 'inventory-form',
]);
echo $form->field($model, 'film_id')->dropDownList(Film::get_films())->label('Reassign New Film');
?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>
<?
ActiveForm::end();
?>