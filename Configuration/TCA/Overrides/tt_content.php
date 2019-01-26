<?php

// Add pi1 plugin
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['comments_pi1'] = 'layout,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['comments_pi1'] = 'pi_flexform';
ExtensionManagementUtility::addPlugin(['LLL:EXT:comments/pi1/locallang.xml:tt_content.list_type_pi1', 'comments_pi1'], 'list_type', 'comments');
ExtensionManagementUtility::addPiFlexFormValue('comments_pi1', 'FILE:EXT:comments/pi1/flexform_ds.xml');
