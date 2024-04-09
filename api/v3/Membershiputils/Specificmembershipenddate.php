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
      // Get all memberships
      $memberships = Membership::get()
        ->addSelect('id', 'end_date')
        ->addWhere('status_id:name', 'IN', [
          'New',
          'Current',
          'Grace',
        ])
        ->execute()->getArrayCopy();
      foreach ($memberships as $membership) {
        // Set a specific end date
        $new_end_date = date_create_from_format('Y-m-d', Civi::settings()
          ->get('specific_membership_end_date'));

        // Update the membership
        Membership::update()
          ->addValue('end_date', $new_end_date->format('Y-m-d'))
          ->addWhere('id', '=', $membership['id'])
          ->execute();
      }

      return civicrm_api3_create_success(TRUE, $params, 'membershiputils', 'Specificmembershipenddate');
    }
  }
  catch (Exception $e) {
    throw new CRM_Core_Exception('Error setting specific membership end date. Error: ' . $e->getMessage());
  }
}
