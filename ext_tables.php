<?php
/* $Id$ */

if (!defined('TYPO3_MODE')) die('Access denied.');

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_comments_comments');
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_comments_comments');
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_comments_comments', 'EXT:comments/locallang_csh.php');

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_comments_urllog');
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_comments_urllog');
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_comments_urllog', 'EXT:comments/locallang_csh.php');

if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_comments_pi1_wizicon'] = TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('comments').'pi1/class.tx_comments_pi1_wizicon.php';
}
