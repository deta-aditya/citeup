
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
import Countdown from './components/misc/Countdown.vue'
import TextInput from './components/kits/FormPanel/TextInput'
import EmailInput from './components/kits/FormPanel/EmailInput'
import StaticInput from './components/kits/FormPanel/StaticInput'
import PasswordInput from './components/kits/FormPanel/PasswordInput'
import MultilineInput from './components/kits/FormPanel/MultilineInput'

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
            labelWidth: 3,
            controlWidth: 9,
            gmapOptions: {
                mapTypeControl: false,
                streetViewControl: false,
                zoomControl: false,
            },
        }
    },

    filters: {

        monetize(val) {
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
        },

    },

    mounted() {
        this.prepareComponent()
    },

    methods: {
        prepareComponent() {
            this.turnOnTooltip()
        },

        turnOnTooltip() {
            $('[data-toggle="tooltip"]').tooltip()
        },
    },

    components: {        
        'countdown': Countdown,
        'text-input': TextInput,
        'email-input': EmailInput,
        'static-input': StaticInput,
        'password-input': PasswordInput,
        'multiline-input': MultilineInput,
    },

});
