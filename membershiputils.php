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
      'run_frequency' => 'Always',
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

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function membershiputils_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function membershiputils_civicrm_navigationMenu(&$menu) {
//  _membershiputils_civix_insert_navigation_menu($menu, 'Mailings', array(
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ));
//  _membershiputils_civix_navigationMenu($menu);
//}
