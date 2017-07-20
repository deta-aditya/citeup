
<style lang="scss" scoped>

    .panel {
        border-radius: 0;
        border: none;
    }

    .panel-heading {
        border-radius: 0;

        .fa {
            color: #fff;
        }
    }

    .panel-title {

        padding: 5px 0;

        & > .fa {
            background: #fff;
            border-radius: 50%;
            padding: 5px;
            margin-right: 3px;
            color: #337ab7;
        }

    }

    .panel-body {
        border-radius: 0;    
        padding: 25px
    }

    .panel-cover {
        position: absolute;
        background: rgba(255,255,255,0.7);
        z-index: 10;

        .panel-cover-content {
            display: table-cell;
            vertical-align: middle;

            i.fa {
                margin-bottom: 10px;
            }
        }
    }

</style>

<template>
    <div id="alerts-create">
        <div ref="panel" class="panel panel-primary">
            <div ref="cover" class="panel-cover" v-show="isLoading">
                <div class="panel-cover-content text-center">
                    <i class="fa fa-spinner fa-4x fa-pulse"></i> 
                    <p class="lead">Memuat...</p>
                </div>
            </div>
            <div class="panel-heading">
                <div class="pull-right">
                    <router-link :to="{ name: 'alerts' }" class="btn btn-link">
                        <i class="fa fa-chevron-left"></i>
                    </router-link>
                </div>
                <h1 class="panel-title"><i class="fa fa-bell"></i> Tambah Notifikasi</h1>
            </div>
            <div class="panel-body">

                <api-form ref="form" method="post" action="/alerts" :model="alert">
                    <text-input name="title" :required="true" :autofocus="true" :maxlength="191" v-model="alert.title">
                        Judul Notifikasi
                    </text-input>
                    <text-input name="content" :required="true" :multiline="true" :maxlength="191" v-model="alert.content">
                        Konten Notifikasi
                    </text-input>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary">
                            Selesai
                        </button>
                    </div>
                </api-form>

            </div>
        </div>
    </div>
</template>

<script>

    import ApiForm from '../../forms/ApiForm.vue'
    import TextInput from '../../forms/TextInput.vue'

    export default {

        data() {
            return {
                isLoading: false,
                alert: {
                    title: '',
                    content: '',
                }
            }
        },

        watch: {

            isLoading(newVal) {

                if (newVal) {
                    this.setCoverHeight()
                }

            },

        },

        mounted() {
            this.prepareComponent()
            this.setCoverHeight()
        },

        methods: {

            prepareComponent() {

                let form = this.$refs.form
                var self = this

                form.$on('submitting', () => { this.isLoading = true })
                form.$on('submitted', (response) => {
                    self.$router.push({ name: 'alerts' })
                })

            },

            setCoverHeight() {
                let panel = this.$refs.panel;
                let cover = this.$refs.cover;
                let coverContent = cover.querySelector('.panel-cover-content');

                this.setDimension(cover, panel);
                this.setDimension(coverContent, panel);
            },

            setDimension(thisOne, likeThisOne) {
                thisOne.style.width = likeThisOne.offsetWidth + 'px';
                thisOne.style.height = likeThisOne.offsetHeight + 'px';
            },

        },

        components: {
            'api-form': ApiForm,
            'text-input': TextInput,
        }

    }

</script>
