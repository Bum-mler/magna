<?php
declare(strict_types=1);
defined('TYPO3') or die();

/**
 * /home/work/Projekte/magnastein-deployment-composer/packages/ml_stonelexicon/Configuration/TCA/Overrides/sys_template.php
 * Hinzufügen des statischen TypoScripts für die Extension "ml_stonelexicon".
 */

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'ml_stonelexicon',
    'Configuration/TypoScript',
    'Stone Lexicon'
);
