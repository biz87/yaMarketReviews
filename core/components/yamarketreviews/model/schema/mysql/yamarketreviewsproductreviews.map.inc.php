<?php
$xpdo_meta_map['yaMarketReviewsProductReviews']= array (
    'package' => 'yamarketreviews',
    'version' => '1.1',
    'table' => 'yaMarketReviews_productreviews',
    'extends' => 'xPDOSimpleObject',
    'tableMeta' =>
        array (
            'engine' => 'InnoDB',
        ),
    'fields' =>
        array (
            'productid' => 0,
            'reviewid' => 0,
            'grade' => 0,
            'agreeCount' => 0,
            'disagreeCount' => 0,
            'date' => '0000-00-00',
            'text' => '',
            'author' => '',
            'expired' => 0,
        ),
    'fieldMeta' =>
        array (
            'productid' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 0,
                ),
            'reviewid' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 0,
                ),
            'date' =>
                array (
                    'dbtype' => 'date',
                    'phptype' => 'date',
                    'null' => true,
                ),
            'grade' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ),
            'agreeCount' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ),
            'disagreeCount' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ),
            'expired' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 0,
                ),
            'author' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => true,
                    'default' => '',
                ),
            'text' =>
                array (
                    'dbtype' => 'text',
                    'phptype' => 'text',
                    'null' => true,
                    'default' => '',
                ),

        ),
);
