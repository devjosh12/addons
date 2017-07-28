export function fireEvent(element, eventName, options) {
    var event;
    if (window.CustomEvent) {
        event = new CustomEvent(eventName, options);
    } else {
        event = document.createEvent("CustomEvent");
        event.initCustomEvent(eventName, true, true, options);
    }
    element.dispatchEvent(event);
}

export function toggleScroll() {
    if ($("body")[0].style.overflow) {
        enableScroll();
    } else {
        disableScroll();
    }
}

export function disableScroll() {
    $("body").addClass("NoScroll");
}

export function enableScroll() {
    $("body").removeClass("NoScroll");
}

/**
 * Provides requestAnimationFrame in a cross browser way.
 */

if (!window.requestAnimationFrame) {
    window.requestAnimationFrame = (function() {
        return (
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.oRequestAnimationFrame ||
            window.msRequestAnimationFrame ||
            function(
                /* function FrameRequestCallback */ callback,
                /* DOMElement Element */ element
            ) {
                window.setTimeout(callback, 1000 / 60);
            }
        );
    })();
}
