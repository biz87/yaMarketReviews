<?php
$key = $modx->getOption('yamarketreviews_yaMarketKey');

$yaMarketReviews = $modx->getService(
    'yaMarketReviews',
    'yaMarketReviews', MODX_CORE_PATH . 'components/yamarketreviews/model/yamarketreviews/',
    $key
);

if (!$yaMarketReviews) {
    return 'Could not load yaMarketReviews class!';
}

if(!$scriptProperties['productid']){
    return;
}

$productid = $modx->getOption('productid', $scriptProperties);
$saveTime = $modx->getOption('saveTime', $scriptProperties, '3 days');

//Очистка базы от устаревших записей и если нужно запись свежих
$response = $yaMarketReviews->getProductReviews($productid, $saveTime);

$rowTpl = $modx->getOption('tpl', $scriptProperties, 'yaMarketReview.tpl');
$wrapperTpl = $modx->getOption('wrapperTpl', $scriptProperties, 'yaMarketReviews.tpl');
$sortby = $modx->getOption('sortby', $scriptProperties, 'date');
$sortdir = $modx->getOption('sortdir', $scriptProperties, 'asc');

$scriptProperties['class'] = 'yaMarketReviewsProductReviews';
$scriptProperties['tpl'] = $rowTpl;
$scriptProperties['tplWrapper'] = $wrapperTpl;
$scriptProperties['sortby'] = $sortby;
$scriptProperties['sortdir'] = $sortdir;
$scriptProperties['where']['productid'] = $productid;


$output = $modx->runSnippet('pdoPage', $scriptProperties);
return $output;