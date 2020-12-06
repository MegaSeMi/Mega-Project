<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;

class AutorSearch extends Model
{
    /**
     * @var string
     */
    public $isbn;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['isbn',], 'string'],
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
            'defaultOrder' => ['autor.id' => SORT_DESC],
            'attributes' => ['autor.id'],
        ]);

        return $dataProvider;
    }

    /**
     * @return ActiveQuery
     */
    public function buildSearchQuery()
    {
        $query = Autor::find()
            ->joinWith('books');

        if (!empty($this->isbn)) {
            $query->andWhere('book.isbn = ' . $this->isbn);
        }
        return $query;
    }

}
