<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1С-Битрикс: Управление сайтом");
?>

<?
global $USER;
if ($USER->IsAuthorized()) {
	$APPLICATION->IncludeComponent(
		"main:list.addresses",
		"",
		array(
			"ACTIVE" => "N"
		)
	);
}?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>