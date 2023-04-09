<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */
/** @global CUserTypeManager $USER_FIELD_MANAGER */
use Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc;

$arComponentParameters = [
	'GROUPS' => [
	    'BASE_SETTINGS' => [
	        'NAME' => Loc::getMessage("BASE_SETTINGS_PARAMS"),
            'SORT' => 100,
        ]
    ],
	'PARAMETERS' => [
        'ACTIVE' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('VIEW_ACTIVE_ITEMS'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y'
        ],
    ],
];