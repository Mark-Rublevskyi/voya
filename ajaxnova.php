<?php
    include_once "vendor/autoload.php";
    use NovaPoshta\Config;

    Config::setApiKey('<cb8622121497f74c255d2d16d142dc94>');
    Config::setFormat(Config::FORMAT_JSONRPC2);
    Config::setLanguage(Config::LANGUAGE_UA);
require_once('nova-poshta/src/Delivery/NovaPoshtaApi2.php');
require_once('nova-poshta/src/Delivery/NovaPoshtaApi2Areas.php');
$np = new \LisDev\Delivery\NovaPoshtaApi2(
'cb8622121497f74c255d2d16d142dc94',
'ru', // Язык возвращаемых данных: ru (default) | ua | en
FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
'curl' // Используемый механизм запроса: curl (defalut) | file_get_content
);
if($_POST['warehouses']) {
$wh = $np->getWarehouses($_POST['warehouses']);
foreach ($wh['data'] as $warehouse) {
echo '<option>'.$warehouse['DescriptionRu'].'</option>';
}
} else {
$cities = $np->getCities();
foreach ($cities['data'] as $city) {
echo '<option data-id="'.$city['Ref'].'" value="'.$city['DescriptionRu'].'">'.$city['DescriptionRu'].'</option>';
}
}
// data-value="'.$city['Ref'].'"
?>
