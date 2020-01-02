<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Inventory;
use yii\data\ActiveDataProvider;
use app\models\Film;
use app\models\FilmCategory;
use app\models\Category;
use app\models\Rental;
use Yii;

class FilmController extends Controller
{
    public function actionIndex()
    {
        $query = Inventory::find()
            ->with(['film.categories', 'film.language']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
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

    public function actionUpdate($id)
    {
        $query = Inventory::find()
            ->where(['inventory_id' => $id])
            ->with(['film.language', 'film.categories', 'film.originalLanguage'])
            ->one();
        
        if ($query->load(Yii::$app->request->post()) && $query->validate()) {
            $query->last_update = date('Y-m-d H:i:s');
            // $this->_pre_var_export($query);
            // die();
            $query->save();
            $this->redirect(['view', 'id' => $id]);
        } else {
            $allFilms = Film::find()
                ->orderBy(['title' => SORT_ASC])
                ->all();
            return $this->render('update', ['model' => $query, 'allFilms' => $allFilms]);
        }
    }

    public function actionDelete($id)
    {
        // Set all parent relations to NULL
        $rentalItems = Rental::deleteAll(['inventory_id' => $id]);

        Inventory::findOne(['inventory_id' => $id])
            ->delete();

        return $this->redirect('index');
    }

    public function _pre_var_export($object)
    {
        echo '<pre>', var_export($object), '</pre>';
    }
}
