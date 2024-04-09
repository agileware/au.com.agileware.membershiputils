# Membership Utils

[Membership Utils](https://github.com/agileware/au.com.agileware.membershiputils) is a CiviCRM extension providing some useful functions to help manage memberships in [CiviCRM](https://civicrm.org), including:
1. Membership Statuses: 'Duplicate' and 'Not Renewing'
2. Scheduled Job, `Find Duplicate Memberships` which finds duplicate Memberships and sets the status to 'Duplicate'.
3. Feature to automatically adjust the **membership end date** to the **end of the month** when creating or updating a membership. For example: a membership with an end date of 16/04/2022 will be changed to 30/04/2022. This feature is useful if you want to have all membership end dates occur on the last day of the month, rather than the default which is mid-month.
4. Feature to automatically **set the membership end date** to a **specific date** when creating or updating a membership. 
5. Scheduled Job, `Adjust Membership End Date` which sets the membership end date to the end of month.
6. Scheduled Job, `Set specific Membership End Date` which sets the membership end date to a specific date.
 
## Duplicate Memberships

Duplicate memberships in CiviCRM is a major issue for Membership Managers and the `Find Duplicate Memberships` job alleviates this issue by automatically changing the membership status of duplicate memberships to *Duplicate*. A membership is deemed to be a duplicate if:
1. The membership is of the same membership type
2. The membership is older than the current membership
3. The membership has a status of Current, Expired or Grace

By changing the membership status to *Duplicate*, this then prevents duplicate Membership Renewal Reminders from being sent to the Contacts, avoiding potential confusion and/or negative feedback to your organisation.

## Not Renewing

The *Not Renewing* membership status is a useful status to assign to a membership when the Contact has provided feedback that they no longer with to be a member.

This is different from the *Cancelled* membership status, which prevents a member from re-joining the organisation.

## Adjust Membership End Date

This feature is useful if you want to have all membership end dates occur on the last day of the month, rather than the default which is mid-month. For example: a membership with an end date of 16/04/2022 will be changed to 30/04/2022.

This feature can be enabled or disabled on the `CiviCRM > Administer > Membership Utilities Settings` page, `/wp-admin/admin.php?page=CiviCRM&q=civicrm%2Fadmin%2Fsetting%2Fmembershiputils`.

If you have existing memberships that need to be updated, then execute the Scheduled Job, `Adjust Membership End Date` (API:  membershiputils.adjustmembershipenddate). This will update the memberships with a status of either: **New**, **Current** and **Grace**, setting the end date to the end of month.

## Specific Membership End Date

This feature is useful if you want to have all membership end dates occur on a specific date. For example, if your organisation provides membership which have a 3 year term and all memberships must be aligned with that term.

This feature can be enabled or disabled on the `CiviCRM > Administer > Membership Utilities Settings` page, `/wp-admin/admin.php?page=CiviCRM&q=civicrm%2Fadmin%2Fsetting%2Fmembershiputils`.

If you have existing memberships that need to be updated, then execute the Scheduled Job, `Set specific Membership End Date` (API:  membershiputils.Specificmembershipenddate). This will update the memberships with a status of either: **New**, **Current** and **Grace**, setting the end date to the date specified in the settings.

## Notification of Membership Type change

The user can be notified when renewing their Membership if the price option they selected will alter the type of their existing membership.

This feature can be enabled or disabled and the message shown to members can be customised on the `CiviCRM > Administer > Membership Utilities Settings` page, `/wp-admin/admin.php?page=CiviCRM&q=civicrm%2Fadmin%2Fsetting%2Fmembershiputils`.

## Prevent Duplicate Renewal submission

Prevent Contribution pages from being loaded if a member attempts to use one to renew a membership that is not due for renewal or already has a Pending renewal payment.

This feature can be enabled or disabled on the `CiviCRM > Administer > Membership Utilities Settings` page, `/wp-admin/admin.php?page=CiviCRM&q=civicrm%2Fadmin%2Fsetting%2Fmembershiputils`.

Whether a membership is not due for renewal can be customised by changing the filters on the packaged Searchkit Saved Search "Excluded from Renewal" to find members who should not be able to renew.
By default, this search will exclude members whose membership expiry is more than 30 days in the future, or who have a related pending contribution that is less than 30 days old.

# Installation

1. Install and enable this CiviCRM extension like any normal CiviCRM extension.
1. Enable the Scheduled Job, `Find Duplicate Memberships`

# About the Authors

This CiviCRM extension was developed by the team at [Agileware](https://agileware.com.au).

[Agileware](https://agileware.com.au) provide a range of CiviCRM services including:

* CiviCRM migration
* CiviCRM integration
* CiviCRM extension development
* CiviCRM support
* CiviCRM hosting
* CiviCRM remote training services

Support your Australian [CiviCRM](https://civicrm.org) developers, [contact Agileware](https://agileware.com.au/contact) today!

![Agileware](images/agileware-logo.png)