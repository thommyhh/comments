<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007 Dmitry Dulepov (dmitry@typo3.org)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Lang\LanguageService;


/**
 * This class provides hook to tt_news to add extra markers.
 *
 * @author	Dmitry Dulepov <dmitry@typo3.org>
 * @package TYPO3
 * @subpackage comments
 */
class tx_comments_ttnews {
	/**
 * Processes comments-specific markers for tt_news
 *
 * @param	array		$markerArray	Array with merkers
 * @param	array		$row	tt_news record
 * @param	array		$lConf	Configuration array for current tt_news view
 * @param	tx_ttnews		$pObj	Reference to parent object
 * @return	array		Modified marker array
 */
	function extraItemMarkerProcessor($markerArray, $row, $lConf, $pObj) {
		/* @var $pObj tx_ttnews */
		switch ($pObj->theCode) {
			case 'LATEST':
			case 'LIST':
			case 'SEARCH':
			case 'SINGLE':
				// Add marker for number of comments
				$commentCount = $this->getNumberOfComments($row['uid'], $pObj);
				$templateName = $commentCount ? '###TTNEWS_COMMENT_COUNT_SUB###' : '###TTNEWS_COMMENT_NONE_SUB###';
				if (($template = $this->getTemplate($templateName, $lConf, $pObj))) {
					$lang = GeneralUtility::makeInstance(LanguageService::class);
					/* @var $lang language */
					$markerArray['###TX_COMMENTS_COUNT###'] = $pObj->cObj->substituteMarkerArray(
						$template, array(
							'###COMMENTS_COUNT_NUMBER###' => $commentCount,
							'###COMMENTS_COUNT###' => sprintf($lang->sL('LLL:EXT:comments/locallang_hooks.xml:comments_number'), $commentCount),
							'###COMMENTS_COUNT_NONE###' => $lang->sL('LLL:EXT:comments/locallang_hooks.xml:comments_number_none'),
							'###UID###' => $row['uid'],
							'###COMMENTS_LINK###' => $this->getItemLink($markerArray['###LINK_ITEM###'], $row['uid'], $pObj, $pObj->theCode),
						)
					);
					unset($lang);	// Free memory explicitely!
				}
				break;
		}
		return $markerArray;
	}

	/**
	 * Retrieves number of comments
	 *
	 * @param	int		$newsUid	UID of tt_news item
	 * @param	tx_ttnews		$pObj	Reference to parent object
	 * @return	int		Number of comments for this news item
	 * @access private
	 */
	function getNumberOfComments($newsUid, $pObj) {
		/* @var $pObj tx_ttnews */
		$recs = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('COUNT(*) AS t', 'tx_comments_comments',
				'external_prefix=' . $GLOBALS['TYPO3_DB']->fullQuoteStr('tx_ttnews', 'tx_comments_comments') .
				' AND external_ref=' . $GLOBALS['TYPO3_DB']->fullQuoteStr('tt_news_' . $newsUid, 'tx_comments_comments') .
				' AND approved=1 ' .
				$pObj->cObj->enableFields('tx_comments_comments'));
		return $recs[0]['t'];
	}

	/**
	 * Retrieves template for custom marker
	 *
	 * @param	string		$section	Section name in the template
	 * @param	arrasy		$conf	tt_news configuration
	 * @param	tx_ttnews		$pObj	Reference to parent object
	 * @return	string		Template section
	 * @access private
	 */
	function getTemplate($section, $conf, $pObj) {
		// Search for file
		if (isset($conf['commentsTemplateFile'])) {
			$file = $conf['commentsTemplateFile'];
		}
		elseif (isset($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_comments_pi1.']['templateFile'])) {
			$file = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_comments_pi1.']['templateFile'];
		}
		else {
			// Use default
			$file = 'EXT:comments/resources/template/pi1_template.html';
		}
		if (($template = $pObj->cObj->fileResource($file))) {
			$template = $pObj->cObj->getSubpart($template, $section);
		}
		return $template;
	}

	/**
	 * Attempts to build URL to item.
	 * Firsts it checks if marker value is not empty. If yes, it treats it as a
	 * link to item and attempts to extract the link. If value is empty, it uses item
	 * uid to manually create link
	 *
	 * @param	string		$marker	Marker value with link
	 * @param	int		$itemUid	Item uid
	 * @param	tx_ttnews		$pObj	Reference to parent object
	 * @return	string		Generated URL to item
	 * @access private
	 */
	function getItemLink($marker, $itemUid, $pObj, $ttCode) {
		$result = '';
		if (isset($GLOBALS['TSFE']->register['newsMoreLink']) &&
				($pos = strpos($GLOBALS['TSFE']->register['newsMoreLink'], 'href="')) !== false && $ttCode!='SINGLE') {
			$value = substr($GLOBALS['TSFE']->register['newsMoreLink'], $pos + 6);
			$result = substr($value, 0, strpos($value, '"'));
		}
		if (!$result) {
			$params = array(
				'additionalParams' => '&tx_ttnews[tt_news]=' . $itemUid,
				'no_cache' => $GLOBALS['TSFE']->no_cache,
				'parameter' => $pObj->conf['singlePid'] ? $pObj->conf['singlePid'] : $GLOBALS['TSFE']->id,
				'useCacheHash' => !$GLOBALS['TSFE']->no_cache,
				'returnLast' => 'url',
			);
			$result = $pObj->cObj->typolink('|', $params);
		}
		return $result;
	}
}

?>