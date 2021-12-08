import r from "ziggy";
import { Ziggy } from "@js/ziggy.js";

/**
 * throttle the function
 *
 * @param {Function} func
 * @param {Int} timeFrame  miliselecons
 * @returns {Function}
 */
function throttle(func, timeFrame) {
    var lastTime = 0;
    return (...args) => {
        var now = new Date();
        if (now - lastTime >= timeFrame) {
            func(...args);
            lastTime = now;
        }
    };
}

/**
 * debounce the function
 *
 * @param {Function} func
 * @param {Int} wait  miliselecons
 * @returns {Function}
 */
function debounce(func, wait, immediate) {
    var timeout;
    return () => {
        var context = this,
            args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout( () => {
            timeout = null;
            if (!immediate) func.apply(context, args);
        }, wait);
        if (immediate && !timeout) func.apply(context, args);
    };
}

function route(route) {
	return r(route, undefined, undefined, Ziggy);
};

export { 
	debounce,
	throttle, 
	route 
};
