(function (ts) {
  'use strict';

  const membershipFeeSection = document.querySelector('.crm-section.membership_fee-section');

  const { typeChangeMessage, typeChangeNotification } = CRM.vars.membershipUtils;

  /** @var {HTMLElement[]} **/
  let messageEl = [];

  const hideMessage = async function (name) {
    if (name in messageEl) {
      const el = messageEl[name];
      const h = el.offsetHeight;

      await el.animate({
          opacity: [1, 0],
          clipPath: [`inset(0 0 0 0)`, `inset(${h}px 0 0 0)`],
          marginTop: ['0', `-${h}px`],
        },
        {
          duration: 250,
          fill: 'both',
        }).finished;

      el.remove();
    }
  };

  /**
   * @param element {HTMLElement}
   * @param name {string}
   * @param from {string}
   * @param to {string}
   */
  const showMessage = async function (element, name, from, to) {
    const message = ts(typeChangeMessage, { 1: from, 2: to });

    hideMessage(name);

    /** @var {HTMLTemplateElement} **/
    const template = document.createElement('template');

    template.innerHTML = `<div class="crm-inline-error crm-error alert-warning">${message}</div>`;

    const el = messageEl[name] = template.content.firstChild;

    element.append(el);

    const h = el.offsetHeight;

    el.animate({
        opacity: [0, 1],
        clipPath: [`inset(${h}px 0 0 0)`, `inset(0 0 0 0)`],
        marginTop: [`-${h}px`, '0'],
      },
      {
        duration: 250,
        fill: 'both',
      });
  };

  /**
   * Change handler for price fields.
   *
   * @param target {HTMLInputElement}
   */
  const feeSelectionChange = async function ({ target }) {
    if (target.type?.toLowerCase() !== 'radio') {
      return;
    }
    const { defaultChecked, value, form, name } = target;

    const priceFieldValues = Object.values(JSON.parse(target.dataset.priceFieldValues));

    // Skip if price field does not include memberships
    if (!priceFieldValues.some(({ membership_type_id }) => membership_type_id)) {
      return;
    }

    if (defaultChecked) {
      return hideMessage(name);
    }

    const defaultValue = Array.from(form[name]).filter(({ defaultChecked }) => defaultChecked).shift().value;

    const defaultOption = priceFieldValues.filter(({ id }) => id == defaultValue).shift();
    const thisOption = priceFieldValues.filter(({ id }) => id == value).shift();

    if (thisOption.membership_type_id === defaultOption.membership_type_id) {
      return hideMessage(name);
    }

    showMessage(target.closest('.price-set-row') ?? this, name, defaultOption['membership_type_id.name'], thisOption['membership_type_id.name']);
  };

  if (typeChangeNotification) {
    membershipFeeSection.addEventListener('change', feeSelectionChange);
  }
})(CRM.ts('au.com.agileware.membershiputils'));
