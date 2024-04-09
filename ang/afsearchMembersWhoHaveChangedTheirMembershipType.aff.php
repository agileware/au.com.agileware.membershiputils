<?php
use CRM_Membershiputils_ExtensionUtil as E;

return [
  'type' => 'search',
  'title' => E::ts('Members who have changed their membership type'),
  'icon' => 'fa-list-alt',
  'server_route' => 'civicrm/member/type-changed-report',
  'permission' => [
    'access CiviMember',
  ],
  'search_displays' => [
    'Members_that_changed_type.Members_who_have_changed_type_Table_1',
  ],
];
