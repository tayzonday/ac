
window['addEvent'] = addEvent;
function addEvent(element, type, fn, uc) {

    console.log('addEvent(' + element + ', ' + type + ', …, ' + uc + ')');

    if(element.addEventListener) {
        element.addEventListener(type, fn, uc);
        return true;
    } else {
        element['on' + type] = fn;
    }

}