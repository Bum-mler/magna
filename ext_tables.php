<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\DataHandling\PageDoktypeRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// Definiere neuen Doktype
$customPageDoktype = 169;

// Seitentyp zum System hinzufügen
$dokTypeRegistry = GeneralUtility::makeInstance(PageDoktypeRegistry::class);
$dokTypeRegistry->add(
    $customPageDoktype,
    [
        'type' => 'web',
        'allowedTables' => '*',
    ]
);

// Registrieren des Doktype-Icons
call_user_func(function() use ($customPageDoktype) {
    $iconIdentifier = 'apps-pagetree-mlstonelexicon';

    // Registrierung des Icons für den neuen Doktype
    GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class)
        ->registerIcon(
            $iconIdentifier,
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:ml_stonelexicon/Resources/Public/Icons/BackendLayouts/diamant.svg']
        );

    // PageTS-Konfiguration für den neuen Doktype
    ExtensionManagementUtility::addPageTSConfig("
        mod {
            web_layout {
                doktypeIcon {
                    $customPageDoktype = '$iconIdentifier'
                }
            }
        }
    ");

    // Benutzerdefinierte Drag Area im Page Tree für den neuen Doktype
    ExtensionManagementUtility::addUserTSConfig("
        options.pageTree.doktypesToShowInNewPageDragArea := addToList($customPageDoktype)
    ");
});

