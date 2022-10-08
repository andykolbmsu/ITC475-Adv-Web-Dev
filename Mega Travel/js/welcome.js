//      Andy Kolb           
//      The Welcome Component      
//      welcome.js          
//      09/03/2022         

let now = new Date();
let welcomeGreeting = document.getElementById('welcomeGreeting');
let welcomeTime = document.getElementById('welcomeTime');

//  Initial 
welcomeGreeting.innerHTML = getWelcomeMessage(now);
welcomeTime.innerHTML = getWelcomeIcon(now) + ' ' + getWelcomeTime(now);

//  Start timer
setInterval(timer, 1000);

function timer() {
    now = new Date();
    welcomeGreeting.innerHTML = getWelcomeMessage(now);
    welcomeTime.innerHTML = getWelcomeIcon(now) + ' ' + getWelcomeTime(now);
}

//  Update icon
function getWelcomeIcon(date) {
    let hours = date.getHours();
    let min = date.getMinutes();

    if(hours < 6) {
        return '<i class="fa-solid fa-moon"></i>';
    } else if(hours < 18) {
        return '<i class="fa-solid fa-sun"></i>';
    } else {
        return '<i class="fa-solid fa-moon"></i>';
    }
}

//  Update welcome message
function getWelcomeMessage(date) {
    if(date.getHours() < 12) {
        return 'Good Morning'
    } else if(date.getHours() < 18) {
        return 'Good Afternoon'
    } else {
        return 'Good Evening'
    }
}

//  Update time
function getWelcomeTime(date) {
    let hour, min, ampm;

    if(date.getHours() <= 11) {
        hour = date.getHours();
        ampm = 'AM';
    } else {
        hour = date.getHours() - 12;
        ampm = 'PM';
    }
    if(hour==0) { hour = 12; }

    min  = date.getMinutes();
    if(min < 10) { min = '0' + min; }

    return hour + ':' + min + ' ' + ampm;
}