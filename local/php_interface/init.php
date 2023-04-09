<?php
$eventManager = Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler('', 'LinkAddressesOnAfterAdd', [
    'cacheController', 'clearTagCache'
]);
$eventManager->addEventHandler('', 'LinkAddressesOnAfterUpdate', [
    'cacheController', 'clearTagCache'
]);
$eventManager->addEventHandler('', 'LinkAddressesOnAfterDelete', [
    'cacheController', 'clearTagCache'
]);

class cacheController{
    public static function clearTagCache(\Bitrix\Main\Entity\Event $event){
        $taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();
        $taggedCache->clearByTag('hl_block_1');
    }
}