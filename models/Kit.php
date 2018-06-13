<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kit".
 *
 * @property integer $id
 * @property string $name
 * @property string $number
 * @property string $company
 * @property string $http
 * @property string $method
 * @property string $savetion
 * @property integer $rid
 * @property integer $isdel
 * @property string $retrieve
 * @property string $pdf
 */
class Kit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rid', 'isdel'], 'integer'],
            [['name', 'number'], 'string', 'max' => 100],
            [['company', 'http', 'method', 'savetion', 'retrieve', 'pdf'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'number' => 'Number',
            'company' => 'Company',
            'http' => 'Http',
            'method' => 'Method',
            'savetion' => 'Savetion',
            'rid' => 'Rid',
            'isdel' => 'Isdel',
            'retrieve' => 'Retrieve',
            'pdf' => 'Pdf',
        ];
    }
}
