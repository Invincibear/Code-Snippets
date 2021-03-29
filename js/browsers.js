// Detecting browsers by ducktyping
// Uses ES5 to detect older browsers
function detectBrowser() {
    // Chrome 1 - 71
    var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);

    // Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';
    
    // Internet Explorer 6-11
    var isIE = /*@cc_on!@*/false || !!document.documentMode;
    
    // Edge 20+
    var isEdge = !isIE && !!window.StyleMedia;

    // Opera 8.0+
    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    
    // Safari 3.0+ "[object HTMLElementConstructor]" 
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
    
    // Blink engine detection
    var isBlink = (isChrome || isOpera) && !!window.CSS;

    return {
        isBlink:    isBlink,
        isEdge:     isEdge,
        isFirefox:  isFirefox,
        isIE:       isIE,
        isOpera:    isOpera,
        isSafari:   isSafari
    };
}