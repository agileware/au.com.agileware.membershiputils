<?php

use Civi\Api4\Membership;
use CRM_Membershiputils_ExtensionUtil as E;

/**
 * Job.Adjustmembershipenddate API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_job_Adjustmembershipenddate_spec(&$spec) {
}

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
function civicrm_api3_job_Adjustmembershipenddate($params) {
  try {
    // Get all memberships
    $memberships = Membership::get()
      ->addSelect('id', 'end_date')
      ->execute()->getArrayCopy();
    foreach ($memberships as $membership) {
      // Calculate the end of month date for the membership
      $end_date = date_create($membership['end_date']);
      $start_month = date_create($end_date->format('Y-m') . '-01');
      $new_end_date = date_modify($start_month, '+1 month -1 day');

      // Update the membership
      Membership::update()
        ->addValue('end_date', $new_end_date->format('Y-m-d'))
        ->addWhere('id', '=', $membership['id'])
        ->execute();
    }
    return civicrm_api3_create_success(TRUE, $params, 'membershiputils', 'Adjustmembershipenddate');
  }
  catch (Exception $e) {
    throw new CRM_Core_Exception('Error updating adjusting membership end date. Error: ' . $e->getMessage());
  }
}
