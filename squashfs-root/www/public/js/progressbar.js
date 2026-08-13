function displayProgressBar(wait, redirect) {
    var totalSeconds = wait;
    var ctr=0;

    window.setInterval(function(){
        ctr++;
        var a=(100/totalSeconds);
        var d=(100/totalSeconds);
        var l= parseFloat(a + (ctr-1)*d).toFixed(2);
        progress(Math.floor(l) , $('#progressBarContainer'));

        if(ctr == totalSeconds) {
            $('#progressBarContainer').hide();
            document.location.href = redirect;
            return true;
        }
    }, 1000);

}


function progress(percent, $element) {
    var progressBarWidth = percent * $element.width() / 100;
    $element.find('div').animate({ width: progressBarWidth }, 500).html(percent + "%&nbsp;");
}

