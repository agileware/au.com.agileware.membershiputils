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
            'contact_id',
            'id',
            'contact_id.sort_name',
            'membership_type_id:label',
            'start_date',
            'end_date',
            'GROUP_CONCAT(UNIQUE Membership_LineItem_entity_id_01_LineItem_Contribution_contribution_id_01.receive_date ORDER BY Membership_LineItem_entity_id_01.contribution_id DESC) AS GROUP_CONCAT_Membership_LineItem_entity_id_01_LineItem_Contribution_contribution_id_01_receive_date_Membership_LineItem_entity_id_01_contribution_id',
            'GROUP_CONCAT(UNIQUE Membership_LineItem_entity_id_01_LineItem_Contribution_contribution_id_01.contribution_status_id:label ORDER BY Membership_LineItem_entity_id_01.contribution_id DESC) AS GROUP_CONCAT_Membership_LineItem_entity_id_01_LineItem_Contribution_contribution_id_01_contribution_status_id_label_Membership_LineItem_entity_id_01_contribution_id',
          ],
          'orderBy' => [],
          'where' => [
            [
              'OR',
              [
                [
                  'end_date',
                  '>',
                  'now + 30 day',
                ],
                [
                  'AND',
                  [
                    [
                      'Membership_LineItem_entity_id_01_LineItem_Contribution_contribution_id_01.contribution_status_id:name',
                      '=',
                      'Pending',
                    ],
                    [
                      'Membership_LineItem_entity_id_01_LineItem_Contribution_contribution_id_01.receive_date',
                      '>',
                      'now - 30 day',
                    ],
                  ],
                ],
              ],
            ],
          ],
          'groupBy' => [
            'contact_id',
            'id',
          ],
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
              'Contribution AS Membership_LineItem_entity_id_01_LineItem_Contribution_contribution_id_01',
              'LEFT',
              [
                'Membership_LineItem_entity_id_01.contribution_id',
                '=',
                'Membership_LineItem_entity_id_01_LineItem_Contribution_contribution_id_01.id',
              ],
            ],
          ],
          'having' => [],
        ],
        'description' => 'Used to determine what contacts can process a membership renewal using Contribution Pages.'."\n"
          ."\n"
          .'This search *must* select the Contact ID and Membership Type',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
];
