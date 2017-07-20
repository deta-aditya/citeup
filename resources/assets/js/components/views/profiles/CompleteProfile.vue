
<style lang="scss" scoped>
    
    #complete-profile {

        .row {
            margin: 25px 0 75px;
        }

        .panel-body {
            padding: 30px 40px;
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

    }

</style>

<template>
    <div id="complete-profile">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="text-center">
                        <h1>Cite UP</h1>
                        <p class="lead">Anda telah terdaftar! Lengkapi profil Anda.</p>
                    </div>
                    <div ref="panel" class="panel panel-default">
                        <div ref="cover" class="panel-cover" v-show="isLoading">
                            <div class="panel-cover-content text-center">
                                <i class="fa fa-spinner fa-4x fa-pulse"></i> 
                                <p class="lead">Memuat...</p>
                            </div>
                        </div>
                        <div class="panel-body">
                        
                            <api-form ref="form" method="put" :action="formAction" :model="localUser">
                                <text-input name="name" :required="true" :autofocus="true" v-model="localUser.name">
                                    Nama
                                </text-input>
                                <text-input name="address" :multiline="true" v-model="localUser.address">
                                    Alamat Tempat Tinggal
                                </text-input>
                                <text-input name="city" v-model="localUser.city">
                                    Kota/Kabupaten
                                </text-input>
                                <text-input name="school" v-model="localUser.school">
                                    Sekolah
                                </text-input>
                                <text-input name="phone" v-model="localUser.phone">
                                    Nomor Telepon
                                </text-input>
                                <file-input name="photo" :object-id="user.id" object-type="profile" accept="image/*" :store-immediately="true" v-model="localUser.photo">
                                    Unggah Foto Diri
                                </file-input>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        Selesai
                                    </button>
                                    <button type="reset" class="btn btn-lg btn-default">
                                        Hapus
                                    </button>
                                    <router-link :to="{ name: 'root' }" class="btn btn-lg btn-link pull-right">
                                        Lewati
                                    </router-link>
                                </div>
                            </api-form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash';
    import { mapActions, mapMutations, mapState } from 'vuex';

    import ApiForm from '../../forms/ApiForm.vue';
    import TextInput from '../../forms/TextInput.vue';
    import FileInput from '../../forms/FileInput.vue';

    const LOCAL_USER_PROPS = [
        'name', 'address', 'city', 'school', 'phone', 'photo'
    ]

    export default {

        data() {
            return {
                localUser: {},
                isLoading: false,
            }
        },

        mounted() {
            this.prepareComponent();
        },

        computed: _.merge(mapState([
            
            'user'

        ]), {

            formAction() {
                return '/users/' + this.user.id;
            }

        }),

        watch: {
            user() {
                this.mapLocalUser()
            },

            isLoading(newVal) {
                if (newVal) {
                    this.setCoverHeight()
                }
            }
        },

        methods: _.merge(mapActions([
            'updateUserFromApi'
        ]), {
            
            prepareComponent() {

                let form = this.$refs.form
                var self = this

                form.$on('submitting', () => { this.isLoading = true })
                form.$on('submitted', (response) => {
                    self.$router.push({ name: 'root' })
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

            mapLocalUser() {
                for (let prop of LOCAL_USER_PROPS) {
                    if (prop === 'name') {
                        this.localUser.name = this.user.name
                    } else {
                        this.localUser[prop] = this.user.profile[prop] || ''
                    }
                }
            }

        }),

        components: {
            'api-form': ApiForm,
            'text-input': TextInput,
            'file-input': FileInput
        }

    }
</script>
