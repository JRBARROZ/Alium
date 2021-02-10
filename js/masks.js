function addCpfCnpjMask(element) {
    var value = element.value;
    var size = value.length;

    if (size == 11) {
        element.value = format('xxx.xxx.xxx-xx', value);
    } else if (size > 11) {
        element.value = format('xx.xxx.xxx/xxxx-xx', value);
    }
}

function addPhoneMask(element) {
    var value = element.value;
    var size = value.length;

    if (size == 11) {
        element.value = format('(xx) xxxxx-xxxx', value);
    } else if (size == 10) {
        element.value = format('(xx) xxxx-xxxx', value);
    }
}

function removeMask(element) {
    console.log(element.value);
    element.value = element.value.replaceAll('.', '');
    element.value = element.value.replaceAll('-', '');
    element.value = element.value.replaceAll('/', '');
    element.value = element.value.replaceAll('(', '');
    element.value = element.value.replaceAll(')', '');
    element.value = element.value.replaceAll(' ', '');
}

function format(mask, number) {
    var s = '' + number;
    var r = '';
    for (var im = 0, is = 0; im < mask.length && is < s.length; im++) {
        r += mask.charAt(im) == 'x' ? s.charAt(is++) : mask.charAt(im);
    }
    return r;
}