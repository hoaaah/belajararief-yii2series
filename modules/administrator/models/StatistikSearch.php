<?php

namespace app\modules\administrator\models;

use app\models\Blog;
use app\models\BlogCounter;
use yii\base\Model;
use yii\helpers\Json;

/**
 * BlogSearch represents the model behind the search form of `app\models\Blog`.
 */
class StatistikSearch extends Model
{
    public $user_id;
    public $title;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['title'], 'string'],
        ];
    }

    public function getBlogCountByMonthJson()
    {
        return Json::encode($this->getBlogCountByMonth());
    }

    public function getBlogCountByMonth()
    {
        $blogCountByMonth = BlogCounter::find()
        ->select(['MONTH(FROM_UNIXTIME(created_at)) month', 'count(id) AS count'])
        ->where(['blog_id' => $this->getBlog()->id ])
        ->groupBy('MONTH(FROM_UNIXTIME(created_at))')->asArray()->all();

        return $blogCountByMonth;
    }

    public function getBlog()
    {
        return Blog::findOne(['created_by' => $this->user_id, 'slug' => $this->title]);
    }
}
