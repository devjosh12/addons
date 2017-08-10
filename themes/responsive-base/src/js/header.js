import { fireEvent } from "./utility.js";

/**
 * Call this event on the window in order to collapse default collapsing elements.
 *
 * fireEvent(window, EVENT_COLLAPSE_DEFAULTS);
 */
const EVENT_COLLAPSE_DEFAULTS = "vanilla_collapse_defaults";

// Strings to represent the current state in a data-attribute
const STATE_CLOSED = "CLOSED";
const STATE_OPEN = "OPEN";

export function setupHeader() {
    initNavigationDropdown();
    initCategoriesModule();
    initNavigationVisibility();
    fireEvent(window, EVENT_COLLAPSE_DEFAULTS);
}

function initNavigationListeners() {
    const $navigation = $('#navdrawer');
    const className = 'isStuck';

    const setupListener = function setupListener() {
        const offset = $navigation.offset().top;

        $(window).on('scroll', () => {
            window.requestAnimationFrame(() => {
                if (!$navigation.hasClass(className) && $(window).scrollTop() >= offset) {
                    $navigation.addClass(className);
                } else if ($navigation.hasClass(className)) {
                    $navigation.removeClass(className);
                }
            })
        })
    }
}

/**
 * Initialize the mobile menu open/close listeners
 */
function initNavigationDropdown() {
    var $menuButton = $("#menu-button");
    var $menuList = $("#navdrawer");
    setupBetterHeightTransitions($menuList, $menuButton, true);
}

/**
 * Initialize the listeners for the accordian style categories module
 */
function initCategoriesModule() {
    const $children = $(".CategoriesModule-children");
    const $chevrons = $(".CategoriesModule-chevron");

    $chevrons.each((index, chevron) => {
        const $chevron = $(chevron);
        const $childList = $chevron
            .parent()
            .parent()
            .find(".CategoriesModule-children")
            .first();
        setupBetterHeightTransitions($childList, $chevron, true);
    });
}

/**
 * Initialzie the navigation menus visibility.
 *
 * We initially hide all of the nav items while the measure themselves,
 * then move to their initial states. By default they are hidden,
 * This overrides the baked in hiding styles.
 */
function initNavigationVisibility() {
    console.log("init nav visibiltiy");
    const $nav = $("#navdrawer");
    $nav.css({ position: "relative", visibility: "visible" });
    $nav.addClass('isReadyToTransition');
}

/**
 * Measure approximate real heights of an element and store/use it
 * to have a more accurate max-height transition.
 *
 * @param {any} $elementToMeasure
 * @param {any} toState
 */
function applyNewElementMeasurements($elementToMeasure, toState) {
    const trueHeight = $elementToMeasure.outerHeight() + "px";
    const previouslyCalculatedOldHeight = $elementToMeasure.attr(
        "data-true-height"
    );

    if (!previouslyCalculatedOldHeight) {
        $elementToMeasure.attr("data-true-height", trueHeight);
    }

    $elementToMeasure.attr("data-valid-open-state", false);

    if (toState === STATE_CLOSED) {
        $elementToMeasure.attr("data-valid-open-state", false);
        $elementToMeasure.css("overflow", "hidden");
        $elementToMeasure.css("max-height", "0px");
    } else if (toState === STATE_OPEN) {
        $elementToMeasure.attr("data-valid-open-state", true);
        $elementToMeasure.css(
            "max-height",
            $elementToMeasure.attr("data-true-height")
        );
        $elementToMeasure.on("transitionend", function handler() {
            if ($elementToMeasure.attr("data-valid-open-state") === "true") {
                $elementToMeasure.css("overflow", "visible");
                $elementToMeasure.off("transitionend", handler);
            }
        });
    }

    $elementToMeasure.attr("data-state", toState);
}

/**
 * Setup a more accurate max-height transition on an element to be triggered by another element.
 *
 * @param {jquery.element} $elementToMeasure The jquery element to measure
 * @param {jquery.element} $triggeringElement The jquery element that triggers the transition
 * @param {boolean} collapseByDefault whether or not to collapse the element by default. This will happen after everything has been measured and you fire the EVENT_COLLAPSE_DEFAULTS from the window
 */
function setupBetterHeightTransitions(
    $elementToMeasure,
    $triggeringElement,
    collapseByDefault
) {
    applyNewElementMeasurements($elementToMeasure, STATE_OPEN);

    $triggeringElement.on("click", () => {
        const elementState = $elementToMeasure.attr("data-state");

        if (elementState === STATE_CLOSED) {
            $triggeringElement.toggleClass("isToggled");
            applyNewElementMeasurements($elementToMeasure, STATE_OPEN);
        } else if (elementState === STATE_OPEN) {
            $triggeringElement.toggleClass("isToggled");
            applyNewElementMeasurements($elementToMeasure, STATE_CLOSED);
        }
    });

    if (collapseByDefault) {
        window.addEventListener(EVENT_COLLAPSE_DEFAULTS, () => {
            applyNewElementMeasurements($elementToMeasure, STATE_CLOSED);
        });
    }
}
