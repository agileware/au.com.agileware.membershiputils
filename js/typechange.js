'use strict';

const membershipFeeSection = document.querySelector('.crm-section.membership_fee-section');

/**
 * Change handler for price fields.
 *
 * @param target {HTMLInputElement}
 */
const feeSelectionChange = async function({target}) {
	if(target.type?.toLowerCase() !== 'radio') {
		return;
	}
	const { defaultChecked, value, form, name } = target;

	if ( defaultChecked ) {
		return;
	}

	const priceFieldValues = Object.values(JSON.parse(target.dataset.priceFieldValues));

	const defaultValue = Array.from(form[name]).filter(({defaultChecked}) => defaultChecked).shift().value;

	const defaultOption = priceFieldValues.filter(({id}) => id == defaultValue).shift();
	const thisOption = priceFieldValues.filter(({id}) => id == value).shift();

	debugger;
};

membershipFeeSection.addEventListener('change', feeSelectionChange);
