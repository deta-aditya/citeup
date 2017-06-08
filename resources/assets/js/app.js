
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

Vue.component('api-box', {

    props: ['headerText', 'reqType', 'uri'],

    template: '\
        <div class="panel panel-default">\
            <div class="panel-heading">{{ headerText }}</div>\
            <div class="panel-body">\
                <div class="form-group">\
                    <label>Params</label>\
                    <textarea class="form-control" v-model="params"></textarea>\
                </div>\
                <button type="button" class="btn btn-primary" @click="load">\
                    Load\
                </button>\
            </div>\
            <slot name="result-area" :data="data"></slot>\
        </div>',

    data: function () {
        return {
            params: '{}',
            data: {}
        };
    },

    filters: {

        stringify: function (v) {
            return JSON.stringify(v, null, 2);
        }

    },

    methods: {

        load: function () {
            var self = this;
            var params = JSON.parse(self.params);

            if (self.reqType === 'get') {
                params = {params: params};
            }

            axios[self.reqType](self.uri, params).then(response => {
                self.data = response.data;
            });

        }
    }
});

const app = new Vue({
    el: '#app',

    data: {
        user: null,
        query: '{}',
        api: {
            users: null
        }
    },

    filters: {

        stringify: function (v) {
            return JSON.stringify(v, null, 2);
        }

    },

    methods: {
        
        loadUser: function () {
            var self = this;
            axios.get('/api/user').then(response => {
                self.user = JSON.stringify(response.data);
            });
        },

        users: function () {
            var self = this;
            var params = JSON.parse(self.query);
            axios.get('/api/v1/users', {
                params: params
            }).then(response => {
                self.api.users = response.data.data.users;
            });
        }

    }
});
