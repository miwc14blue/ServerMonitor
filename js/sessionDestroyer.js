    var IDLE_TIMEOUT = 1;  // 1 seconds of inactivity
    var secondsCounter = 0;
    document.onclick = function() {
        secondsCounter = 0;
    };
    document.onmousemove = function() {
        secondsCounter = 0;
    };
    document.onkeypress = function() {
        secondsCounter = 0;
    };
    window.setInterval(CheckIdleTime, 1800000); // 1800 seconden = 30 minuten
    function CheckIdleTime() {
        secondsCounter++;
        var oPanel = document.getElementById("");
        if (oPanel)
            oPanel.innerHTML = (IDLE_TIMEOUT - secondsCounter) + "";
        if (secondsCounter >= IDLE_TIMEOUT) {
            // redirect to logout.php 
            document.location.href = "../API/logout.php";
        }
    }
