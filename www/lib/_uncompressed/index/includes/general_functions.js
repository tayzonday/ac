
function addEvent(_element, _type, _func, _uc) {

    console.log('addEvent(' + _element + ', ' + _type + ', …, ' + _uc+ ')');

    if(_element.addEventListener) {
        _element.addEventListener(_type, _func, _uc);
        return true;
    } else {
        element['on' + _type] = _func;
    }

}

function goto(_path) {

	window.location.href = _path;

}