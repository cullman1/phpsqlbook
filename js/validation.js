(function() {
document.forms.register.noValidate = true;
$('#form1').on('submit', function(e) {
	alert("yo");
	var elements = this.elements;
	var valid = {};
	var isValid;
	var isFormValid;
	
	for (var i=0,l=(elements.length-1);i<l;i++) {
		isValid= validateRequired(elements[i]) && validateTypes(elements[i]);
		if (!isValid) {
			showErrorMessage(elements[i]);
		} 
		else {
			removeErrorMessage(elements[i]);
		}
		valid[elements[i].id] = isValid;
	}
	
	for (var field in valid) {
		if(!valid[field]) {
			isFormValid = false;
			break;
		}
		isFormValid = true;		
	}

	if(!isFormValid) {
		e.preventDefault();
	}
});


function validateRequired(el) {
	if(isRequired(el)) { 
		var valid = !isEmpty(el);
		if (!valid) {
			setErrorMessage (el, 'Field is required');
		}
		return valid;
	}
	return true;
	}

function isRequired(el) {
return ((typeof el.required === 'boolean') && el.required) || 
(typeof el.required === 'string');
}

function isEmpty(el) {
	return !el.Value || el.value === el.placeholder;
}

function setErrorMessage(el, message) {
	$(el).data('errorMessage', message)
	}

function showErrorMessage(el) {
	var $el = $(el)
	var $errorContainer = $el.siblings('.error');
	if ($errorContainer.length) {
		$errorContainer = $('<span class="error"></span>').insertAfter($el);
		}
		$errorContainer.text($(el).data('errorMessage'));
	}
}());