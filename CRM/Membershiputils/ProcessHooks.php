<?php

use Civi\Api4\PriceFieldValue;
use Civi\Api4\SavedSearch;
use Civi\Api4\SearchDisplay;
use Civi\Core\Event\GenericHookEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use CRM_Membershiputils_ExtensionUtil as E;

class CRM_Membershiputils_ProcessHooks implements EventSubscriberInterface {

  const comparisonSearch = 'Excluded_from_Renewal';

  protected CRM_Core_Form $form;

  protected array $type_ids;

  public static function getSubscribedEvents(): array {
    return [
      'hook_civicrm_buildForm' => 'buildForm',
    ];
  }

  protected function hasContactRenewed() {
    $contact = $this->form->getContactID();

    $contacts_changed = SearchDisplay::run(FALSE)
      ->setSavedSearch(self::comparisonSearch)
      ->setFilters([
        'contact_id' => $contact,
        'membership_type_id' => $this->type_ids,
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

  public function validateForm(GenericHookEvent $event): void {}

  public function buildForm(GenericHookEvent $event): void {
    $this->form = &$event->form;

    if ($this->form instanceof CRM_Contribute_Form_Contribution_Main
      && Civi::settings()->get('membershiputils_prevent_double_renewal')) {
      $this->buildForm_Contribute_Form_Contribution_main($event);
    }
    elseif ($this->form instanceof CRM_Admin_Form_Generic) {
      $this->buildForm_Admin_Form_Generic($event);
    }
  }

  public function buildForm_Contribute_Form_Contribution_main(GenericHookEvent $event): void {
    if (!$this->hasMembershipPriceFields()) {
      return;
    }

    $type = $this->hasContactRenewed();

    if (!$type) {
      return;
    }

    if (is_array($type)) {
      $type = $type[0];
    }

    throw new CRM_Core_Exception(E::ts(
      'A renewal has already been submitted for your %1 Membership',
      [1 => is_string($type) ? "<em>$type</em>" : '']
    ));
  }

  public function buildForm_Admin_Form_Generic(GenericHookEvent $event): void {
    if (!$this->form->elementExists('membershiputils_prevent_double_renewal')) {
      return;
    }

    $field_prevent_double_renewal = $this->form->getElement('membershiputils_prevent_double_renewal');

    $field_prevent_double_renewal->setComment(
      E::ts('When enabled, prevents Contribution Pages from loading that include Membership renewal if the using contact has a membership of one of the included types that has already been renewed. You can customise how it is determined that memberships have already been used by changing the parameters of the <a href="%1">Saved Search, "%2"</a>',
        $this->search_admin_params())
    );
  }

  private function search_admin_params() {
    try {
      $excluded_from_renewal_search = SavedSearch::get(FALSE)
        ->addWhere('name', '=', 'Excluded_from_Renewal')
        ->addSelect('id', 'label')
        ->execute();

      if ($excluded_from_renewal_search->count()) {
        $excluded_from_renewal_search = $excluded_from_renewal_search->first();
        return [
          1 => CRM_Utils_System::url(
            'civicrm/admin/search',
            '',
            FALSE,
            '/edit/' . $excluded_from_renewal_search['id'],
            TRUE,
            FALSE,
            TRUE
          ),
          2 => $excluded_from_renewal_search['label'],
        ];
      }
    }
    catch (Exception $e) {
    }

    return [
      1 => CRM_Utils_System::url(
        'civicrm/admin/search',
        '',
        FALSE,
        '/list?tab=packaged',
        TRUE,
        FALSE,
        TRUE
      ),
      2 => E::ts('Excluded from Renewal'),
    ];
  }

}
