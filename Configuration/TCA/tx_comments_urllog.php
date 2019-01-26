<?php

return [
    'ctrl' => array(
        'title' => 'LLL:EXT:comments/locallang_db.xml:tx_comments_urllog',
        'label' => 'external_ref',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'external_ref',
        'delete' => 'deleted',
        'hideTable' => true,
        'iconfile' => 'EXT:comments/icon_urllog.gif',
    ),
    'interface' => Array(
        'showRecordFieldList' => 'external_ref,url',
    ),
    'columns' => array(
        'external_ref' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:comments/locallang_db.xml:tx_comments_comments.external_ref',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'db',
                'prepand_tname' => true,
                'allowed' => '*',
                'minsize' => 1,
                'maxsize' => 1,
                'size' => 1,
                'wizards' => Array(
                    '_PADDING' => 1,
                    '_VERTICAL' => 1,
                    'edit' => Array(
                        'type' => 'popup',
                        'title' => 'LLL:EXT:comments/locallang_db.xml:tx_comments_comments.external_ref.wizard',
                        'module' => array(
                            'name' => 'wizard_edit',
                        ),
                        'popup_onlyOpenIfSelected' => 1,
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif',
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                    ),
                ),
            ),
        ),
        'url' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:comments/locallang_db.xml:tx_comments_urllog.url',
            'config' => array(
                'type' => 'input',
                'eval' => 'trim,required',
            ),
        ),
    ),
    'types' => array(
        0 => array('showitem' => 'external_ref;;;;1,url'),
    ),
];
