<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;

class BookSearch extends Model
{
    /**
     * @var string | string[]
     */
    public $autor;

    /**
     * @var bool
     */
    public $isCoauthorship = false;

    /**
     * @var string
     */
    public $genre;

    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $year;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['autor', 'genre', 'country', 'language', 'year'], 'string'],
            [['isCoauthorship',], 'boolean'],
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function search()
    {
        $dataProvider =  new ActiveDataProvider([
            'query' => $this->buildSearchQuery(),
            'pagination' => [
                'class' => Pagination::class,
                'defaultPageSize' => 10,
                'pageSizeLimit' => [0, 50],
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['book.id' => SORT_DESC],
            'attributes' => ['book.id'],
        ]);

        return $dataProvider;
    }

    /**
     * @return ActiveQuery
     */
    public function buildSearchQuery()
    {
        $query = Book::find()
            ->joinWith('autors');

        if (!empty($this->autor)) {
            $autors = $this->autor;
            if (!is_array($autors)) {
                $autors = [$autors];
            }
            $query->andWhere(['in', 'autor.id', $autors]);
        }

        if ($this->isCoauthorship) {
            $query
                ->select('book.*')
                ->addSelect('count(autor.id) as cnt')
                ->groupBy('book.id')
                ->having('cnt > 1');
        }

        if (!empty($this->genre)) {
            $query->andWhere(['=', 'book.genre', $this->genre]);
        }

        if (!empty($this->country)) {
            $query->andWhere(['=', 'book.country', $this->country]);
        }

        if (!empty($this->language)) {
            $query->andWhere(['=', 'book.language', $this->language]);
        }

        if (!empty($this->year)) {
            $query->andWhere(['=', 'book.year', $this->year]);
        }
        return $query;
    }

}
