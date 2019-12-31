<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Inventory;
use yii\data\ActiveDataProvider;
use app\models\Film;
use app\models\FilmCategory;
use app\models\Category;

class FilmController extends Controller
{
    public function actionIndex()
    {
        $query = Inventory::find()
            ->with(['film.categories', 'film.language']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        $query = Inventory::find()
            ->where(['inventory_id' => $id])
            ->with(['film.language', 'film.categories', 'film.originalLanguage'])
            ->one();

        return $this->render('view', ['model' => $query]);
    }

    public function _pre_var_export($object)
    {
        echo '<pre>', var_export($object), '</pre>';
    }
}
