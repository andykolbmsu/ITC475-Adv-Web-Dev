//      Andy Kolb           
//      Reservation Contact Form      
//      contact.js          
//      10/08/2022         

let submit = document.getElementById('submitBtn');
let clear = document.getElementById('clear');
let form = document.getElementById('contactForm');
let phone = document.getElementById('phone');
let travelerAdults = document.getElementById('travelerAdults');
let travelerChildren = document.getElementById('travelerChildren');
let startDate = document.getElementById('startDate');
let endDate = document.getElementById('endDate');

clear.onclick = function() {
    activities.innerHTML = '';
}

submit.onclick = function() {

    if(!checkForBlanks()) return;

    if(!validateDates()) return;
    
    if(!validateNumeric()) return;
    
    form.submit();
    
}


function checkForBlanks() {
    let error = 0;
    let inputs = document.querySelectorAll('input');
    for(const input of inputs) {
        if(input.value === '') error = 1;
    }
    if(!destinations.value) error = 1;
    if(error) { alert('All fields are required.'); return false; }
    return true;
}

function validateDates() {

    if(!startDate.value) {
        alert('Invalid start date.');
        return false;
    }
    if(!endDate.value) {
        alert('Invalid end date.');
        return false;
    }

    let today = new Date();
    today = today.getFullYear() + 
        '-' + String(today.getMonth() + 1).padStart(2, '0') + 
        '-' + String(today.getDate()).padStart(2, '0');

    if(startDate.value <= today) {
        alert('The start date has already passed.');
        return false;
    }
    if(startDate.value > endDate.value) {
        alert('Invalid end date.');
        return false;
    }

    return true;

}

function validateNumeric() {

    if(/[a-zA-Z]/.test(phone.value) && phone.value.length < 10) {
        alert('Invalid phone number.');
        return false;
    }
    if(/[a-zA-Z]/.test(travelerAdults.value)) {
        alert('Invalid number of adults.');
        return false;
    }
    if(/[a-zA-Z]/.test(travelerChildren.value)) {
        alert('Invalid number of children.');
        return false;
    }

    return true;
}