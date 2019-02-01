<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $news_id
 * @property string $date
 * @property int $theme_id
 * @property string $text
 * @property string $title
 *
 * @property Themes $theme
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'text'], 'required'],
            [['date'], 'safe'],
            [['theme_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Themes::className(), 'targetAttribute' => ['theme_id' => 'theme_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
            'date' => 'Date',
            'theme_id' => 'Theme ID',
            'text' => 'Text',
            'title' => 'Title',
        ];
    }
    public static function transactionMonth($english_month)
    {
        $trans = array(
            "January" => "Январь",
            "February" => "Февраль",
            "March" => "Март",
            "April" => "Апрель",
            "May" => "Май",
            "June" => "Июнь",
            "July" => "Июль",
            "August" => "Август",
            "September" => "Сентярь",
            "October" => "Октябрь",
            "November" => "Ноябрь",
            "December" => "Декабрь",
        );
        return $result  = strtr( $english_month, $trans);

    }

    public static function getViewPost($id)
    {
        return Yii::$app->db->createCommand("SELECT * FROM `news` inner join `themes` on `themes`.`theme_id` = `news`.`theme_id` WHERE `news_id`=".$id)->queryOne();
    }

    public static function getYearNews()
    {
        return Yii::$app->db->createCommand('SELECT YEAR(`date`) as `year` FROM `news` group by YEAR(`date`)')->queryAll();
    }

    public static function getNews($startIndex,$countView)
    {
        return Yii::$app->db->createCommand("SELECT * FROM `news` ORDER BY `date` DESC LIMIT $startIndex, $countView")->queryAll();
    }

    public static function getCountNews()
    {
        return Yii::$app->db->createCommand("SELECT COUNT(`news_id`) FROM `news`")->queryScalar();
    }

    public static function getCountNewsByTheme($theme_id)
    {
        return Yii::$app->db->createCommand("SELECT COUNT(`news_id`) FROM `news` WHERE `theme_id`=$theme_id")->queryScalar();
    }

    public static function getCountNewsByYearAndMonth($year,$month)
    {
        return Yii::$app->db->createCommand("SELECT COUNT(`news_id`) FROM `news` WHERE YEAR(`date`) = ".$year." AND MONTHNAME(`date`) = '$month'")->queryScalar();
    }

    public static function getCountNewsByYear($year)
    {
        return Yii::$app->db->createCommand("SELECT COUNT(`news_id`) FROM `news` WHERE YEAR(`date`) = ".$year)->queryScalar();
    }

    public static function getNewsToYearThemes($year)
    {
        return Yii::$app->db->createCommand("SELECT `themes`.`theme_id`,`themes`.`theme_title`,count(`news_id`) as `count` FROM `news` inner join `themes` on `themes`.`theme_id` = `news`.`theme_id` WHERE YEAR(`date`) = ".$year." group by `themes`.`theme_id`")->queryAll();
    }
    public static function getNewsToThemesAndYear($year,$theme_id)
    {
        return Yii::$app->db->createCommand("SELECT `themes`.`theme_id`,`themes`.`theme_title`,count(`news_id`) as `count` FROM `news` inner join `themes` on `themes`.`theme_id` = `news`.`theme_id` WHERE YEAR(`date`) = ".$year." and `news`.`theme_id` = ".$theme_id." group by `themes`.`theme_id`")->queryAll();
    }

    public static function getNewsToThemes($theme_id)
    {
        return Yii::$app->db->createCommand("SELECT `news`.`news_id`,`news`.`text`,`news`.`date`,`news`.`title` FROM `news` inner join `themes` on `themes`.`theme_id` = `news`.`theme_id` WHERE `themes`.`theme_id` = ".$theme_id)->queryAll();
    }

    public static function getCountToThemes()
    {
        return Yii::$app->db->createCommand("SELECT COUNT(`news`.`news_id`) as count, `themes`.`theme_title`, `themes`.`theme_id` FROM `news` inner join `themes` on `themes`.`theme_id` = `news`.`theme_id` group by `themes`.`theme_title`")->queryAll();
    }

    public static function getNewsToYear($year)
    {
        return Yii::$app->db->createCommand("SELECT * FROM `news` WHERE YEAR(`date`) = ".$year)->queryAll();
    }

    public static function getNewsToSort($year,$month)
    {
        return Yii::$app->db->createCommand("SELECT * FROM `news` WHERE YEAR(`date`) = ".$year." AND MONTHNAME(`date`) = '$month'")->queryAll();
    }
    public static function getNewsToYearAndTheme($year,$theme_id)
    {
        return Yii::$app->db->createCommand("SELECT * FROM `news` WHERE YEAR(`date`) = ".$year." AND `theme_id` = $theme_id")->queryAll();
    }

    public static function getCountNewsByMonths()
    {
        return Yii::$app->db->createCommand('SELECT COUNT(`news_id`) as `count`,  concat(MONTHNAME(`date`), \' \', YEAR(`date`)) as `month`, YEAR(`date`) as `year`, MONTHNAME(`date`) as `month` FROM `news` GROUP BY `month` order by `year`')->queryAll();
    }

    public function getTheme()
    {
        return $this->hasOne(Themes::className(), ['theme_id' => 'theme_id']);
    }
}
