<?php

namespace nex_otaku\uuid\classes;

use yii\web\UrlRule;
use yii\web\UrlRuleInterface;
use nex_otaku\uuid\helpers\uuid;

/**
 * Правила для обработки URL с UUID.
 * 
 * Параметр "id" содержит текстовое представление бинарного UUID, 
 * и конвертируется в обе стороны автоматически.
 * 
 * Использование:
 * [
 *     'class' => 'common\modules\user\classes\UuidUrlRule',
 *     'pattern' => '<id:@uuid@>',
 *     'route' => 'profile/show',
 * ],
 *
 * @author Nex Otaku <nex@otaku.ru>
 */
class UuidUrlRule extends UrlRule implements UrlRuleInterface
{
    public function init()
    {
        if ($this->pattern === null) {
            throw new InvalidConfigException('UrlRule::pattern must be set.');
        }
        // Заменяем сокращение на проверку формата UUID по регулярному выражению.
        $this->pattern = str_replace('@uuid@', '([0-9a-f]{8})-([0-9a-f]{4})-([0-9a-f]{4})-([0-9a-f]{4})-([0-9a-f]{12})', $this->pattern);
        parent::init();
    }
    
    /**
     * Parses the given request and returns the corresponding route and parameters.
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|boolean the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {
        $result = parent::parseRequest($manager, $request);
        if (is_array($result)) {
            $params = $result[1];
            // Если параметра 'id' нет, или он не подходит под наш формат, то это не наш URL.
            if (!array_key_exists('id', $params) || !uuid::isUuid($params['id'])) {
                return false;
            }
            // Конвертируем текстовый UUID в бинарный формат.
            $result[1]['id'] = uuid::uuid2bin($params['id']);
        }
        return $result;
    }

    /**
     * Creates a URL according to the given route and parameters.
     * @param UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        // Если параметра 'id' нет, или он не подходит под наш формат, то это не наш URL.
        if (!array_key_exists('id', $params) || !uuid::isBinUuid($params['id'])) {
            return false;
        }
        // Конвертируем бинарный ID в текстовый формат.
        $params['id'] = uuid::bin2uuid($params['id']);
        // Генерируем URL как обычно.
        return parent::createUrl($manager, $route, $params);
    }
}
