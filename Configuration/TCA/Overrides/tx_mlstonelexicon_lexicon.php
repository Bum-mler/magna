<?php
declare(strict_types=1);
defined('TYPO3') or die();

/**
 * tx_mlstonelexicon_lexicon.php
 * Konfiguration der TCA für die Tabelle "tx_mlstonelexicon_lexicon".
 */
 
 return [
     'ctrl' => [
         'title' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang_db.xlf:pages.tx_mlstonelexicon_lexicon',
         'label' => 'name',
         'tstamp' => 'tstamp',
         'crdate' => 'crdate',
         'versioningWS' => true,
         'languageField' => 'sys_language_uid',
         'transOrigPointerField' => 'l10n_parent',
         'transOrigDiffSourceField' => 'l10n_diffsource',
         'delete' => 'deleted',
         'enablecolumns' => [
             'disabled' => 'hidden',
             'starttime' => 'starttime',
             'endtime' => 'endtime',
         ],
         'searchFields' => 'name,description',
         'iconfile' => 'EXT:ml_stonelexicon/Resources/Public/Icons/tx_mlstonelexicon_lexicon.svg',
     ],
     'types' => [
         '1' => ['showitem' => 'name, description, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:media, image, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
     ],
     'columns' => [
         'sys_language_uid' => [
             'exclude' => 1,
             'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
             'config' => ['type' => 'language'],
         ],
         'l10n_parent' => [
             'displayCond' => 'FIELD:sys_language_uid:>:0',
             'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
             'config' => [
                 'type' => 'select',
                 'renderType' => 'selectSingle',
                 'default' => 0,
                 'items' => [
                     ['label' => '', 'value' => 0],
                 ],
                 'foreign_table' => 'pages',
                 'foreign_table_where' => 'AND {#pages}.{#pid}=###CURRENT_PID### AND {#pages}.{#sys_language_uid} IN (-1,0)',
             ],
         ],
         'l10n_diffsource' => [
             'config' => [
                 'type' => 'passthrough',
             ],
         ],
         't3ver_label' => [
             'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
             'config' => [
                 'type' => 'input',
                 'size' => 30,
                 'max' => 255,
             ],
         ],
         'hidden' => [
             'exclude' => 1,
             'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
             'config' => [
                 'type' => 'check',
             ],
         ],
         'starttime' => [
             'exclude' => 1,
             'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
             'config' => [
                 'type' => 'datetime',
                 'default' => 0,
             ],
         ],
         'endtime' => [
             'exclude' => 1,
             'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
             'config' => [
                 'type' => 'datetime',
                 'default' => 0,
             ],
         ],
         'name' => [
             'exclude' => 0,
             'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang_db.xlf:pages.tx_mlstonelexicon_lexicon.name',
             'config' => [
                 'type' => 'input',
                 'size' => 30,
                 'eval' => 'trim',
                 'required' => true,
             ],
         ],
         'description' => [
             'exclude' => 0,
             'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang_db.xlf:pages.tx_mlstonelexicon_lexicon.description',
             'config' => [
                 'type' => 'text',
                 'cols' => 40,
                 'rows' => 15,
                 'eval' => 'trim',
             ],
         ],
         'image' => [
             'exclude' => 0,
             'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/locallang_db.xlf:pages.tx_mlstonelexicon_lexicon.image',
             'config' => [
                 ### !!! Watch out for fieldName different from columnName
                 'type' => 'file',
                 'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                 'appearance' => [
                     'createNewRelationLinkTitle' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:media.addFileReference'
                 ],
                 'maxitems' => 1,
                 'minitems' => 0,
             ],
         ],
     ],
 ];
 