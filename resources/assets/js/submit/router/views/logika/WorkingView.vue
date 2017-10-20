
<template>
    <div id="working-view">
        <message-box ref="finishBox" name="finish-box" class="text-center" :headerless="true">
            <h2 class="finish-box-title">Yakin Selesai?</h2>
            <p class="finish-box-subtitle">Masih tersisa waktu sebelum seleksi berakhir.</p>
            <p>Silahkan periksa ulang pekerjaan Anda. Perlu diingat bahwa Anda tidak akan dapat mengubah apapun setelah menekan tombol selesai!</p>
            <div slot="buttons" class="text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Periksa Kembali</button>
                <button type="button" class="btn btn-primary" @click="finish">Selesai</button>
            </div>
        </message-box>
        <div class="form-panel form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label">Tema Poster</label>
                <div class="col-sm-10" :style="{ fontFamily: 'Quicksand, Open Sans, sans-serif', fontWeight: 700, paddingTop: '7px' }">The collaboration of technology, humanity, and nature.</div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Palette Warna</label>
                <div class="col-sm-10" :style="{ paddingTop: '7px' }">
                    <img :src="'images/web/palette.png' | assetify" class="img-rounded" :style="{ width: '400px' }">
                </div>
            </div>
            <file-input name="picture" :label-width="2" :control-width="10" :object-id="user.entry.id" object-type="submit" accept="image/*" :store-immediately="true" :crop="false" v-model="submission.picture">
                Karya Poster
                <p class="help-block" slot="help-block">Silahkan unggah poster dalam format .jpg dengan ukuran file tidak lebih dari 2MB.</p>
            </file-input>
            <multiline-input name="description" :required="true" :label-width="2" :control-width="10" :maxlength="250" v-model="submission.description">
                Deskripsi Poster
                <p class="help-block" slot="help-block">Tuliskan deskripsi singkat tentang karya Anda kurang dari 250 karakter.</p>
            </multiline-input>
        </div>
        <div class="text-center" :style="{ marginTop: '15px' }">
            <button type="button" class="btn btn-lg btn-primary btn-done" @click="openFinishBox">Selesai</button>
        </div>
    </div>
</template>

<script>
    
    import { merge } from 'lodash'
    import { mapState, mapActions } from 'vuex'
    import { assetify } from '../../../../components/Citeup/Helper'
    import MessageBox from '../../../../components/kits/MessageBox.vue'
    import FileInput from '../../../../components/kits/FormPanel/FileInput.vue'
    import StaticInput from '../../../../components/kits/FormPanel/StaticInput.vue'
    import MultilineInput from '../../../../components/kits/FormPanel/MultilineInput.vue'

    const userState = mapState('user', {'user': 'data'})
    const submissionsState = mapState('submissions', {'submission': 'data'})
    const sumbissionActions = mapActions('submissions', ['persist'])
    const stageActions = mapActions('stage', ['toFinish'])

    export default {

        data() {
            return {
                theme: 'Coming Soon!'
            }
        },

        computed: merge(submissionsState, userState),

        filters: {
            assetify,
        },

        methods: merge(sumbissionActions, stageActions, {
            openFinishBox() {
                this.$refs.finishBox.open()
            },
            finish() {
                this.persist().then(() => {
                    this.$refs.finishBox.close()
                    this.toFinish()
                })
            },
        }),

        components: {
            'file-input': FileInput,
            'message-box': MessageBox,
            'static-input': StaticInput,
            'multiline-input': MultilineInput,
        }

    }

</script>