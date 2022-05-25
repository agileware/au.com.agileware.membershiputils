<?php

return [
  'adjust_membership_end_date' => [
    'name' => 'adjust_membership_end_date',
    'type' => 'Boolean',
    'quick_form_type' => 'YesNo',
    'default' => 0,
    'is_domain' => 1,
    'is_contact' => 0,
    'title' => ts('Adjust membership end date'),
    'description' => ts('Automatically adjust the membership end date to the end of the month. For example: a membership with an end date of 16/04/2022 will be changed to 30/04/2022.'),
    'settings_pages' => ['membershiputils' => ['weight' => 10]],
  ],
];