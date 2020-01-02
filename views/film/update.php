<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = $model->attributes['inventory_id'] . ': ' .  $model->film->attributes['title'];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?
$listData = ArrayHelper::map($allFilms, 'film_id', 'title');
$form = ActiveForm::begin([
    'id' => 'inventory-form',
]);
echo $form->field($model, 'film_id')->dropDownList($listData)->label('Reassign New Film');
?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>
<?
ActiveForm::end();
?>