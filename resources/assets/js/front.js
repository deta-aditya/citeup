
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Components to be available in this application.
 */
import RadioVerticalLg from './components/forms/RadioVerticalLg.vue'
import RadioButton from './components/forms/RadioButton.vue'
import Countdown from './components/misc/Countdown.vue'

import Citeup from './citeup'
import * as VueGoogleMaps from 'vue2-google-maps' 

Vue.use(VueGoogleMaps, {
    load: {
        key: Citeup.gmapKey,
    }
})

/**
 * This application script runs on the front page.
 * Unlike the other scripts, this does not implement a single-page application.
 * Vue here works as a helper since we're using the components.
 */
const frontViewModel = new Vue({
    
    el: '#app-front',

    data() {
        return {
            gmapOptions: {
                mapTypeControl: false,
                streetViewControl: false,
                zoomControl: false,
            },
        }
    },

    components: {

        // The radio-vertical-lg for radio button eyecandy on some forms.
        'radio-vertical-lg': RadioVerticalLg,

        // The radio-button for radio button item.
        'radio-button': RadioButton,

        'countdown': Countdown
    },

});
