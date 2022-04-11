# Membership Utils

[Membership Utils](https://github.com/agileware/au.com.agileware.membershiputils) is a CiviCRM extension providing some useful functions to help manage memberships in [CiviCRM](https://civicrm.org), including:
1. Membership Statuses: 'Duplicate' and 'Not Renewing'
2. Scheduled Job, `Find Duplicate Memberships` which finds duplicate Memberships and sets the status to 'Duplicate'.

## Duplicate memberships

Duplicate memberships in CiviCRM is a major issue for Membership Managers and the `Find Duplicate Memberships` job alleviates this issue by automatically changing the membership status of duplicate memberships to *Duplicate*. A membership is deemed to be a duplicate if:
1. The membership is of the same membership type
2. The membership is older than the current membership
3. The membership is has a status of Current, Expired or Grace

By changing the membership status to *Duplicate*, this then prevents duplicate Membership Renewal Reminders from being sent to the Contacts, avoiding potential confusion and/or negative feedback to your organisation.

## Not Renewing

The *Not Renewing* membership status is a useful status to assign to a membership when the Contact has provided feedback that they no longer with to be a member.

This is different from the *Cancelled* membership status, which prevents a member from re-joining the organisation.

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