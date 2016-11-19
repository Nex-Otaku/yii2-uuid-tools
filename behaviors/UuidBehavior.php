<?php

namespace nexotaku\toolkit\behaviors;

use yii\behaviors\AttributeBehavior;
use nexotaku\toolkit\helpers\uuid;
use yii\db\BaseActiveRecord;

/**
 * Инициализация UUID.
 * 
 * По умолчанию генератор CRUD ставит "id" в список обязательных полей модели ("required").
 * Нужно удалить "id" из "required", тогда данные из формы будут нормально загружаться в модель.
 * 
 * Атрибут "id" будет заполняться при сохранении, если модель новая.
 *
 * @author Nex Otaku <nex@otaku.ru>
 */
class UuidBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive timestamp value
     * Set this property to false if you do not want to record the creation time.
     */
    public $uuidAttribute = 'id';
    /**
     * @inheritdoc
     *
     * In case, when the value is `null`, generate uuid
     * will be used as value.
     */
    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->uuidAttribute],
            ];
        }
    }
    
    /**
     * @inheritdoc
     *
     * In case, when the [[value]] is `null`, 
     * generated uuid
     * will be used as value.
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            return uuid::binUuid();
        }
        return parent::getValue($event);
    }
}
