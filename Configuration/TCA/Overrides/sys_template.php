<?php

// Add static files for plugins
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addStaticFile('comments', 'static/', 'Comments');
