_browser = {};

function detectBrowser() {
    var uagent = navigator.userAgent.toLowerCase();
    var match = '';
    var browser = '';
    var version = '';


    _browser.chrome  = /webkit/.test(uagent)  && /chrome/.test(uagent) && !/edge/.test(uagent);
    _browser.firefox = /mozilla/.test(uagent) && /firefox/.test(uagent);
    _browser.msie    = /msie/.test(uagent) || /trident/.test(uagent);
    _browser.safari  = /safari/.test(uagent)  && /applewebkit/.test(uagent) && !/chrome/.test(uagent);
    //_browser.opr     = /mozilla/.test(uagent) && /applewebkit/.test(uagent) &&  /chrome/.test(uagent) && /safari/.test(uagent) && /opr/.test(uagent);
    _browser.version = '';

    for (x in _browser) {
        if (_browser[x]) {

            // microsoft is "special"
            match = uagent.match(new RegExp("(" + (x === "msie" ? "msie" : x) + ")( |\/)([0-9]+)"));

            if (match) {
                _browser.version = match[3];
            } else {
                match = uagent.match(new RegExp("rv:([0-9]+)"));
                _browser.version = match ? match[1] : "";
            }

            browser = x === "opr" ? "Opera" : x;
            version = _browser.version ? _browser.version : "N/A";

            if (_browser.safari) {
                version = uagent.substr(uagent.indexOf("version/")+8).split(" ")[0];
            }

            if (_browser.safari && version.split(".")[0] < 9 ||
                _browser.chrome && version < 47 ||
                _browser.firefox && version < 45 ) {

                alert("Your browser version is older and which may result in erratic operation.  Please update your browser for the best results.");
            } else if (_browser.msie) {
                alert("Using IE may result in erratic operation.  It is suggested that you use Chrome or Firefox.");
            }

            break;
        }
    }
    _browser.opera = _browser.opr;
    delete _browser.opr;
}
