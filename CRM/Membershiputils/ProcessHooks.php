<?php

use Civi\Api4\PriceFieldValue;
use Civi\Api4\SearchDisplay;
use Civi\Core\Event\GenericHookEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CRM_Membershiputils_ProcessHooks implements EventSubscriberInterface {

  const comparisonSearch = 'Excluded_from_Renewal';

  protected CRM_Contribute_Form_Contribution_Main $form;

  protected array $type_ids;

  public static function getSubscribedEvents(): array {
    return [
      'hook_civicrm_buildForm' => 'buildForm'
    ];
  }

  protected function hasContactRenewed(): bool {
    $contact = $this->form->getContactID();

    $contacts_changed = SearchDisplay::run(FALSE)
                                     ->setSavedSearch(self::comparisonSearch)
                                     ->setFilters([
                                       'contact_id' => $contact,
                                       'membership_type_id' => $this->type_ids
                                       ])
                                     ->execute();

    return (bool) $contacts_changed->count();
  }

  protected function hasMembershipPriceFields(): bool {
    $priceSetID = $this->form->getPriceSetID() ?: 0;

    $this->type_ids = array_unique(array_map(
      fn($pfv) => $pfv['membership_type_id'],
      PriceFieldValue::get(FALSE)
                   ->addSelect('membership_type_id')
                   ->addWhere('price_field_id.price_set_id', '=', $priceSetID)
                   ->addWhere('membership_type_id', 'IS NOT EMPTY')
                   ->execute()
                   ->getArrayCopy()
    ));

    return count($this->type_ids) > 0;
  }

  public function validateForm(GenericHookEvent $event): void {

  }

  public function buildForm(GenericHookEvent $event): void {
    if ( ! $event->form instanceof CRM_Contribute_Form_Contribution_Main ) {
      return;
    }

    $this->form = &$event->form;

    if ( $this->hasMembershipPriceFields() &&
         $this->hasContactRenewed() ) {
      CRM_Core_Error::statusBounce('A renewal has already been submitted for your Membership');
    }
  }
}
