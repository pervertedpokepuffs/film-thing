<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Film;

class FilmSearch extends Film
{
    public $language;

    public function rules()
    {
        return [
            [['film_id', 'language_id', 'original_language_id', 'rental_duration', 'length', 'status','language'], 'integer'],
            [['special_features' ,'title', 'language_id', 'description', 'release_year', 'rating', 'special_features', 'last_update', 'filmCategories.category_id'], 'safe'],
            [['rental_rate', 'replacement_cost'], 'number'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['filmCategories.category_id'], ['language.language_id']);
    }

    // public function scenarios()
    // {
    //     return Model::scenarios();
    // }

    public function search($params)
    {
        $query = Film::find()
            ->where(['status' => 1])
            ->joinWith('filmCategories', 'language');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $dataProvider->sort->attributes['filmCategories.category_id'] = [
            'asc' => ['film_category.category_id' => SORT_ASC],
            'desc' => ['film_category.category_id' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['language.language_id'] = [
            'asc' => ['language.language_id' => SORT_ASC],
            'desc' => ['language.language_id' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'film.film_id' => $this->film_id,
            'release_year' => $this->release_year,
            'film.language_id' => $this->language,
            'original_language_id' => $this->original_language_id,
            'rental_duration' => $this->rental_duration,
            'rental_rate' => $this->rental_rate,
            'length' => $this->length,
            'replacement_cost' => $this->replacement_cost,
            'last_update' => $this->last_update,
            'film_category.category_id' => $this->getAttribute('filmCategories.category_id'),
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'rating', $this->rating])
            ->andFilterWhere(['like', 'special_features', $this->special_features]);
        
        return $dataProvider;
    }
}
