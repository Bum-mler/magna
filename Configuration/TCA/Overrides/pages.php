<?php
declare(strict_types=1);
defined('TYPO3') or die();

/**
 * packages/ml_stonelexicon/Configuration/TCA/Overrides/pages.php
 * Konfiguration der Seiten-Tabelle, insbesondere für den benutzerdefinierten Doktyp.
 */

 (function () {
    $customPageDoktype = 169;
    $customIconClass = 'apps-pagetree-mlstonelexicon';

    // Neues Seitenelement zum Typ-Auswahlfeld hinzufügen
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'pages',
        'doktype',
        [
            'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang.xlf:apps-pagetree-mlstonelexicon',
            'value' => $customPageDoktype,
            'icon'  => $customIconClass,
            'group' => 'special',
        ]
    );

    // Symbolklasse für den neuen Seitentyp hinzufügen
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$customPageDoktype] = $customIconClass;

    // Definieren und Hinzufügen von spezifischen Feldern und Paletten für das Lexikon
    $stoneTca = [
        'rocktype' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang.xlf:tx_mlstonelexicon_domain_model_stone.rocktype',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'subgroup' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang.xlf:tx_mlstonelexicon_domain_model_stone.subgroup',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'age' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang.xlf:tx_mlstonelexicon_domain_model_stone.age',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'origin' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang.xlf:tx_mlstonelexicon_domain_model_stone.origin',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'color' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang.xlf:tx_mlstonelexicon_domain_model_stone.color',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Bitte auswählen', 'value' => '--div--'],
                    ['label' => 'Schwarz', 'value' => 1],
                    ['label' => 'Braun', 'value' => 2],
                    ['label' => 'Rot', 'value' => 3],
                    ['label' => 'Blau', 'value' => 4],
                    ['label' => 'Grün', 'value' => 5],
                    ['label' => 'Rosa', 'value' => 6],
                    ['label' => 'Beige', 'value' => 7],
                    ['label' => 'Gelb', 'value' => 8],
                    ['label' => 'Grau', 'value' => 9],
                    ['label' => 'Weiß', 'value' => 10],
                ],
                'maxitems' => 1,
            ],
        ],
        'structure' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang.xlf:tx_mlstonelexicon_domain_model_stone.structure',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Bitte auswählen', 'value' => '--div--'],
                    ['label' => 'Pfeffer-Salz', 'value' => 1],
                    ['label' => 'unifarben', 'value' => 2],
                    ['label' => 'gewolkt', 'value' => 3],
                    ['label' => 'geadert', 'value' => 4],
                    ['label' => 'transluzent', 'value' => 5],
                    ['label' => 'körnig', 'value' => 6],
                    ['label' => 'nadelig', 'value' => 7],
                    ['label' => 'gebändert', 'value' => 8],
                    ['label' => 'glitzernd', 'value' => 9],
                    ['label' => 'marmoriert', 'value' => 10],
                ],
                'maxitems' => 1,
            ],
        ],
        'thumbnail' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang.xlf:tx_mlstonelexicon_domain_model_stone.thumbnail',
            'config' => [
                'type' => 'file',
                'file' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:media.addFileReference'
                ],
                'maxitems' => 1,
            ],
        ],
        'indoordry_1' => [
            'exclude' => 1,
            'label' => 'Küchenarbeitsplatte',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => 'Küchenarbeitsplatte',
                        'labelChecked' => 'Ja',
                        'labelUnchecked' => 'Nein',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'indoordry_2' => [
            'exclude' => 1,
            'label' => 'Wandverkleidung',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => 'Wandverkleidung',
                        'labelChecked' => 'Ja',
                        'labelUnchecked' => 'Nein',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'indoordry_3' => [
            'exclude' => 1,
            'label' => 'Bodenbelag',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => 'Bodenbelag',
                        'labelChecked' => 'Ja',
                        'labelUnchecked' => 'Nein',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'indoorwet_1' => [
            'exclude' => 1,
            'label' => 'Dusche',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => 'Dusche',
                        'labelChecked' => 'Ja',
                        'labelUnchecked' => 'Nein',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'indoorwet_2' => [
            'exclude' => 1,
            'label' => 'Waschtisch',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => 'Waschtisch',
                        'labelChecked' => 'Ja',
                        'labelUnchecked' => 'Nein',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'indoorwet_3' => [
            'exclude' => 1,
            'label' => 'Bodenbelag (nass)',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => 'Bodenbelag (nass)',
                        'labelChecked' => 'Ja',
                        'labelUnchecked' => 'Nein',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'outdoor_1' => [
            'exclude' => 1,
            'label' => 'Außenfassade',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => 'Außenfassade',
                        'labelChecked' => 'Ja',
                        'labelUnchecked' => 'Nein',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'outdoor_2' => [
            'exclude' => 1,
            'label' => 'Terrasse',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => 'Terrasse',
                        'labelChecked' => 'Ja',
                        'labelUnchecked' => 'Nein',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'outdoor_3' => [
            'exclude' => 1,
            'label' => 'Außentreppe',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => 'Außentreppe',
                        'labelChecked' => 'Ja',
                        'labelUnchecked' => 'Nein',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $stoneTca);

    // Paletten definieren
    $GLOBALS['TCA']['pages']['palettes']['lexicon'] = [
        'showitem' => 'rocktype, subgroup, age, origin, color, structure'
    ];

    $GLOBALS['TCA']['pages']['palettes']['bild'] = [
        'showitem' => 'thumbnail'
    ];

    $GLOBALS['TCA']['pages']['palettes']['indoordryPalette'] = [
        'showitem' => 'indoordry_1, indoordry_2, indoordry_3',
    ];

    $GLOBALS['TCA']['pages']['palettes']['indoorwetPalette'] = [
        'showitem' => 'indoorwet_1, indoorwet_2, indoorwet_3',
    ];

    $GLOBALS['TCA']['pages']['palettes']['outdoorPalette'] = [
        'showitem' => 'outdoor_1, outdoor_2, outdoor_3',
    ];

    // Konfiguriere die Darstellung der Felder im Backend
    $GLOBALS['TCA']['pages']['types'][$customPageDoktype]['showitem'] = '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.standard;standard,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.title;title,
        
        --div--;Lexikon,
            --palette--;Teaser;bild,
            --palette--;Einstellungen für das Lexikon;lexicon,   
            --palette--;Innenbereich trocken;indoordryPalette,
            --palette--;Innenbereich nass;indoorwetPalette,
            --palette--;Außenbereich;outdoorPalette,

        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.appearance,
            --palette--;;backend_layout,
            --palette--;;replace,

        --div--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.tabs.seo,
            --palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.seo;seo,
            --palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.social;social,
            --palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.opengraph;opengraph,
            --palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.twittercards;twittercards,
            --palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.robots;robots,
            --palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.canonical;canonical,
            --palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.sitemap;sitemap,

        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.metatags;metatags,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.abstract;abstract,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.editorial;editorial,

        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,

        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;visibility,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access,

        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.language;language,
    ';
})();
