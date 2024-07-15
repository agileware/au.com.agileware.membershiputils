<?php

use Civi\Api4\Membership;

/**
 * Job.Specificmembershipenddate API
 *
 * Scheduled job which will bulk adjust the membership end date for all
 * membership, setting the end date to the end of month
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 * @see civicrm_api3_create_success
 *
 */
function civicrm_api3_membershiputils_Specificmembershipenddate($params): array {
  try {
    // If this option is enabled then action, otherwise skip
    if (Civi::settings()->get('use_specific_membership_end_date')) {
      $new_end_date = date_create_from_format('Y-m-d', Civi::settings()
          ->get('specific_membership_end_date'));

      // Get all memberships
      // Note: This intentionally updates both Primary and Non-primary memberships because CiviCRM has a long history of bugs when it comes to correctly inheriting changes from Primary to non-primary memberships
      \Civi\Api4\Membership::update(TRUE)
        ->addValue('end_date', $new_end_date->format('Y-m-d'))
        ->addWhere('status_id:name', 'IN', [
          'New',
          'Current'])
        ->addWhere('end_date', '!=', $new_end_date->format('Y-m-d'))
        ->execute();

      return civicrm_api3_create_success(TRUE, $params, 'membershiputils', 'Specificmembershipenddate');
    }
  }
  catch (Exception $e) {
    throw new CRM_Core_Exception('Error setting specific membership end date. Error: ' . $e->getMessage());
  }
}
