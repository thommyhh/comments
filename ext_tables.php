<?php
/* $Id$ */

if (!defined('TYPO3_MODE')) die('Access denied.');

// Add static files for plugins
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'static/', 'Comments');

// Add pi1 plugin
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1'] = 'pi_flexform';
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(Array('LLL:EXT:comments/pi1/locallang.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'), 'list_type');

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($_EXTKEY .'_pi1', 'FILE:EXT:comments/pi1/flexform_ds.xml');


// Comments table
$TCA['tx_comments_comments'] = array(
	'ctrl' => array (
		'title' => 'LLL:EXT:comments/locallang_db.xml:tx_comments_comments',
		'label' => 'content',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'default_sortby' => ' ORDER BY crdate DESC',
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'tca.php',
		'iconfile' => TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'icon_comments.gif',
		//'type' => 'approved',
		'typeicon_column' => 'approved',
		'typeicons' => array(
			'0' => TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'icon_comments_not_approved.gif',
			'1' => TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'icon_comments.gif',
		),
	)
);
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_comments_comments');
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_comments_comments');
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_comments_comments', 'EXT:comments/locallang_csh.php');

// URL log table
$TCA['tx_comments_urllog'] = array(
	'ctrl' => array (
		'title' => 'LLL:EXT:comments/locallang_db.xml:tx_comments_urllog',
		'label' => 'external_ref',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'sortby' => 'external_ref',
		'delete' => 'deleted',
		'hideTable' => true,
		'dynamicConfigFile' => TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'tca.php',
		'iconfile' => TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'icon_urllog.gif',
	)
);
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_comments_urllog');
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_comments_urllog');
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_comments_urllog', 'EXT:comments/locallang_csh.php');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_comments_pi1_wizicon'] = TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'pi1/class.tx_comments_pi1_wizicon.php';
}
