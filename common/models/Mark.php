<?php

namespace common\models;

/**
 * This is the model class for table "mark".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $subject_id
 * @property integer $class_id
 * @property integer $semester
 * @property string $marks
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Mark extends \yii\db\ActiveRecord
{
    public $file;
    public $action;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mark';
    }

//    public $mieng_1, $mieng_2, $mieng_3, $mieng_4, $mieng_5;
//    public $fm_1, $fm_2, $fm_3, $fm_4, $fm_5;
//    public $mieng1, $mieng2, $mieng3, $mieng4, $mieng5;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'subject_id', 'class_id', 'semester'], 'required'],
            [['student_id', 'subject_id', 'class_id', 'semester', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['marks', 'action', 'description', 'file'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'as contact_id',
            'subject_id' => 'Subject ID',
            'class_id' => 'as category_id',
            'semester' => 'Semester',
            'marks' => 'Marks',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
