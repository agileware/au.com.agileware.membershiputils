<?php

use Civi\Api4\Membership;

/**
 * Job.Adjustmembershipenddate API
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
function civicrm_api3_membershiputils_Adjustmembershipenddate($params): array {
  try {
    // If this option is enabled then action, otherwise skip
    if (Civi::settings()->get('adjust_membership_end_date')) {
      // Get all memberships
      // Note: This intentionally updates both Primary and Non-primary memberships because CiviCRM has a long history of bugs when it comes to correctly inheriting changes from Primary to non-primary memberships
      $memberships = Membership::get()
        ->addSelect('id', 'end_date')
        ->addWhere('status_id:name', 'IN', [
          'New',
          'Current',
          'Grace',
        ])
        ->execute()->getArrayCopy();
      foreach ($memberships as $membership) {
        // Calculate the end of month date for the membership
        $end_date = date_create($membership['end_date']);
        $start_month = date_create($end_date->format('Y-m') . '-01');
        $new_end_date = date_modify($start_month, '+1 month -1 day');

        if ( $end_date != $new_end_date ) {
          // Update the membership
          Membership::update()
            ->addValue('end_date', $new_end_date->format('Y-m-d'))
            ->addWhere('id', '=', $membership['id'])
            ->execute();
        }
      }

      return civicrm_api3_create_success(TRUE, $params, 'membershiputils', 'Adjustmembershipenddate');
    }
  }
  catch (Exception $e) {
    throw new CRM_Core_Exception('Error updating adjusting membership end date. Error: ' . $e->getMessage());
  }
}
