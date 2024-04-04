<?php
use CRM_Membershiputils_ExtensionUtil as E;

return [
  [
    'name' => 'SavedSearch_Members_that_changed_type',
    'entity' => 'SavedSearch',
    'cleanup' => 'unused',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'Members_that_changed_type',
        'label' => E::ts('Members who have changed type'),
        'api_entity' => 'Contact',
        'api_params' => [
          'version' => 4,
          'select' => [
            'id',
            'sort_name',
            'contact_type:label',
            'contact_sub_type:label',
            'Contact_ActivityContact_Activity_01.subject',
            'Contact_ActivityContact_Activity_01.activity_date_time',
          ],
          'orderBy' => [],
          'where' => [],
          'groupBy' => [],
          'join' => [
            [
              'Activity AS Contact_ActivityContact_Activity_01',
              'INNER',
              'ActivityContact',
              [
                'id',
                '=',
                'Contact_ActivityContact_Activity_01.contact_id',
              ],
              [
                'Contact_ActivityContact_Activity_01.record_type_id:name',
                '=',
                '"Activity Targets"',
              ],
              [
                'Contact_ActivityContact_Activity_01.activity_type_id:name',
                '=',
                '"Change Membership Type"',
              ],
            ],
            [
              'Membership AS Contact_Membership_contact_id_01',
              'INNER',
              [
                'id',
                '=',
                'Contact_Membership_contact_id_01.contact_id',
              ],
            ],
          ],
          'having' => [],
        ],
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'SavedSearch_Members_that_changed_type_SearchDisplay_Members_who_have_changed_type_Table_1',
    'entity' => 'SearchDisplay',
    'cleanup' => 'unused',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'Members_who_have_changed_type_Table_1',
        'label' => E::ts('Members who have changed type'),
        'saved_search_id.name' => 'Members_that_changed_type',
        'type' => 'table',
        'settings' => [
          'description' => NULL,
          'sort' => [
            [
              'Contact_ActivityContact_Activity_01.activity_date_time',
              'DESC',
            ],
            [
              'sort_name',
              'ASC',
            ],
          ],
          'limit' => 50,
          'pager' => [],
          'placeholder' => 5,
          'columns' => [
            [
              'type' => 'field',
              'key' => 'Contact_ActivityContact_Activity_01.activity_date_time',
              'dataType' => 'Timestamp',
              'label' => E::ts('Date'),
              'sortable' => TRUE,
            ],
            [
              'type' => 'field',
              'key' => 'sort_name',
              'dataType' => 'String',
              'label' => E::ts('Sort Name'),
              'sortable' => TRUE,
            ],
            [
              'type' => 'field',
              'key' => 'contact_type:label',
              'dataType' => 'String',
              'label' => E::ts('Contact Type'),
              'sortable' => TRUE,
              'rewrite' => '[contact_type:label] /'."\n"
                .'[contact_sub_type:label]',
            ],
            [
              'type' => 'field',
              'key' => 'Contact_ActivityContact_Activity_01.subject',
              'dataType' => 'String',
              'label' => E::ts('Change'),
              'sortable' => TRUE,
            ],
            [
              'links' => [
                [
                  'entity' => 'Membership',
                  'action' => 'view',
                  'join' => 'Contact_Membership_contact_id_01',
                  'target' => 'crm-popup',
                  'icon' => 'fa-external-link',
                  'text' => E::ts('View Membership'),
                  'style' => 'default',
                  'path' => '',
                  'task' => '',
                  'condition' => [
                    'check user permission',
                    '=',
                    [
                      'access CiviMember',
                    ],
                  ],
                ],
              ],
              'type' => 'links',
              'alignment' => 'text-right',
            ],
          ],
          'actions' => TRUE,
          'classes' => [
            'table',
            'table-striped',
          ],
        ],
      ],
      'match' => [
        'saved_search_id',
        'name',
      ],
    ],
  ],
];
