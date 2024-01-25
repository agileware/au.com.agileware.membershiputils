<?php
return [
	'adjust_membership_end_date' => [
		'name' => 'adjust_membership_end_date',
		'type' => 'Boolean',
		'html_type' => 'YesNo',
		'default' => 0,
		'is_domain' => 1,
		'is_contact' => 0,
		'title' => ts('Set Membership End Date to end of the month'),
		'description' => ts('Set the Membership End Date to the end of month. Applies to New, Current and Grace memberships only.'),
		'settings_pages' => ['membershiputils' => ['weight' => 10]],
	],
	'use_specific_membership_end_date' => [
		'name' => 'use_specific_membership_end_date',
		'type' => 'Boolean',
		'html_type' => 'YesNo',
		'default' => 0,
		'is_domain' => 1,
		'is_contact' => 0,
		'title' => ts('Use a specific Membership End Date'),
		'description' => ts('Enable this option to use the specific Membership End Date defined in the field below.'),
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
		'title' => ts('Specific Membership End Date'),
		'description' => ts('Set the Membership End Date to the end of month. Applies to New, Current and Grace memberships only. Leave blank to disable.'),
		'settings_pages' => ['membershiputils' => ['weight' => 10]],
	],
];