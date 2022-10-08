//      Andy Kolb           
//      Activities Selector      
//      activities.js          
//      09/29/2022          

let destinations = document.getElementById('destinations');
let activities = document.getElementById('activities');

let newzealand = ['City Tours','Sports','Cycling','Museums','Boating'];
let maldives = ['Museums','Sailing','Beach','Hiking','Boating'];
let venice = ['Museums','Theatre','Parks and Recreation','City Tours'];
let cancun = ['Parks and Recreation','Beaches','Boating','Snorkeling'];

destinations.onchange = function() {
    let d = this.value;
    let html = '';

    switch(this.value) {
        case 'newzealand':
            html = buildCheckboxes(newzealand);
            break;
        case 'maldives':
            html = buildCheckboxes(maldives);
            break;
        case 'venice':
            html = buildCheckboxes(venice);
            break;
        case 'cancun':
            html = buildCheckboxes(cancun);
            break;
    }

    activities.innerHTML = html;

}

function buildCheckboxes(arr) {
    let html = '<div style="margin-bottom:5px;">Activities</div>';

    arr.forEach(function(item, i) {
        let n = i + 1;
        html += '<input type="checkbox" id="activity' + n + '" value="' + item + '">';
        html += '<label for="activity' + n + '"> ' + item + '</label><br>';
    });

    return html;
}