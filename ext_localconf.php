<?php
declare(strict_types=1);

if (!(defined('TYPO3') || defined('TYPO3_MODE') || PHP_SAPI === 'cli')) {
    die('Access denied.');
}

// HINWEIS: Ab TYPO3 13.0 wird die Verwendung von Symfony-Routing empfohlen. Bitte überprüfen Sie die Routen.

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Routing\RouteCollection;

// Registrierung der CommandController
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = \Simplesigns\MlStonelexicon\Controller\ApiController::class;
// Konfiguration des Lexikon Frontend Plugins
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Vendor.ExtensionName',
    'PluginName',
    [
        'Controller' => 'action'
    ],
    [
        'Controller' => 'nonCacheableAction'
    ]
);

// Konfiguration des Json Frontend Plugins
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Vendor.ExtensionName',
    'JsonPluginName',
    [
        'Controller' => 'action'
    ],
    [
        'Controller' => 'nonCacheableAction'
    ]
);

// Einbindung des Haupt-Setup-TypoScripts
ExtensionManagementUtility::addTypoScriptSetup(
    '@import "EXT:ml_stonelexicon/Configuration/TypoScript/setup.typoscript"'
);

// Registrierung des Icons
$iconRegistry = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'apps-pagetree-mlstonelexicon',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:ml_stonelexicon/Resources/Public/Icons/BackendLayouts/diamant.svg']
);

// Routen für das API-Modul
if (is_file(GeneralUtility::getFileAbsFileName('EXT:ml_stonelexicon/Configuration/Routes.yaml'))) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['configFile'] = 'EXT:ml_stonelexicon/Configuration/Routes.yaml';
}

// Fehlerbehandlung für cHash-Fehler deaktivieren
$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFoundOnCHashError'] = false;

// Parameter von cHash-Berechnung ausschließen
if (!in_array('parameters', $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'], true)) {
    $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'parameters';
}

$routes = GeneralUtility::makeInstance(RouteCollection::class)->all();
foreach ($routes as $route) {
    \TYPO3\CMS\Core\Utility\DebugUtility::debug($route->getPath(), 'Registered Route');
}
