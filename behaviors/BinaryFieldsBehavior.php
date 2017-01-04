<?php

namespace nex_otaku\uuid\behaviors;

use yii\base\Behavior;
use nex_otaku\uuid\helpers\uuid;

/**
 * Преобразовываем UUID из бинарного вида в текстовый.
 * 
 * Использование:
 * public function behaviors()
 * {
 *     return [
 *         'binaryFields' => [
 *             'class' => BinaryFieldsBehavior::className(),
 *             'fields' => ['id', 'other_id']
 *         ]
 *     ];
 * }
 * 
 * По умолчанию генератор CRUD ставит "id" в список обязательных полей модели ("required").
 * Нужно удалить "id" из "required", тогда данные из формы будут нормально загружаться в модель.
 * 
 * Атрибут "id" будет заполняться при сохранении, если модель новая.
 *
 * @author Nex Otaku <nex@otaku.ru>
 */
class BinaryFieldsBehavior extends Behavior
{
    /**
     * @var array Список бинарных атрибутов
     */
    public $fields;
    
    /**
     * Конвертируем бинарные поля в текст при выводе в виде массива.
     * Это используется только при выводе запросов в формате JSON и XML.
     * @return array
     */
    public function binaryToArray()
    {
        $binaryAttributes = $this->fields;
        $result = [];
        foreach ($this->owner as $key => $value) {
            if (in_array($key, $binaryAttributes)) {
                $result[$key] = uuid::bin2uuid($value);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}
