
<template>
    <div :class="{'form-group': grouped, 'file-uploader-group': true}">
        <label v-if="labeled" :for="name" :class="['control-label', labelColumn]">
            <slot></slot>
        </label>
        <div :class="[controlColumn]">
            <div class="well file-uploader">
                <div ref="uploadContainer" class="uploaded-container" v-show="acceptIsImage && fileIsNotNone">
                    <div ref="cover" class="cover" v-show="fileIsNotFinished">
                        <div ref="coverContainer" class="cover-container text-center">
                            <button type="button" class="btn btn-sm btn-circle btn-default" @click="upload" v-show="fileIsCropped" title="Upload this file">
                                <i class="fa fa-upload fa-2x fa-fw"></i>
                            </button>
                            <i class="fa fa-spinner fa-2x fa-pulse" v-show="fileIsStoring || fileIsRemoving"></i>
                        </div>
                    </div>
                    <img ref="preview" class="img-rounded uploaded-img">
                </div>
                <div class="button-container">
                    <button type="button" class="btn btn-default btn-browse" @click="$refs.realInput.click()" v-show="fileIsMutable">Browse</button>
                    <button type="button" class="btn btn-link" @click="removeFile" v-show="fileIsFinished">Change File</button>
                    {{ filePath | nameOnly }}
                </div>
            </div>
            <slot name="help-block"></slot>
        </div>
        <input 
            type="file"
            class="hidden"
            ref="realInput"
            :id="name"
            :name="name"
            :accept="accept" 
            :required="required" 
            :disabled="disabled"
            @change="prepareInput($event.target)">

        <message-box ref="messageBox" :name="'cropbox-' + name" v-if="acceptIsImage && crop" :dismissable="false">
            <span slot="title">Crop Image</span>
            <div class="crop-container">
                <img ref="croppable">
            </div>
            <template slot="buttons">
                <button type="button" class="btn btn-default" data-dismiss="modal" @click="backToNone">Cancel</button>
                <button type="button" class="btn btn-primary" @click="getCropped">Done</button>
            </template>
        </message-box>

    </div>
</template>

<script>

    import Cropper from 'cropperjs';
    import Citeup from '../../../citeup';
    import MessageBox from '../MessageBox.vue'

    const FILE_NONE = 0;
    const FILE_INPUTTED = 1;
    const FILE_CROPPING = 2;
    const FILE_CROPPED = 3;
    const FILE_STORING = 4;
    const FILE_FINISHED = 5;
    const FILE_FAILED = 6;
    const FILE_REMOVING = 7;

    const ORIGINAL_INPUT = {};

    const ORIGINAL_FILE_PATH = 'No file selected.';

    export default {

        props: {

            name: {
                type: String,
                required: true
            },

            grouped: {
                type: Boolean,
                default: true,
            },

            objectId: {
                type: Number,
                required: true
            },

            objectType: {
                type: String,
                required: true
            },

            required: {
                type: Boolean,
                default: false
            },

            labeled: {
                type: Boolean,
                default: true
            },

            accept: {
                type: String,
                default: '*'
            },

            disabled: {
                type: Boolean,
                default: false
            },

            labeled: {
                type: Boolean,
                default: true
            },

            labelWidth: {
                type: Number,
                default: 0,
            },

            controlWidth: {
                type: Number,
                default: 0,
            },

            storeImmediately: {
                type: Boolean,
                default: false
            },

            aspectRatio: {
                type: Number,
                default: 1,
            },

            crop: {
                type: Boolean,
                default: true
            },

            value: {
                type: String,
            }

        },

        data() {
            return {
                cropper: {},
                messageBox: null,
                filePath: ORIGINAL_FILE_PATH,
                status: FILE_NONE,
                input: ORIGINAL_INPUT
            };
        },

        computed: {

            acceptIsImage() {
                return this.accept.indexOf('image/') >= 0;
            },

            isSingleUpload() {
                return ! this.multiple;
            },

            fileIsNone() {
                return this.status === FILE_NONE;
            },

            fileIsInputted() {
                return this.status === FILE_INPUTTED;
            },

            fileIsCropping() {
                return this.status === FILE_CROPPING;
            },

            fileIsCropped() {
                return this.status === FILE_CROPPED;
            },

            fileIsStoring() {
                return this.status === FILE_STORING;
            },

            fileIsFinished() {
                return this.status === FILE_FINISHED;
            },

            fileIsFailed() {
                return this.status === FILE_FAILED;
            },

            fileIsRemoving() {
                return this.status === FILE_REMOVING;
            },

            fileIsNotNone() {
                return ! this.fileIsNone;
            },

            fileIsNotFinished() {
                return ! this.fileIsFinished;
            },

            fileIsMutable() {
                return this.fileIsNone || this.fileIsInputted || this.fileIsCropped;
            },

            horizontal() {
                this.labelWidth > 0 && this.controlWidth > 0
            },

            labelColumn() {
                return this.labelWidth > 0 ? 'col-sm-' + this.labelWidth : ''
            },

            controlColumn() {
                return this.controlWidth > 0 ? 'col-sm-' + this.controlWidth : ''
            },

        },

        mounted() {
            this.prepareComponent();
        },

        watch: {

            value(val) {
                if (val) {
                    this.receiveValue(val)
                }
            }

        },

        filters: {

            nameOnly(value) {
                if (value) {
                    return value.split('/').pop();
                }
            }

        },

        methods: {

            prepareComponent() {

                var self = this;

                this.messageBox = this.$refs.messageBox

                if (this.value) {
                    this.receiveValue(this.value)
                }

                if (this.acceptIsImage && this.crop) {

                    var croppable = this.$refs.croppable;
                    
                    this.initializeCropper();

                    var promise = new Promise((resolve, reject) => {
                        
                        croppable.onload = () => {
                            resolve('croppable.onload');
                        }

                        self.messageBox.$on('shown', () => {
                            resolve('modal.onshown');
                        })

                    }).then((val) => {

                        function replaceCropper() {
                            self.cropper.replace(croppable.getAttribute('src'));
                            self.cropper.enable();
                        }

                        self.cropper.disable();
                        
                        if (val === 'croppable.onload') {
                            self.messageBox.$on('shown', () => {
                                replaceCropper();
                            });
                        } else if (val === 'modal.onshown') {
                            croppable.onload = () => {
                                replaceCropper();
                            }
                        }

                    });

                } 

            },

            receiveValue(value) {
                if (this.acceptIsImage && value === Citeup.defaultImageClean) {
                    return
                }

                this.status = FILE_FINISHED;
                this.filePath = value;

                if (this.acceptIsImage) {
                    this.modifyPreviewImage(Citeup.appPath + '/' + value);
                }
            },

            prepareInput(target) {
                
                if (target.files && target.files[0]) {
                    this.input = target.files[0];
                }
                
                this.filePath = target.value;

                this.status = FILE_INPUTTED;

                console.log('Preparing input...', this.filePath)

                if (this.acceptIsImage && this.crop) {
                    this.openCropper();
                }

                if (this.storeImmediately && ! this.crop) {
                    this.upload()
                }

            },

            initializeCropper() {

                this.cropper = new Cropper(this.$refs.croppable, {
                    aspectRatio: this.aspectRatio,
                    responsive: true
                });

            },

            openCropper() {
                
                let source = URL.createObjectURL(this.input);
                var croppable = this.$refs.croppable;
                var self = this;
                
                this.status = FILE_CROPPING;

                this.messageBox.open();

                croppable.setAttribute('src', source);
            },

            getCropped() {

                this.input = this.cropper.getCroppedCanvas();
                this.status = FILE_CROPPED;

                this.messageBox.close();

                this.preview();

                if (this.storeImmediately) {
                    this.upload();
                }
                
            },

            preview() {
                var cropped = this.input;

                this.modifyPreviewImage(cropped.toDataURL())
            },

            modifyPreviewImage(src) {

                var preview = this.$refs.preview;
                var self = this;

                preview.setAttribute('src', src);
                preview.style.maxWidth = '200px';
                preview.style.maxHeight = '100px';

                preview.onload = () => {
                    let width = preview.offsetWidth + 'px';
                    
                    self.$refs.cover.style.width = width;
                    self.$refs.coverContainer.style.width = width;
                }
            },

            upload() {

                console.log('Uploading...')

                this.status = FILE_STORING;

                if (! this.crop) {
                    return this.startUpload(this.input)
                }

                this.input.toBlob(this.startUpload);

            },

            startUpload(blob) {
                
                var form = new FormData();
                var self = this;

                console.log('Start Uploading...')

                form.append('object_id', this.objectId);
                form.append('object_type', this.objectType);
                form.append('file', blob);

                Citeup.post('/storage', form).then(function (response) {
                    
                    self.uploadSuccess(response.data.data.link);

                }).catch(self.requestOnError);
            },

            uploadSuccess(link) {

                this.status = FILE_FINISHED;
                this.filePath = link;

                this.$emit('input', link);
                
            },

            removeFile() {

                var self = this;

                this.status = FILE_REMOVING;

                if (this.filePath === 'storage/images/default.jpg' || this.filePath === Citeup.defaultImageClean) {
                    this.backToNone()
                    return
                }

                Citeup.delete('/storage', {link: this.filePath}).then(function (response) {

                    self.backToNone();

                }).catch(self.requestOnError);

            },

            requestOnError(error) {
                if (error.response.status === 422) {
                    //
                } 

                if (error.response.status === 500) {
                    alert('Internal Server Error');
                }

                this.$router.push({ name: 'Error', params: {
                    status: error.response.status
                }});
            },

            backToNone() {
                this.status = FILE_NONE;
                this.input = ORIGINAL_INPUT;
                this.filePath = ORIGINAL_FILE_PATH;

                this.$emit('input', '');
            }
        },

        components: {
            'message-box': MessageBox,
        }
    }
</script>
