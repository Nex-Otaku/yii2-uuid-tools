<?php

namespace nex_otaku\uuid\traits;

/**
 * Конвертируем бинарные поля в текст.
 * 
 * Трейт реализует метод toArray для интерфейса \yii\base\Arrayable модели.
 * 
 * См. BinaryFieldsBehavior.
 *
 * @author Nex Otaku <nex@otaku.ru>
 */
trait BinaryFieldsTrait
{
    /**
     * Конвертируем бинарные поля в текст при выводе в виде массива.
     * Это используется только при выводе запросов в формате JSON и XML.
     * @param array $fields
     * @param array $expand
     * @param type $recursive
     * @return array
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        // За этот метод отвечает BinaryFieldsBehavior.
        return $this->binaryToArray();
    }
}
