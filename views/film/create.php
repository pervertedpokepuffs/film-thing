<?php

use yii\widgets\ActiveForm;
use app\models\Film;
use app\models\Store;
use yii\helpers\Html;

$this->title = 'Create New Inventory';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?
$form = ActiveForm::begin([
    'id' => 'inventory-form',
]);
echo $form->field($model, 'film_id')->dropDownList(Film::get_films())->label('Create New Film');
echo $form->field($model, 'store_id')->dropDownList(Store::get_stores());
?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>
<?
ActiveForm::end();
?>