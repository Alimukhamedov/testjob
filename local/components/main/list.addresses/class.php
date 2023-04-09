<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Engine\CurrentUser,
    Bitrix\Main\Loader,
    Bitrix\Highloadblock,
    Bitrix\Main\Entity;
Loader::includeModule("highloadblock");

class ListAddressesComponent extends \CBitrixComponent
{
    const GRID_ID = 'addresses_list';
    private $hlId = 1;

    public static $gridCols = [
        ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true],
        ['id' => 'UF_USER_ID', 'name' => 'ID юзера', 'sort' => 'UF_USER_ID', 'default' => true],
        ['id' => 'UF_ADDRESS', 'name' => 'Адрес', 'sort' => 'UF_ADDRESS', 'default' => true],
        ['id' => 'UF_ACTIVE', 'name' => 'Активность', 'sort' => 'UF_ACTIVE', 'default' => true],
    ];

    /**
     * @param $hlId
     * @return \Bitrix\Main\ORM\Data\DataManager|string
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getEntityData($hlId){
        $dataManager = Highloadblock\HighloadBlockTable::compileEntity(Highloadblock\HighloadBlockTable::getById($hlId)->fetch())->getDataClass();
        return $dataManager;
    }

    /**
     * @param $userId
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getList($userId): array
    {
        $result = [];
        if ($this->arParams['ACTIVE'] == 'Y'){
            $arFilter = ["UF_USER_ID"=>$userId,'UF_ACTIVE' => 1];
        }else{
            $arFilter = ["UF_USER_ID"=>$userId];
        }
        $cache = \Bitrix\Main\Data\Cache::createInstance();
        $taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();

        $cachePath = "user.address.list";
        $cacheTtl = 36000;
        $cacheKey = "hl_block_{$this->hlId}";


        if ($cache->initCache($cacheTtl, $cacheKey, $cachePath))
        {
            $result = $cache->getVars();
        }
        elseif ($cache->startDataCache())
        {
            $taggedCache->startTagCache($cachePath);
            $taggedCache->registerTag($cacheKey);
            $entity = $this->getEntityData($this->hlId);
            $result = $entity::getList([
                "select" => array("*"),
                "order" => array("ID" => "ASC"),
                "filter" => array($arFilter)
            ])->fetchAll();
            $taggedCache->endTagCache();
            $cache->endDataCache($result);
        }

        foreach ($result as $item){

            $item['UF_ACTIVE'] = $item['UF_ACTIVE'] ? 'да' : 'нет';

            $items[] = [
                'id' => $item['ID'],
                'data' => $item
            ];
        }

        return $items;
    }

    /**
     * @return mixed|void|null
     */
    public function executeComponent()
    {
        // пагинация
        $gridOptions = new Bitrix\Main\Grid\Options(self::GRID_ID);
        $navParams = $gridOptions->getNavParams();
        $pageSize = $navParams['nPageSize'];
        $nav = new \Bitrix\Main\UI\PageNavigation("page");
        $nav->allowAllRecords(false)
            ->setPageSize($pageSize)
            ->initFromUri();

        $this->arResult = [
          'ITEMS' => $this->getList(CurrentUser::get()->getId()),
          'GRID_ID' => self::GRID_ID,
          'GRID_COLS' => self::$gridCols,
          'GRID_NAV' => $nav,
        ];

        $this->includeComponentTemplate();
    }


}