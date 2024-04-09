<?php

use CRM_Membershiputils_ExtensionUtil as E;

use Civi\Core\Event\GenericHookEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CRM_Membershiputils_ResourceHooks implements EventSubscriberInterface {

  /**
   * Returns an array of events this subscriber wants to listen to.
   *
   * @return array
   */
  public static function getSubscribedEvents() {
    return [
      'hook_civicrm_pageRun' => 'pageRun',
      'hook_civicrm_buildForm' => 'buildForm',
    ];
  }

  private function addTypeChangeResources() {
    Civi::resources()->addVars('membershipUtils', [
      'typeChangeMessage' => Civi::settings()->get('membershiputils_type_change_message'),
      'typeChangeNotification' => Civi::settings()->get('membershiputils_type_change_notification'),
    ]);

    Civi::resources()->addScriptFile(E::LONG_NAME, 'js/typechange.js');
  }

  public function pageRun(GenericHookEvent $event) {
    if ($event->page instanceof CRM_Contribute_Page_ContributionPage) {
      $this->addTypeChangeResources();
    }
  }

  public function buildForm(GenericHookEvent $event) {
    if ($event->form instanceof CRM_Contribute_Form_Contribution_Main) {
      $this->addTypeChangeResources();
    }
  }

}
