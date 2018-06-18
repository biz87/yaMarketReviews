<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/yaMarketReviews/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/yamarketreviews')) {
            $cache->deleteTree(
                $dev . 'assets/components/yamarketreviews/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/yamarketreviews/', $dev . 'assets/components/yamarketreviews');
        }
        if (!is_link($dev . 'core/components/yamarketreviews')) {
            $cache->deleteTree(
                $dev . 'core/components/yamarketreviews/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/yamarketreviews/', $dev . 'core/components/yamarketreviews');
        }
    }
}

return true;