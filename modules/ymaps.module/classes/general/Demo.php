<?php

namespace Ymaps;

use Bitrix\Iblock\ElementPropertyTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\TypeTable;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\DB\SqlExpression;
use Bitrix\Main\Entity\ReferenceField;

class Demo
{
    const MODULE_ID = 'ymaps.module';
    const DEFAULT_CODE = 'ymaps_demo';

    static $instance                = null;
    static $obIblock                = null;
    static $obIblockType            = null;
    static $obIblockProperty        = null;
    static $obIblockElement         = null;

    static $iblockTypeId            = null;
    static $iblockId                = null;
    static $iblockProperties        = [];
    static $iblockElements          = [];

    static $cache                   = null;
    static $ttl                     = 3600;
    static $cacheId                 = 'ymaps.module';
    static $cacheDir                = '/ymaps.module';

    /**
     * Demo constructor.
     * @throws \Bitrix\Main\LoaderException
     */
    public function __construct()
    {
        \Bitrix\Main\Loader::includeModule('iblock');

        static::$obIblock               = new \CIBlock();
        static::$obIblockType           = new \CIBlockType();
        static::$obIblockProperty       = new \CIBlockProperty();
        static::$obIblockElement        = new \CIBlockElement();
    }

    /**
     * @return Demo|null
     */
    public static function getInstance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $id
     * @return $this|false
     */
    public function createIblockType(string $id = self::DEFAULT_CODE)
    {
        $params = [
            'ID' => $id,
            'LANG' => [
                'ru' => [
                    'NAME' => 'Демо',
                    'SECTION_NAME' => 'Разделы',
                    'ELEMENT_NAME' => 'Элементы'
                ]
            ]
        ];

        self::$iblockTypeId = self::$obIblockType->Add($params);

        if (!self::$iblockTypeId)
        {
            throw new \Error(self::$obIblockType->LAST_ERROR);
            return false;
        }

        return $this;
    }

    /**
     * @param string $code
     * @return $this|false
     */
    public function createIblock(string $code = self::DEFAULT_CODE)
    {
        if (!self::$iblockTypeId)
        {
            throw new \Error('IblockType wasn\'t created. ');
            return false;
        }

        global $USER;

        $params = [
            'IBLOCK_TYPE_ID' => self::$iblockTypeId,
            'NAME' => self::DEFAULT_CODE,
            'ACTIVE' => 'Y',
            'VERSION' => 1,
            'CODE' => $code,
            'EXTERNAL_CODE' => $code,
            'SITE_ID' => 's1',
            'GROUP_ID' => array(
                $USER->GetUserGroupString() => 'R'
            )
        ];

        self::$iblockId = self::$obIblock->Add($params);

        if (!self::$iblockId)
        {
            throw new \Error(self::$obIblock->LAST_ERROR);
            return false;
        }

        return $this;
    }

    /**
     * @param array $properties
     * @return $this|false
     */
    public function createIblockProperties(array $properties)
    {
        if (!self::$iblockId)
        {
            throw new \Error('Iblock wasn\'t created. ');
            return false;
        }

        if (empty($properties))
        {
            throw new \Error('\'properties\' parameter can not be empty.');
            return false;
        }

        foreach ($properties as $property)
        {
            $property = array_merge(
                $property,
                ['IBLOCK_ID' => self::$iblockId, 'ACTIVE' => 'Y', 'PROPERTY_TYPE' => 'S']
            );

            $propertyId = self::$obIblockProperty->Add($property);

            if (!$propertyId)
            {
                throw new \Error(self::$obIblockProperty->LAST_ERROR);
                return false;
            }

            self::$iblockProperties[] = $propertyId;
        }

        return $this;
    }

    /**
     * @param array $elements
     * @return $this|false
     */
    public function createIblockElements(array $elements)
    {
        //checking iblockId
        if (!self::$iblockId)
        {
            throw new \Error('Iblock wasn\'t created. ');
            return false;
        }

        //checking elements array
        if (empty($elements))
        {
            throw new \Error('\'elements\' parameter can not be empty.');
            return false;
        }

        foreach ($elements as $element)
        {
            //filling iblockId
            $element = array_merge($element, ['IBLOCK_ID' => self::$iblockId]);

            //adding element
            $elementId = self::$obIblockElement->Add($element);

            //throwing an error
            if (!$elementId) {
                throw new \Error(self::$obIblockElement->LAST_ERROR);
                return false;
            }

            //filling properties
            if (is_set($element['PROPERTIES']) && is_array($element['PROPERTIES']) && !empty($element['PROPERTIES']))
            {
                $this->fillIblockElementProperties($elementId, $element['PROPERTIES']);
            }

            //just for check and log
            self::$iblockElements[] = $elementId;
        }

        return $this;
    }

    /**
     * @param int|null $elementId
     * @param array $properties
     * @return bool
     */
    public function fillIblockElementProperties(int $elementId = null, array $properties) : bool
    {
        /**
         * $properties = [$code => $value, $code => $value, ...]
         */

        if (is_null($elementId))
        {
            throw new \Error('\'elementId\' parameter can not be null.');
            return false;
        }

        if (empty($properties))
        {
            throw new \Error('\'properties\' parameter can not be empty.');
            return false;
        }

        $propertiesDBQuery = PropertyTable::query()
            ->setFilter(['=IBLOCK_ID' => self::$iblockId, '=CODE' => array_keys($properties)])
            ->setSelect(['CODE']);

        if(!$iblockProperties = $propertiesDBQuery->exec()->fetchAll())
        {
            throw new \Error('0 iblock properties was found by codes from parameter \'properties\'');
            return false;
        }

        foreach ($properties as $code => $value)
        {
            if (0 == mb_strlen($code) || 0 == mb_strlen($value))
                continue;

            if(!in_array($code, array_column($iblockProperties, 'CODE')))
                continue;

            $result = \CIBlockElement::SetPropertyValuesEx($elementId, self::$iblockId, [$code => $value]);
        }

        return true;
    }

    /**
     * @param string $directory
     */
    public function delete(string $directory)
    {
        // delete iblockType
        self::$obIblockType->Delete(self::DEFAULT_CODE);

        //Unregister module
        UnRegisterModule(self::MODULE_ID);

        //delete component and files
        $directories = array(
            'component' => array(
                'from' => $directory.'/components',
                'to' => $_SERVER['DOCUMENT_ROOT'].'/local/components'
            ),
            'files' => array(
                'from' => $directory.'/files',
                'to' => $_SERVER['DOCUMENT_ROOT'].'/ymaps'
            )
        );

        DeleteDirFiles($directories['component']['from'], $directories['component']['from']);
        DeleteDirFiles($directories['files']['from'], $directories['files']['to']);
    }

    public function getList()
    {
        self::$cache = Cache::createInstance();

        if(self::$cache->initCache(self::$ttl, self::$cacheId, self::$cacheDir))
        {
            $result = self::$cache->getVars();
        }
        elseif(self::$cache->startDataCache(self::$ttl, self::$cacheId, self::$cacheDir))
        {
            $iblockDBQuery = IblockTable::query()
                ->addFilter('IBLOCK_TYPE_ID', 'ymaps_demo')
                ->addSelect('ID');

            $propertyDBQuery = PropertyTable::query()
                ->addFilter('CODE', 'COORDS')
                ->addSelect('ID');

            $dbQuery = ElementTable::query()
                ->setFilter([
                    '@IBLOCK_ID' => new SqlExpression($iblockDBQuery->getQuery()),
                    'ACTIVE' => 'Y'
                ])
                ->registerRuntimeField('PROPERTY_COORDS', new ReferenceField(
                    'PROPERTY_COORDS',
                    ElementPropertyTable::getEntity(),
                    [
                        '=this.ID' => 'ref.IBLOCK_ELEMENT_ID',
                        'ref.IBLOCK_PROPERTY_ID' => new SqlExpression($propertyDBQuery->fetchObject()->getId())
                    ],
                ))
                ->setCacheTtl(3600)
                ->cacheJoins(true)
                ->setSelect([
                    'ID',
                    'NAME',
                    'COORDS' => 'PROPERTY_COORDS.VALUE'
                ]);

            $result = $dbQuery->exec()->fetchAll();

            self::$cache->endDataCache($result);
        }

        return $result;
    }

    public function handleRequest(string $method)
    {
        return call_user_func(__CLASS__.'::'.$method);
    }
}