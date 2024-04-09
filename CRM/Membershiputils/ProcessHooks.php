<?php

use Civi\Api4\PriceFieldValue;
use Civi\Api4\SearchDisplay;
use Civi\Core\Event\GenericHookEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use CRM_Membershiputils_ExtensionUtil as E;

class CRM_Membershiputils_ProcessHooks implements EventSubscriberInterface {

  const comparisonSearch = 'Excluded_from_Renewal';

  protected CRM_Contribute_Form_Contribution_Main $form;

  protected array $type_ids;

  public static function getSubscribedEvents(): array {
    return [
      'hook_civicrm_buildForm' => 'buildForm'
    ];
  }

  protected function hasContactRenewed() {
    $contact = $this->form->getContactID();

    $contacts_changed = SearchDisplay::run(FALSE)
                                     ->setSavedSearch(self::comparisonSearch)
                                     ->setFilters([
                                       'contact_id' => $contact,
                                       'membership_type_id' => $this->type_ids
                                       ])
                                     ->execute();

    return $contacts_changed->count()
      ? ($contacts_changed->first()['data']['membership_type_id:label'] ?? TRUE)
      : FALSE;
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

    if (! $this->hasMembershipPriceFields()) {
      return;
    }

    $type = $this->hasContactRenewed();

    if (! $type) {
      return;
    }

    if(is_array($type)) {
      $type = $type[0];
    }

    throw new CRM_Core_Exception(E::ts(
      'A renewal has already been submitted for your %1 Membership',
      [ 1 => is_string($type) ? "<em>$type</em>" : '' ]
    ));
  }
}
