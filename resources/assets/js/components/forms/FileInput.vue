
<style lang="scss" scoped>

    $container-height: 100px;

    .file-uploader {

        overflow-x: hidden;
    
        & > div {
            display: table-cell;    
        }

        .uploaded-container {
            height: $container-height;
            padding-right: 15px;

            .cover {
                position: absolute;
                background: rgba(255,255,255,0.5);
                height: $container-height;
                z-index: 10;

                .cover-container {
                    height: $container-height;
                    display: table-cell;
                    vertical-align: middle;
                }
            }
        }

        .button-container {
            vertical-align: middle;
            overflow-wrap: break-word;
            word-break: break-word;
            hypens: auto;
        }

    }

    .crop-container {
        
        img {
            max-width: 100%;
        }
    }

    .btn-browse {
        margin-right: 10px;
    }

</style>

<template>
    <div class="form-group">
        <label v-if="labeled" :for="name" class="control-label">
            <slot></slot>
        </label>
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
                <button type="button" class="btn btn-link" @click="removeFile" v-show="fileIsFinished">Remove File</button>
                {{ filePath | nameOnly }}
            </div>
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
            :autofocus="autofocus"
            @input="prepareInput($event.target)">

        <div id="image-cropper" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" v-if="acceptIsImage && crop">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crop Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="crop-container">
                            <img ref="croppable">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="backToNone">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="getCropped">Done</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    import Cropper from 'cropperjs';
    import Citeup from '../../citeup';

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

            autofocus: {
                type: Boolean,
                default: false
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

            storeImmediately: {
                type: Boolean,
                default: false
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
            }
        },

        mounted() {
            this.prepareComponent();
        },

        watch: {

            value(val) {
                if (val) {
                    this.status = FILE_FINISHED;
                    this.filePath = val;

                    if (this.acceptIsImage) {
                        this.modifyPreviewImage(Citeup.appPath + '/' + this.filePath);
                    }
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

                if (this.acceptIsImage && this.crop) {

                    var croppable = this.$refs.croppable;
                    var modal = $('#image-cropper');
                    
                    this.initializeCropper();

                    var promise = new Promise((resolve, reject) => {
                        
                        croppable.onload = () => {
                            resolve('croppable.onload');
                        }

                        modal.on('shown.bs.modal', () => {
                            resolve('modal.onshown');
                        })

                    }).then((val) => {

                        function replaceCropper() {
                            self.cropper.replace(croppable.getAttribute('src'));
                            self.cropper.enable();
                        }

                        self.cropper.disable();
                        
                        if (val === 'croppable.onload') {
                            modal.on('shown.bs.modal', () => {
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

            prepareInput(target) {
                
                if (target.files && target.files[0]) {
                    this.input = target.files[0];
                }
                
                this.filePath = target.value;

                this.status = FILE_INPUTTED;

                if (this.acceptIsImage && this.crop) {
                    this.openCropper();
                }

            },

            initializeCropper() {

                this.cropper = new Cropper(this.$refs.croppable, {
                    aspectRatio: 1,
                    responsive: true
                });

            },

            openCropper() {
                
                let source = URL.createObjectURL(this.input);
                var croppable = this.$refs.croppable;
                var self = this;
                
                this.status = FILE_CROPPING;

                $('#image-cropper').modal('show');

                croppable.setAttribute('src', source);
            },

            getCropped() {

                this.input = this.cropper.getCroppedCanvas();
                this.status = FILE_CROPPED;

                $('#image-cropper').modal('hide');

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
                
                var form = new FormData();
                var self = this;

                this.status = FILE_STORING;

                this.input.toBlob(function (blob) {

                    form.append('object_id', self.objectId);
                    form.append('object_type', self.objectType);
                    form.append('file', blob);

                    Citeup.post('/storage', form).then(function (response) {
                        
                        self.uploadSuccess(response.data.data.link);

                    }).catch(self.requestOnError);
                });

            },

            uploadSuccess(link) {

                this.status = FILE_FINISHED;
                this.filePath = link;

                this.$emit('input', link);
                
            },

            removeFile() {

                var self = this;

                this.status = FILE_REMOVING;

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

                self.$router.push({ name: 'error', params: {
                    status: error.response.status
                }});
            },

            backToNone() {
                this.status = FILE_NONE;
                this.input = ORIGINAL_INPUT;
                this.filePath = ORIGINAL_FILE_PATH;

                this.$emit('input', '');
            }
        }
    }
</script>
