<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Film;

class FilmSearch extends Film
{
    public function rules()
    {
        return [
            [['film_id', 'language_id', 'original_language_id', 'rental_duration', 'length', 'status'], 'integer'],
            [['title', 'description', 'release_year', 'rating', 'special_features', 'last_update'], 'safe'],
            [['rental_rate', 'replacement_cost'], 'number'],
        ];
    }

    // public function scenarios()
    // {
    //     return Model::scenarios();
    // }

    public function search($params)
    {
        $query = Film::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'film_id' => $this->film_id,
            'release_year' => $this->release_year,
            'language_id' => $this->language_id,
            'original_language_id' => $this->original_language_id,
            'rental_duration' => $this->rental_duration,
            'rental_rate' => $this->rental_rate,
            'length' => $this->length,
            'replacement_cost' => $this->replacement_cost,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'rating', $this->rating])
            ->andFilterWhere(['like', 'special_features', $this->special_features]);

        return $dataProvider;
    }
}
