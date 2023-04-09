<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    'NAME' => Loc::getMessage("ListAddresses_NAME"),
    'DESCRIPTION' => Loc::getMessage("ListAddresses_DESCRIPTION"),
    'COMPLEX' => 'Y',
    'SORT' => 10,
    'PATH' => [
        'ID' => 'Alimukhamedov',
        'CHILD' => [
            'ID' => "ListAddresses",
            'NAME' => Loc::getMessage("ListAddresses"),
            'SORT' => 30,
        ]
    ]
];
?>