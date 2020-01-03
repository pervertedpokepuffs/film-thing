<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Inventory;
use yii\data\ActiveDataProvider;
use app\models\Film;
use app\models\search\FilmSearch;
use app\models\FilmCategory;
use app\models\Category;
use app\models\Language;
use app\models\Rental;
use Yii;

class FilmDetailsController extends Controller
{
    public function actionIndex()
    {
        // $query = Film::find()
        //     ->where(['status' => 1])
        //     ->with(['categories', 'language']);

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        //     'pagination' => [
        //         'pageSize' => 10
        //     ]
        // ]);

        $model = new FilmSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('index', ['model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        $query = Film::find()
            ->where(['film_id' => $id])
            ->with(['language', 'categories', 'originalLanguage'])
            ->one();

        $category_query = FilmCategory::find()
            ->where(['film_id' => $id])
            ->with(['category']);

        $dataProvider = new ActiveDataProvider([
            'query' => $category_query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        // $this->_pre_var_export($dataProvider->query->all());
        // die();

        return $this->render('view', ['model' => $query, 'category_provider' => $dataProvider]);
    }

    public function actionUpdate($id)
    {
        $query = Film::find()
            ->where(['film_id' => $id])
            ->with(['filmCategories', 'language', 'categories', 'originalLanguage'])
            ->one();

        if ($query->load(Yii::$app->request->post())) {
            $checked_film_categories = Yii::$app->request->post('FilmCategory');
            // check if ($category of film_id) in $checked_film_categories
            // delete pair
            foreach ($query->filmCategories as $film_category) {
                if (!in_array($film_category->attributes['category_id'], $checked_film_categories['category_id']))
                    $film_category->delete();
            }
            // check if ($checked_film_categories, $film_id) pair !exists
            // generate pair
            foreach ($checked_film_categories['category_id'] as $film_category) {
                if (!count(FilmCategory::findAll(['category_id' => $film_category, 'film_id' => $id]))) {
                    $newPair = new FilmCategory();
                    $newPair->category_id = $film_category;
                    $newPair->film_id = $id;
                    $newPair->last_update = date('Y-m-d H:i:s');
                    if ($newPair->validate())
                        $newPair->save();
                }
            }
            $query->last_update = date('Y-m-d H:i:s');
            $query->release_year = $query->release_year;
            if ($query->validate())
                $query->save();
            $this->redirect(['view', 'id' => $id]);
        } else {
            $allLanguages = Language::find()
                ->orderBy(['name' => SORT_ASC])
                ->all();
            $allCategories = Category::find()
                ->orderBy(['name' => SORT_ASC])
                ->all();
            $model_film = new FilmCategory();
            // $this->_pre_var_export($category_query);
            // die();
            return $this->render('update', ['model' => $query, 'allLanguages' => $allLanguages, 'allCategories' => $allCategories, 'model_film' => $model_film]);
        }
    }

    public function actionDelete($id)
    {
        $film = Film::findOne(['film_id' => $id]);
        $film->status = 0;
        $film->save();

        return $this->redirect('index');
    }

    public function _pre_var_export($object)
    {
        echo '<pre>', var_export($object), '</pre>';
    }
}
