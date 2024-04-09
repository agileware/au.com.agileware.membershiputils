<?php
use CRM_Membershiputils_ExtensionUtil as E;

return [
  [
    'name' => 'Navigation_afsearchMembersWhoHaveChangedTheirMembershipType',
    'entity' => 'Navigation',
    'cleanup' => 'unused',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'label' => E::ts('Members who have changed their membership type'),
        'name' => 'afsearchMembersWhoHaveChangedTheirMembershipType',
        'url' => 'civicrm/member/type-changed-report',
        'icon' => 'crm-i fa-list-alt',
        'permission' => [
          'access CiviMember',
        ],
        'permission_operator' => 'AND',
        'parent_id.name' => 'Membership Reports',
        'weight' => 3,
      ],
      'match' => [
        'name',
        'domain_id',
      ],
    ],
  ],
];
