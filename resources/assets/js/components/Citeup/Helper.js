
import moment from 'moment'
import Citeup from '../../citeup'

function monetize(val = 0) {

    if (val === null) {
        val = '0'
    }

    var counter = 0
    var value = String(val)
    var formatted = ''

    for (let i = value.length - 1; i >= 0; i--) {

        if (counter > 0 && counter % 3 === 0) {
            formatted += '.'
        }

        formatted += value[i]

        counter++
    }

    return formatted.split('').reverse().join('') + ',00'
}

function assetify(value) {
    return Citeup.appPath + '/' + value
}

function formatDateStandard(value) {
    return moment(value).format('D MMMM YYYY, HH:mm:ss')
}

function formatDateComplete(value, withHours = true) {
    return moment(value).format('D MMMM YYYY' + (withHours ? ', HH:mm' : ''))
}

function formatDateShort(value) {
    return moment(value).format('DD MMM, HH:mm')
}

function shortenPreview(value, maxlength = 150) {
    if (value !== undefined && value.length > maxlength) {
        return value.substring(0, maxlength) + '...'
    }

    return value
}

export { 
    monetize, assetify, formatDateComplete, formatDateStandard,
    formatDateShort, shortenPreview 
}