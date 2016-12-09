<?php
/**
 * Created by PhpStorm.
 * User: HungChelsea
 * Date: 03-Aug-16
 * Time: 11:28 AM
 */

namespace common\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ItemKodiSearch extends ItemKodi
{
    public $keyword;
    public $categoryIds;
    public $listCatIds;
    public $cp_id;
    public $site_id;
    public $category_id;
    public $order;
    public $content_id;
    public $pricing_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
{
    return [
        [['type', 'status', 'honor'], 'integer'],
        [['display_name','created_at','updated_at','addon','category'],'string']
    ];
}

    /**
     * {@inheritdoc}
     */
    public function scenarios()
{
    // bypass scenarios() implementation in the parent class
    return Model::scenarios();
}

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
{
//                $query = Content::find();
    $query = ItemKodi::find()
        ->innerJoin('kodi_category_item_asm','kodi_category_item_asm.item_id = item_kodi.id')
        ->innerJoin('kodi_category','kodi_category.id = kodi_category_item_asm.category_id ');
        $query->andWhere(['kodi_category.status' => self::STATUS_ACTIVE]);
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'sort'  => [
        ],
    ]);
    $this->load($params);

    if (!$this->validate()) {
        // uncomment the following line if you do not want to return any records when validation fails
        // $query->where('0=1');
        return $dataProvider;
    }
        $query->andFilterWhere([
            'item_kodi.id' => $this->id,
            'item_kodi.type' => $this->type,
            'item_kodi.status' => $this->status,
            'item_kodi.honor' => $this->honor,
        ]);
        if($this->created_at != ''){
            $created_at_arr = explode('/',$this->created_at);
            $date = \DateTime::createFromFormat('Y-m-d H:i:s',$created_at_arr['2'].'-'.$created_at_arr['1'].'-'.$created_at_arr['0'].' 00:00:00');
            $create_at     = strtotime($date->format('m/d/Y'));
            $create_at_end = $create_at + (60 * 60 * 24);

            $query->andFilterWhere(['>=', 'item_kodi.created_at', $create_at]);
            $query->andFilterWhere(['<=', 'item_kodi.created_at', $create_at_end]);
        }

        if($this->updated_at != ''){
            $created_at_arr = explode('/',$this->updated_at);
            $date = \DateTime::createFromFormat('Y-m-d H:i:s',$created_at_arr['2'].'-'.$created_at_arr['1'].'-'.$created_at_arr['0'].' 00:00:00');
            $updated_at     = strtotime($date->format('m/d/Y'));
            $updated_at_end = $updated_at + (60 * 60 * 24);

            $query->andFilterWhere(['>=', 'item_kodi.updated_at', $updated_at]);
            $query->andFilterWhere(['<=', 'item_kodi.updated_at', $updated_at_end]);
        }
        if($this->addon != ''){
            $query->andWhere(['kodi_category_item_asm.category_id'=>$this->addon]);
        }
        if($this->category != ''){
            $query->orFilterWhere(['kodi_category_item_asm.category_id'=>$this->category]);
        }
        $query->andFilterWhere(['like', 'lower(item_kodi.display_name)',strtolower($this->display_name)])
            ->andFilterWhere(['like', 'item_kodi.description', $this->description]);

        $query->distinct();

    return $dataProvider;
}

}
