//      Andy Kolb           
//      Smart Home Simulator      
//      settings.js          
//      10/16/2022          

//  Initialize devices array
let devices = [];
let devicesJSON = localStorage.getItem('devices');
if(devicesJSON != null) devices = JSON.parse(devicesJSON);

console.log(JSON.parse(devicesJSON));

//  Settings variables
let deviceSelect = document.getElementById("deviceSelect");
let startTime = document.getElementById('startTime');
let endTime = document.getElementById('endTime');


//  Save settings to devices array and localStorage
function saveSettings() {

    if(deviceSelect.value && startTime.value && endTime.value) {

        let exists = false, index;
        devices.forEach(function(item, i) {
            if(deviceSelect.value===item.device) {
                exists = true;
                index = i;
            }
        });

        if(exists) {
            // Alter times for existing device
            devices[index].starttime = startTime.value;
            devices[index].endtime = endTime.value;       
            alert(devices[index].device + ' schedule has been updated.');
        } else {
            // Add new device to array
            let newDevice = {
                device: deviceSelect.value,
                starttime: startTime.value,
                endtime: endTime.value,
            };
            devices.push(newDevice);
            alert(deviceSelect.value + ' has been been added to the schedule.');
        }

        saveLocalStorage();
        clearForm();

    } else {
        alert('All fields required to add a device.');
    }

}

//  Remove selected device from device array and localStorage
function removeDevice() {
    let newArr = [];
    if(!deviceSelect.value) { alert('No device has been selected.'); return; }
    devices.forEach(function(item, i) {
        if(deviceSelect.value != item.device) {
            newArr.push(item);
        }
    });
    devices = newArr;
    alert(deviceSelect.value + ' has been removed from the schedule.');
    saveLocalStorage();
    clearForm();
}


// Convert device array to JSON and add to localStorage
function saveLocalStorage() {    
    let json = JSON.stringify(devices);
    localStorage.setItem('devices', json);
}


//  Clear all devices from device array and localStorage
function clearDevices() {
    if (confirm("Are you sure you want to clear all devices?") == true) {
        devices = [];
        localStorage.clear();
        clearForm();
    }
}


//  Clears form fields
function clearForm() {
    deviceSelect.value = '';
    startTime.value = '';
    endTime.value = '';
}


//  Device Select Onchange
//  Loads saved times for device
deviceSelect.onchange = function() {
    let d = this.value;
    startTime.value = "";
    endTime.value = "";
    devices.forEach(function(item, i) {
        if(item.device===d) {
            startTime.value = item.starttime;
            endTime.value = item.endtime;
        }
    });
};