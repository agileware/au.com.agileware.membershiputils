<?php

/**
 * Membershiputils.Findduplicatememberships API
 *
 *
 * @return array
 *   API result descriptor
 *
 * @throws \CRM_Core_Exception
 *
 * @see civicrm_api3_create_success
 */
function civicrm_api3_membershiputils_Findduplicatememberships(): array {
  /* Example query to locate duplicate memberships
     SELECT `duplicate`.*, `current`.`id` `current_id`, `current`.`status_id` `current_status_id`, `current`.`join_date` `current_join_date`, `current`.`start_date` `current_start_date`, `current`.`end_date` `current_end_date`
       FROM civicrm_membership `duplicate` INNER JOIN civicrm_membership `current`
         ON `duplicate`.`id` <> `current`.`id` AND `duplicate`.`membership_type_id` = `current`.`membership_type_id` and `duplicate`.`contact_id` = `current`.`contact_id`
      WHERE `duplicate`.`end_date` < `current`.`end_date` and `duplicate`.`status_id` = [Current, Grace or Expired]
   */

  // Mark any memberships which are Current, Expired or Grace and have an End Date less than a Current membership end date as a Duplicate

  $duplicateStatusId = array_search('Duplicate', CRM_Member_PseudoConstant::membershipStatus());
  $currentStatusId = array_search('Current', CRM_Member_PseudoConstant::membershipStatus());
  $expiredStatusId = array_search('Expired', CRM_Member_PseudoConstant::membershipStatus());
  $graceStatusId = array_search('Grace', CRM_Member_PseudoConstant::membershipStatus());

  try {
    CRM_Core_DAO::executeQuery("UPDATE civicrm_membership as `duplicate` INNER JOIN civicrm_membership as `current` ON `duplicate`.`id` <> `current`.`id` AND `duplicate`.`membership_type_id`=`current`.`membership_type_id` AND `duplicate`.`contact_id`=`current`.`contact_id` SET `duplicate`.`status_id`=%1, `duplicate`.`is_override`=1 WHERE `duplicate`.`end_date` < `current`.`end_date` AND `duplicate`.`status_id` IN (%2,%3,%4) AND `duplicate`.`owner_membership_id` IS NULL", [
      1 => [$duplicateStatusId, 'Integer'],
      2 => [$currentStatusId, 'Integer'],
      3 => [$expiredStatusId, 'Integer'],
      4 => [$graceStatusId, 'Integer'],
    ]);

    return civicrm_api3_create_success(TRUE, $params, 'membershiputils', 'Findduplicatememberships');
  }
  catch (Exception $e) {
    throw new CRM_Core_Exception('Error marking memberships as duplicate. Error: ' . $e->getMessage());
  }
}
