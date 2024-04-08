<?php
use CRM_Membershiputils_ExtensionUtil as E;

return [
  [
    'name' => 'SavedSearch_Excluded_from_Renewal',
    'entity' => 'SavedSearch',
    'cleanup' => 'unused',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'Excluded_from_Renewal',
        'label' => E::ts('Excluded from Renewal'),
        'api_entity' => 'Membership',
        'api_params' => [
          'version' => 4,
          'select' => [
            'id',
            'contact_id.sort_name',
            'membership_type_id:label',
            'start_date',
            'end_date',
            'Membership_LineItem_entity_id_01_LineItem_Contribution_entity_id_01.contribution_status_id:label',
          ],
          'orderBy' => [],
          'where' => [
            [
              'OR',
              [
                [
                  'end_date',
                  '<',
                  'now + 30 day',
                ],
                [
                  'AND',
                  [
                    [
                      'Membership_LineItem_entity_id_01_LineItem_Contribution_entity_id_01.receive_date',
                      '>',
                      'now - 30 day',
                    ],
                    [
                      'Membership_LineItem_entity_id_01_LineItem_Contribution_entity_id_01.contribution_status_id:name',
                      '=',
                      'Pending',
                    ],
                  ],
                ],
              ],
            ],
          ],
          'groupBy' => [],
          'join' => [
            [
              'LineItem AS Membership_LineItem_entity_id_01',
              'LEFT',
              [
                'id',
                '=',
                'Membership_LineItem_entity_id_01.entity_id',
              ],
              [
                'Membership_LineItem_entity_id_01.entity_table',
                '=',
                '\'civicrm_membership\'',
              ],
            ],
            [
              'Contribution AS Membership_LineItem_entity_id_01_LineItem_Contribution_entity_id_01',
              'LEFT',
              [
                'Membership_LineItem_entity_id_01.entity_id',
                '=',
                'Membership_LineItem_entity_id_01_LineItem_Contribution_entity_id_01.id',
              ],
              [
                'Membership_LineItem_entity_id_01.entity_table',
                '=',
                '\'civicrm_contribution\'',
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
];
