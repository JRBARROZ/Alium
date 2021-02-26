function addCpfCnpjMask(element) {
    var value = element.value;
    var size = value.length;

    if (size == 11) {
        element.value = format('xxx.xxx.xxx-xx', value);
    } else if (size > 11) {
        element.value = format('xx.xxx.xxx/xxxx-xx', value);
    }
}

function addPostalCodeMask(element) {
    var value = element.value;
    var size = value.length;

    if (size != 8) {
        return;
    }

    element.value = format('xxxxx-xxx', value);
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
    element.value = element.value.replaceAll('.', '');
    element.value = element.value.replaceAll('-', '');
    element.value = element.value.replaceAll('/', '');
    element.value = element.value.replaceAll('(', '');
    element.value = element.value.replaceAll(')', '');
    element.value = element.value.replaceAll(' ', '');
}

function format(mask, number) {
    var stringNumber = '' + number;
    var result = '';
    // im = index mask
    // is = index string (number)
    for (var im = 0, is = 0; im < mask.length && is < stringNumber.length; im++) {
        result += mask.charAt(im) == 'x' ? stringNumber.charAt(is++) : mask.charAt(im);
    }
    return result;
}