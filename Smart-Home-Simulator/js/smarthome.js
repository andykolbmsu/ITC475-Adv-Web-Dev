//      Andy Kolb           
//      Smart Home Simulator      
//      smarthome.js          
//      10/16/2022          

//  Initialize devices array
let devices = [];
let devicesJSON = localStorage.getItem('devices');
if(devicesJSON != null) devices = JSON.parse(devicesJSON);

//  Smart home variables
let status = false;
let runBtn = document.getElementById('runBtn');
let scheduleContainer = document.getElementById('schedule-container');
let floorplanContainer = document.getElementById('floorplan-container');


initialize();

function initialize() {
    displayCurrentTime(formatTime(getCurrentTime()));
    displayStatus();
    displaySchedule();
    //  Start timer
    setInterval(timer, 1000);
}


//  Timer
function timer() {
    let current = getCurrentTime();
    displayCurrentTime(formatTime(current));
    if(status) { on(); }
}


//  Simulator on
function on() {

    off();
    devices.forEach(function(item, i) {
        let n = i + 1;
        let current = getCurrentTime();

        let starttime = item.starttime;
        let endtime = item.endtime;
        
        if(starttime > endtime) {
            console.log(starttime + ' ' + endtime + ' ' + current)
            if(starttime <= current || current < endtime) {
                document.getElementById('token' + n).classList.add('simulatorOn');
                document.getElementById('deviceRow' + n).classList.add('simulatorOn');    
            }
        } else {
            if(starttime <= current && endtime > current) {
                document.getElementById('token' + n).classList.add('simulatorOn');
                document.getElementById('deviceRow' + n).classList.add('simulatorOn');    
            }    
        }
    });

}


//  Simulator off
function off(i) {
    let deviceRows = document.getElementsByClassName('deviceRow');
    let tokens = document.getElementsByClassName('token');

    for(let i = 0; i < deviceRows.length; i++) {
        deviceRows[i].classList.remove('simulatorOn');
        tokens[i].classList.remove('simulatorOn');
    }
}


//  Display simulator status
function displayStatus() {
    let str;
    if(status) {
        str = '<span style="color:var(--green)">Running</span>';
    } else {
        str = '<span style="color:red;">Off</span>';
    }
    document.getElementById('status').innerHTML = '<strong>Status:</strong> ' + str;
}


//  Toggle simulator status
function toggleStatus() {
    if(status) {
        status = false;
        runBtn.classList.remove('runBtnOn');
        off();
    } else {
        status = true;
        runBtn.classList.add('runBtnOn');
        on();
    }
    displayStatus();
}


//  Get current time    HH:MM
function getCurrentTime() {
    let now = new Date();
    let h = ('0' + now.getHours()).slice(-2);
    let m = ('0' + now.getMinutes()).slice(-2);
    return h + ':' + m;
}


//  Format HH:MM to AM/PM
function formatTime(time) {
    let t = time.split(':');
    let h = t[0];
    let m = t[1];
    let ampm;

    if(h < 12) { ampm = 'AM'; }
        else { ampm = 'PM'; }
    if(h > 12) { h = h - 12; }
    if(h == '00') { h = 12; }


    return parseInt(h) + ':' + m + ' ' + ampm;
}


//  Display current time
function displayCurrentTime(time) {
    document.getElementById('current-time').innerHTML = time;
}


//  Display schedule
function displaySchedule() {

    let html = '<table id="schedule-table">';
    let n, pos;
    html += '<thead><tr>'
        + '<th></th><th>Device</th>'
        + '<th>Start time</th><th>End time</th>'
        + '</tr></thead>';
    devices.forEach(function(item, i) {
        n = i + 1;
        html += '<tr id="deviceRow' + n + '" class="deviceRow">'
            + '<td>' + n + '</td>'
            + '<td>' + item.device + '</td>'
            + '<td>' + formatTime(item.starttime) + '</td>'
            + '<td>' + formatTime(item.endtime) + '</td>'
            + '<tr>';
        //  Get token position and display on floorplan
        pos = getTokenPosition(item.device);
        if(pos) {

            floorplanContainer.innerHTML += '<div id="token' + n + '" class="token" style="' + pos + '">' + n + '</div>';
        }
    });
    html += '</table>';

    scheduleContainer.innerHTML = html;
}


//  Returns floorplan position for device
function getTokenPosition(device) {
    switch(device) {
        case 'Living Room Lamp':
            return 'bottom:40%;left:30%;'; break;
        case 'Bedroom #1 Desk Lamp':
            return 'top:17%;left:44%;'; break;
        case 'Bedroom #2 Floor Lamp':
            return 'bottom:28%;left:5%;'; break;
        case 'Bathroom Fan':
            return 'bottom:50%;left:11%;'; break;
        case 'Washer':
            return 'top:39%;right:25%;'; break;
        case 'Dryer':
            return 'top:39%;right:20%;'; break;
        case 'Front Door':
            return 'bottom:26%;right:39%;'; break;
        case 'Back Door':
            return 'top:21%;left:20%;'; break;
        case 'Garage Door':
            return 'top:20%;right:5%;'; break;
        case 'Kitchen Fan':
            return 'bottom:37%;right:26%;'; break;
        case 'Dining Room Light':
            return 'bottom:20%;right:9%;'; break;
        default:
            return false;
    }
}