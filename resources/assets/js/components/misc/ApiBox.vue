<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <slot name="header-text"></slot>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Params</label>
                <textarea class="form-control" v-model="params"></textarea>
            </div>
            <div class="form-group" v-show="multipart">
                <label>Uploads ({{ fileUploadName }})</label>
                <input type="file" @change="putFile">
            </div>
            <button type="button" class="btn btn-primary" @click="load">
                Load
            </button>
        </div>
        <slot name="result-area" :data="data" v-if="(! _.isEmpty(data))"></slot>
    </div>
</template>

<script>

module.exports = {

    props: ['reqType', 'uri', 'multipart', 'fileUploadName'],
    
    data: function () {
        return {
            params: '{}',
            uploads: [],
            data: {
                data: {}
            }
        };
    },

    filters: {

        stringify: function (v) {
            return JSON.stringify(v, null, 2);
        }

    },

    methods: {

        putFile: function (event) {
            this.uploads = event.target.files;
        },

        load: function () {

            if (this.multipart) {
                return this.loadMultipart();
            }

            var self = this;
            var params = JSON.parse(self.params);

            if (self.reqType === 'get' || self.reqType === 'delete') {
                params = {params: params};
            }

            axios[self.reqType](self.uri, params).then(response => {
                self.data = response.data;
            });

        },

        loadMultipart: function () {
            var form = new FormData();
            var self = this;
            var params = JSON.parse(self.params);

            if (self.uploads.length > 0) {
                if (self.uploads.length > 1) {
                    for (let i = 0; i < self.uploads.length; i++) {
                        form.append(self.fileUploadName, self.uploads[i]);
                    }
                } else {
                    form.append(self.fileUploadName, self.uploads[0]);
                }
            }

            for (let param in params) {
                form.append(param, params[param]);
            }

            axios[self.reqType](self.uri, form).then(response => {
                self.data = response.data;
            });
        }
    }
}
</script>
