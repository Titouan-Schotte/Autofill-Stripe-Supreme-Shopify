window.onload = function () {
    IsConnected()
}
setInterval(IsConnected(), 2000)

function IsConnected(){
    var conn = localStorage.getItem('connect')
    if(conn == 1){
        chrome.storage.sync.set({discord: 1}, function() {console.log('SET Key = discord Value = '+true);});
    } else {
        chrome.storage.sync.set({discord: 0}, function() {console.log('SET Key  = discord Value = '+false);});
    }
}