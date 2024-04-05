<?php

use CRM_Membershiputils_ExtensionUtil as E;

return [
	'adjust_membership_end_date' => [
		'name' => 'adjust_membership_end_date',
		'type' => 'Boolean',
		'html_type' => 'YesNo',
		'default' => 0,
		'is_domain' => 1,
		'is_contact' => 0,
		'title' => E::ts('Set Membership End Date to end of the month'),
		'description' => E::ts('Set the Membership End Date to the end of month. Applies to New, Current and Grace memberships only.'),
		'settings_pages' => ['membershiputils' => ['weight' => 10]],
	],
	'use_specific_membership_end_date' => [
		'name' => 'use_specific_membership_end_date',
		'type' => 'Boolean',
		'html_type' => 'YesNo',
		'default' => 0,
		'is_domain' => 1,
		'is_contact' => 0,
		'title' => E::ts('Use a specific Membership End Date'),
		'description' => E::ts('Enable this option to use the specific Membership End Date defined in the field below.'),
		'settings_pages' => ['membershiputils' => ['weight' => 10]],
	],
	'specific_membership_end_date' => [
		'name' => 'specific_membership_end_date',
		'type' => 'Date',
		'html_type' => 'datepicker',
		'html_extra' => [
			'time' => FALSE,
			],
		'is_domain' => 1,
		'is_contact' => 0,
		'title' => E::ts('Specific Membership End Date'),
		'description' => E::ts('Set the Membership End Date to the end of month. Applies to New, Current and Grace memberships only. Leave blank to disable.'),
		'settings_pages' => ['membershiputils' => ['weight' => 10]],
	],
  'membershiputils_type_change_notification' => [
		'name' => 'membershiputils_type_change_notification',
		'type' => 'Boolean',
		'html_type' => 'YesNo',
    'default' => 0,
		'is_domain' => 1,
		'is_contact' => 0,
		'title' => E::ts('Show type change notification?'),
		'description' => E::ts('When enabled, members renewing will be shown an informative message if they select a price option that would change their Membership type.'),
		'settings_pages' => ['membershiputils' => ['weight' => 10]],
	],
  'membershiputils_type_change_message' => [
    'name' => 'membershiputils_type_change_message',
    'type' => 'Text',
    'html_type' => 'textarea',
    'html_attributes' => [
      'cols' => 80,
    ],
    'default' => E::ts('Are you sure you want to change your Membership Type from ‘%1’ to ‘%2’?'),
		'is_domain' => 1,
		'is_contact' => 0,
		'title' => E::ts('Type change message'),
		'description' => E::ts('Sets the message to be shown to members on the renewal form when they\'re going to change their Membership type'),
		'settings_pages' => ['membershiputils' => ['weight' => 10]],
  ]
];
