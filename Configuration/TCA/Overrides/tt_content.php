<?php
declare(strict_types=1);
defined('TYPO3') or die();

/**
 * packages/ml_stonelexicon/Configuration/TCA/Overrides/tt_content.php
 * Registrierung des Plugins "Lexicon" im Backend und Konfiguration der FlexForm.
 */

// Registrierung des Plugins im Backend
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'MlStonelexicon',
    'Lexicon',
    'Steinlexikon'
);

// Optional: Weitere TCA-Anpassungen für das Plugin
$GLOBALS['TCA']['tt_content']['types']['mlstonelexicon_lexicon'] = [
    'showitem' => '
        --palette--;;general,
        --palette--;;headers,
        pi_flexform,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
        --palette--;;frames,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
        --palette--;;hidden,
        --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
        --palette--;;language,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended
    '
];
