<?php

namespace FastDog\Admin\Models;

use FastDog\Core\Models\DomainManager;
use FastDog\Core\Models\ModuleManager;

/**
 * Реализация формирования меню в разделе администратора
 *
 * @package FastDog\Core
 * @version 0.2.0
 * @author Андрей Мартынов <d.g.dev482@gmail.com>
 */
class AdminMenu
{
    /**
     * Структура меню
     *
     * Метод возвращает структуру меню в зависимости от установленных модулей
     *
     * @return array
     */
    public static function get(): array
    {
        /**
         * @var $moduleManager ModuleManager
         */
        $moduleManager = \App::make(ModuleManager::class);

        $result = [];
        $moduleManager->getModules()->each(function ($data, $id) use (&$result) {
            if (self::checkAccess(DomainManager::getSiteId(), $data['access']())) {
                array_push($result, $data['admin_menu']());
            }
        });

        return $result;
    }

    /**
     * Проверка доступа к элементам меню
     *
     * @param string $siteId код сайта в формате ХХХ
     * @param array $accessList массив кодов сайта которым разрешен доступ к меню, определяется в файле module.json
     *
     * @return bool
     */
    public static function checkAccess($siteId, $accessList): bool
    {
        // Общий доступ к элементу открыт
        if (in_array("000", $accessList)) {
            return true;
        }

        // Доступ сайта к элементу открыт
        if (in_array($siteId, $accessList)) {
            return true;
        }

        // По умолчанию доступ закрыт
        return false;
    }
}
