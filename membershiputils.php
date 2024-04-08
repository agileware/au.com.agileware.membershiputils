<?php

require_once 'membershiputils.civix.php';

// phpcs:disable
use CRM_Membershiputils_ExtensionUtil as E;
use Symfony\Component\DependencyInjection\{ContainerBuilder,Definition};

// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function membershiputils_civicrm_config(&$config) {
  _membershiputils_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_container().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_container/
 */
function membershiputils_civicrm_container( ContainerBuilder $container) {
  $resource_hooks = new Definition('CRM_Membershiputils_ResourceHooks');
  $resource_hooks->addTag('kernel.event_subscriber');
  $container->setDefinition('membershiputils_resource_hooks', $resource_hooks);

  $process_hooks = new Definition('CRM_Membershiputils_ProcessHooks');
  $process_hooks->addTag('kernel.event_subscriber');
  $container->setDefinition('membershiputils_process_hooks', $process_hooks);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function membershiputils_civicrm_install() {
  _membershiputils_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function membershiputils_civicrm_enable() {
  _membershiputils_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function membershiputils_civicrm_managed(&$entities) {
  $entities[] = [
    'module'  => 'au.com.agileware.membershiputils',
    'name'    => 'duplicate',
    'entity'  => 'MembershipStatus',
    'update'  => 'never',
    'cleanup' => 'never',
    'params'  => [
      'version'           => 3,
      'name'              => 'Duplicate',
      'label'             => 'Duplicate',
      'is_current_member' => 0,
      'is_active'         => 1,
      'is_admin'          => 1,
      'is_default'        => 0,
      'is_reserved'       => 0,
      'weight'            => 999,
    ],
  ];
  $entities[] = [
    'module'  => 'au.com.agileware.membershiputils',
    'name'    => 'notrenewing',
    'entity'  => 'MembershipStatus',
    'update'  => 'never',
    'cleanup' => 'never',
    'params'  => [
      'version'           => 3,
      'name'              => 'Not Renewing',
      'label'             => 'Not Renewing',
      'is_current_member' => 0,
      'is_active'         => 1,
      'is_admin'          => 1,
      'is_default'        => 0,
      'is_reserved'       => 0,
      'weight'            => 999,
    ],
  ];
  $entities[] = [
    'module'  => 'au.com.agileware.membershiputils',
    'name' => 'findduplicatememberships',
    'entity' => 'Job',
    'update' => 'always',
    'params' => [
      'version' => 3,
      'name' => 'Find Duplicate Memberships',
      'description' => 'Find duplicate memberships and set their Membership Status to Duplicate.',
      'api_entity' => 'membershiputils',
      'api_action' => 'Findduplicatememberships',
      'parameters' => '',
      'run_frequency' => 'Always',
      'is_active' => 0,
    ],
  ];
	$entities[] = [
		'module' => 'au.com.agileware.membershiputils',
		'name' => 'adjustmembershipenddate',
		'entity' => 'Job',
		'update' => 'always',
		'params' => [
			'version' => 3,
			'name' => 'Set Membership End Date to end of the month',
			'description' => 'Set the Membership End Date to the end of month. Applies to New, Current and Grace memberships only.',
			'api_entity' => 'membershiputils',
			'api_action' => 'Adjustmembershipenddate',
			'parameters' => '',
			'run_frequency' => 'Daily',
			'is_active' => 0,
		],
	];
	$entities[] = [
		'module' => 'au.com.agileware.membershiputils',
		'name' => 'specificmembershipenddate',
		'entity' => 'Job',
		'update' => 'always',
		'params' => [
			'version' => 3,
			'name' => 'Set Membership End Date to a specific date',
			'description' => 'Set Membership End Date to a specific date. Applies to New, Current and Grace memberships only.',
			'api_entity' => 'membershiputils',
			'api_action' => 'Specificmembershipenddate',
			'parameters' => '',
			'run_frequency' => 'Daily',
			'is_active' => 0,
		],
	];
}

/*
 * Adjust the end date to end of the month
 */

function membershiputils_adjustmembershipenddate($end_date) {
  // Bizarrely, CiviCRM may pass in end_date in either of these two formats
  if (strpos($end_date, '-') == FALSE) {
    $date_format = 'Ymd';
    // Return only the date part of a MySQL datetime value
    $end_date = substr($end_date, 0, 8);
  }
  else {
    $date_format = 'Y-m-d';
  }

	// Use the current end date as default
	$new_end_date = date_create_from_format($date_format, $end_date);

	// Adjust the end date to the last day of the month
	if (Civi::settings()->get('adjust_membership_end_date')) {
		$end_date = date_create_from_format($date_format, $end_date);
		$start_month = date_create($end_date->format('Y-m') . '-01');
	  $new_end_date = date_modify( $start_month, '+1 month -1 day' );
} elseif (Civi::settings()->get('use_specific_membership_end_date')) {
		// Otherwise set a specific end date
		$new_end_date = date_create_from_format('Y-m-d', Civi::settings()->get('specific_membership_end_date'));
	}
  // Return the date in the same format it was received
  return $new_end_date->format($date_format);
}

function membershiputils_civicrm_pre($op, $objectName, $id, &$params) {
  // If the Membership is being created or edited and the end date has been set then adjust
  // Skip when 'null' is set as the end_date as this indicates a Lifetime membership term with on end date
  if (('Membership' == $objectName) && ('edit' == $op || 'create' == $op) && $params['end_date'] && 'null' !== $params['end_date']) {
    if (Civi::settings()->get('adjust_membership_end_date') || Civi::settings()->get('use_specific_membership_end_date')) {
      // This is where CiviCRM may pass in the end date in two different formats
      $params['end_date'] = membershiputils_adjustmembershipenddate($params['end_date']);
    }
  }
}

function membershiputils_civicrm_post($op, $objectName, $id, &$params) {
  // This function is required to work around weirdness in CiviCRM which sometimes does not set the membership dates, they may be NULL
  if ('Membership' == $objectName && 'create' == $op) {

    if (Civi::settings()->get('adjust_membership_end_date') || Civi::settings()->get('use_specific_membership_end_date')) {
      // If end date has been set then do not try to calculate it now
      if (!$params->end_date) {
        $dates = CRM_Member_BAO_MembershipType::getDatesForMembershipType($params->membership_type_id, NULL, NULL, NULL);

        CRM_Core_DAO::setFieldValue('CRM_Member_DAO_Membership', $id, 'join_date', $dates['join_date'], 'id');
        CRM_Core_DAO::setFieldValue('CRM_Member_DAO_Membership', $id, 'start_date', $dates['start_date'], 'id');
        CRM_Core_DAO::setFieldValue('CRM_Member_DAO_Membership', $id, 'end_date', $dates['end_date'], 'id');
      }
    }
  }
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function membershiputils_civicrm_navigationMenu(&$menu) {
  _membershiputils_civix_insert_navigation_menu($menu, 'Administer', [
    'label' => E::ts('Membership Utils Settings'),
    'name' => 'membershiputils_settings',
    'url' => 'civicrm/admin/setting/membershiputils',
    'permission' => 'administer CiviCRM',
    'operator' => 'OR',
    'separator' => 0,
  ]);
  _membershiputils_civix_navigationMenu($menu);
}
