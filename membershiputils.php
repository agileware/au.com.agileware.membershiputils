<?php

require_once 'membershiputils.civix.php';

// phpcs:disable
use CRM_Membershiputils_ExtensionUtil as E;

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
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function membershiputils_civicrm_xmlMenu(&$files) {
  _membershiputils_civix_civicrm_xmlMenu($files);
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
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function membershiputils_civicrm_postInstall() {
  _membershiputils_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function membershiputils_civicrm_uninstall() {
  _membershiputils_civix_civicrm_uninstall();
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
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function membershiputils_civicrm_disable() {
  _membershiputils_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function membershiputils_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _membershiputils_civix_civicrm_upgrade($op, $queue);
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
    'update' => 'never',
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
    'params' => [
      'version' => 3,
      'name' => 'Adjust Membership End Date',
      'description' => 'Bulk update the membership end date for all membership, setting the end date to the end of month.',
      'api_entity' => 'membershiputils',
      'api_action' => 'Adjustmembershipenddate',
      'parameters' => '',
      'run_frequency' => 'Daily',
      'is_active' => 0,
    ],
  ];
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function membershiputils_civicrm_caseTypes(&$caseTypes) {
  _membershiputils_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function membershiputils_civicrm_angularModules(&$angularModules) {
  _membershiputils_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function membershiputils_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _membershiputils_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function membershiputils_civicrm_entityTypes(&$entityTypes) {
  _membershiputils_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function membershiputils_civicrm_themes(&$themes) {
  _membershiputils_civix_civicrm_themes($themes);
}

/*
 * Adjust the end date to end of the month
 */

function membershiputils_adjustmembershipenddate($end_date) {
  // Bizarrely, CiviCRM may pass in end_date in either of these two formats
  if (strpos($end_date, '-') == FALSE) {
    $date_format = 'Ymd';
  }
  else {
    $date_format = 'Y-m-d';
  }

  $end_date = date_create_from_format($date_format, $end_date);
  $start_month = date_create($end_date->format('Y-m') . '-01');
  $new_end_date = date_modify($start_month, '+1 month -1 day');

  // Return the date in the same format it was received
  return $new_end_date->format($date_format);
}

function membershiputils_civicrm_pre($op, $objectName, $id, &$params) {
  // If the Membership is being created or edited and the end date has been set then adjust
  if (('Membership' == $objectName) && ('edit' == $op || 'create' == $op) && $params['end_date']) {
    if (Civi::settings()->get('adjust_membership_end_date')) {
      // This is where CiviCRM may pass in the end date in two different formats
      $params['end_date'] = membershiputils_adjustmembershipenddate($params['end_date']);
    }
  }
}

function membershiputils_civicrm_post($op, $objectName, $id, &$params) {
  // This function is required to work around weirdness in CiviCRM which sometimes does not set the membership dates, they may be NULL
  if ('Membership' == $objectName && 'create' == $op) {

    if (Civi::settings()->get('adjust_membership_end_date')) {
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