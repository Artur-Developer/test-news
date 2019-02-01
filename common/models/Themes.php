<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "themes".
 *
 * @property int $theme_id
 * @property string $theme_title
 *
 * @property News[] $news
 */
class Themes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'themes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['theme_title'], 'required'],
            [['theme_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'theme_id' => 'Theme ID',
            'theme_title' => 'Theme Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['theme_id' => 'theme_id']);
    }
}
