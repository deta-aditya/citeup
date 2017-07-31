
<style lang="scss" scoped>

    %curveless {
        border-radius: 0;
    }

    .tabulation {

        .user-img {
            width: 25px;
        }

        .panel {
            @extend %curveless;
            border: none;
        }

        .panel-heading {
            @extend %curveless;
        }

        .panel-title {
            padding: 4px 0;

            & > .fa {
                background: #fff;
                border-radius: 50%;
                padding: 5px;
                margin-right: 3px;
                color: #337ab7;
            }
        }

        .panel-body {
            @extend %curveless;
        }

        .control-list {

            .btn-link {
                color: #fff;

                &:hover .fa {
                    color: #ededed;
                }
            }

            .fa {
                color: #fff;
            }
        }

        .table > tbody > tr {
            
            & > td {
                vertical-align: middle;
            }

            & > th {
                font-weight: 600;
                text-transform: uppercase;
            }
        }

        .table-cover {
            position: absolute;
            background: rgba(255,255,255,0.7);
            z-index: 10;

            .table-cover-content {
                display: table-cell;
                vertical-align: middle;

                i.fa {
                    margin-bottom: 5px;
                }
            }
        }

        .form-control {
            display: inline-block;
        }

        .input-search {
            @extend %curveless;
            width: 200px;
        }

        .input-take {
            @extend %curveless;
            width: 50px;
        }

        .pagination {
            
            margin: 0;
            display: block;

            li > * {
                @extend %curveless;
            }
            
        }

        .detail {

            & > td {
                padding: 0;
            }

            .table {
                margin: 0;
                font-size: 11.75px;
            }
        }

    }

</style>

<template>
    <div class="tabulation" :id="lowercasedTitle + '-tabulation'">
        <div class="panel panel-primary">
            <div class="panel-heading clearfix">
                <div class="pull-right">
                    <input type="text" class="form-control input-search" placeholder="Cari..." v-if="features.search" v-model="search">
                    <div class="btn-group control-list">
                        <dropdown align="right" variant="link" :caret="false">
                            <i class="fa fa-fw fa-lg fa-ellipsis-h"></i>
                            <template slot="menu">
                                <li v-if="features.check && features.remove">
                                    <a @click.prevent="removeChecked" href="#">Hapus Tertanda</a>
                                </li>
                                <li v-for="(action, index) in actions.checked" :key="index">
                                    <a @click.prevent="customAction(action.action, checked)" href="#">{{ action.name }}</a> 
                                </li>
                                <li role="separator" class="divider" v-if="showDividerOnChecked"></li>
                                <li v-if="hasSettings">
                                    <a href="#" data-toggle="modal" :data-target="'#'+ lowercasedTitle +'-tabulation-settings'">Pengaturan Tabel</a>
                                </li>
                            </template>
                        </dropdown>
                        <button type="button" class="btn btn-link" v-if="features.check" @click.prevent="checkAll" :title="checkAllText">
                            <i class="fa fa-fw fa-lg fa-check-square-o"></i>
                        </button>
                        <button type="button" class="btn btn-link" v-if="features.refresh" @click.prevent="refresh" title="Segarkan">
                            <i class="fa fa-fw fa-lg fa-refresh"></i>
                        </button>
                        <router-link class="btn btn-link" :to="forms.create" v-if="features.create" title="Tambah">
                            <i class="fa fa-fw fa-lg fa-plus"></i>
                        </router-link>
                    </div>
                </div>
                <h1 class="panel-title">
                    <slot name="title"></slot>
                </h1>
            </div>
            <table ref="realTable" class="table table-hover">
                <tbody>
                    <div ref="cover" class="table-cover" v-show="isLoading">
                        <div class="table-cover-content text-center">
                            <i class="fa fa-spinner fa-lg fa-pulse"></i> 
                            <p>Memuat...</p>
                        </div>
                    </div>
                    <tr class="info">
                        <th v-for="(column, index) in columns" :key="index">
                            <a @click.prevent="sort(index)" v-if="features.sort" href="#" class="pull-right"><i class="fa fa-fw fa-sort"></i></a>
                            {{ column }}
                        </th>
                        <th>Aksi</th>
                    </tr>
                    <template v-for="record in data">
                        <tr is="tabulation-row" ref="checkables" :identifier="record.id" :key="record.id" @check="check">
                            <td v-for="(cell, key, index) in record" v-if="! (hideId && key === 'id')" :class="{ 'id-cell': key === 'id' }" :key="index">
                                {{ cell }}
                            </td>
                            <td>
                                <dropdown align="right" variant="link" :caret="false">
                                    <i @click.stop class="fa fa-fw fa-ellipsis-v"></i>
                                    <template slot="menu">
                                        <li>
                                            <router-link :to="update(record.id)" v-if="features.update">Sunting</router-link>
                                        </li>
                                        <li>
                                            <a href="#" v-if="features.remove" data-toggle="modal" :data-target="removeModalId" @click="preRemove(record.id)">Hapus</a>
                                        </li>
                                        <li role="separator" class="divider" v-if="showDividerOnIndividual"></li>
                                        <li>
                                            <a href="#" v-if="features.detail" @click.prevent="showDetail(record.id)">{{ detailButtonText }}</a>
                                        </li>
                                        <li v-for="(action, index) in actions.individual" :key="index">
                                            <a @click.prevent="customAction(action.action, record.id)" href="#">{{ action.name }}</a> 
                                        </li>
                                    </template>
                                </dropdown>
                            </td>
                        </tr>
                        <tr class="detail collapse" :id="'collapse-' + record.id + '-detail'" v-if="features.detail">
                            <td :colspan="colspanLength">
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <th v-for="(column, index) in detail.columns" :key="index">
                                                {{ column }}
                                            </th>
                                            <th>Aksi</th>
                                        </tr>
                                        <tr v-for="recordDetail in dataDetail" :key="recordDetail.id">
                                            <td v-for="(cell, key, index) in recordDetail" :key="index">
                                                <img v-if="cellIsImg(cell)" :src="cell.slice(4)" class="img-circle user-img">
                                                <template v-else>{{ cell }}</template>
                                            </td>
                                            <td>
                                                <dropdown align="right" variant="link" size="sm" :caret="false">
                                                    <i class="fa fa-fw fa-ellipsis-v"></i>
                                                    <template slot="menu">
                                                        <li v-for="(action, index) in detail.actions" :key="index">
                                                            <a @click.prevent="customDetailAction(action.action, record.id, recordDetail.id)" href="#">{{ action.name }}</a> 
                                                        </li>
                                                    </template>
                                                </dropdown>
                                            </td>
                                        </tr>
                                        <tr v-if="dataDetail.length === 0">
                                            <td :colspan="detail.columns.length + 1" class="text-center">Tidak ada data detail.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </template>
                    <tr v-if="data.length === 0">
                        <td :colspan="colspanLength" class="text-center">Tidak ada {{ title }}.</td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-body">
                <nav class="pull-right" aria-label="Page navigation" v-if="features.pagination">
                    <ul class="pagination">
                        <li :class="{ disabled: currentPage === 1 }">
                            <a href="#" aria-label="Previous" @click.prevent="prevPage">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li v-for="n in paginationCount" :class="{ active: n === 1 }">
                            <a href="#" @click.prevent="page(n)">{{ n }}</a>
                        </li>
                        <li :class="{ disabled: currentPage === paginationCount }">
                            <a href="#" aria-label="Next" @click.prevent="nextPage">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <span>
                    Menampilkan 
                    <input v-if="features.take" type="text" class="form-control input-take" v-model="take"> 
                    <template v-else>{{ take }}</template> dari {{ count }} data.
                </span>
            </div>
        </div>
        <div v-if="hasSettings" :id="lowercasedTitle +'-tabulation-settings'" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Pengaturan Tabel</h4>
                    </div>
                    <div class="modal-body">
                        <fieldset v-if="settings.hasOwnProperty('columns')">
                            <legend>Kolom</legend>
                            <p class="text-muted">Pilih kolom-kolom yang akan ditampilkan</p>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Done</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="features.remove" :id="removeModalId | noHash" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus {{ title }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>Anda akan menghapus {{ title }} berikut:</p>
                    </div>
                    <table class="table">
                        <tbody v-if="singularRemove">
                            <tr v-for="(prop, key, index) in removable[0]" :key="index">
                                <th>{{ columns[index] }}</th>
                                <td>{{ prop }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" @click="remove">Ya</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
    import _ from 'lodash'
    import Dropdown from '../kits/Dropdown.vue'
    import TabulationRow from './TabulationRow.vue'

    const MUST_HAVE_OPTIONS = [
        'features',
    ]

    const RECOGNIZED_OPTIONS = [
        'features',
        'forms',
        'columns',
        'actions',
        'detail',
        'take',
        'isLoading',
        'hideId',
    ]

    const RECOGNIZED_DETAIL_OPTIONS = [
        'columns',
        'actions',
    ]

    const RECOGNIZED_FEATURES_OPTIONS = [
        'search',
        'sort',
        'check',
        'refresh',
        'create',
        'update',
        'remove',
        'pagination',
        'take',
        'detail',
        'settings',
    ]

    const RECOGNIZED_SETTINGS_OPTIONS = [
        'columns',
        'sorts',
        'conditions',
    ]

    const RECOGNIZED_FORMS_OPTIONS = [
        'create',
        'update',
    ]

    const RECOGNIZED_ACTIONS_OPTIONS = [
        'individual',
        'checked',
    ]

    const RECOGNIZED_ACTIONS_PROPERTIES = [
        'name',
        'action',
    ]


    export default {

        props: {

            title: {
                type: String,
                default: 'Data',
            },

            data: {
                type: Array,
                required: true,
            },

            dataDetail: {
                type: Array,
                default() {
                    return []
                },
            },

            options: {
                type: Object,
                required: true,
                validator(value) {

                    for (let opt of MUST_HAVE_OPTIONS) {
                        if (! value.hasOwnProperty(opt)) {
                            return false
                        }
                    }

                    return true

                } 
            },

        },

        data() {
            return {
                features: {
                    search: true,
                    sort: true,
                    check: true,
                    refresh: true,
                    create: true, 
                    update: true,
                    remove: true,
                    pagination: true,
                    take: true,
                    detail: false,
                    settings: {},
                },
                forms: {
                    create: '',
                    update: '',
                },
                columns: [],
                actions: {
                    individual: [],
                    checked: [],
                },
                detail: {
                    columns: [],
                    actions: [],
                },
                take: 15,
                hideId: false,
                isLoading: false,

                search: '',
                checked: [],
                removable: [],
                currentPage: 1,
                detailIsShown: false,
            }
        },

        computed: {

            paginationCount() {
                return this.take > 0 && this.count > 0 ? Math.ceil(this.count / this.take) : 1
            },

            colspanLength() {
                return this.columns.length + 1
            },

            lowercasedTitle() {
                return this.title.toLowerCase()
            },
            
            showDividerOnIndividual() {
                return (this.features.update || this.features.remove) && (this.actions.individual.length > 0 || this.features.detail)
            },

            showDividerOnChecked() {
                return this.features.check && this.features.remove && this.hasSettings
            },

            hasSettings() {
                return Object.keys(this.features.settings).length
            },

            allIsChecked() {
                return this.checked.length === this.count
            },

            singularRemove() {
                return this.removable.length === 1
            },

            checkAllText() {
                return this.allIsChecked ? 'Bersihkan Tanda' : 'Tandai Semua'
            },

            detailButtonText() {
                return this.detailIsShown ? 'Sembunyikan detail' : 'Tampilkan detail'
            },

            removeModalId() {
                return '#modal-' + this.lowercasedTitle + '-tabulation-remove'
            },

            count() {
                return this.data.length
            }

        },

        watch: {

            search() {
                //
            },

            take() {
                //
            },

            isLoading(newVal) {

                if (newVal) {
                    this.setTableCoverHeight()
                }

            },

            options(newOpts) {
                this.setOptions(newOpts)
            },

        },

        filters: {
            
            noHash(value) {
                return value.slice(1)
            }

        },

        created() {
            this.setOptions(this.options)
        },

        mounted() {
            this.prepareModalEvents()
            this.setTableCoverHeight()
        },

        methods: {

            setOptions(source) {

                for (let opt in source) {

                    if (RECOGNIZED_OPTIONS.indexOf(opt) < 0) {
                        continue
                    }
                    
                    switch (opt) {
                        case 'features': this.mapFeaturesOptions(source); break
                        case 'forms': this.mapFormsOptions(source); break
                        case 'actions': this.mapActionsOptions(source); break
                        case 'detail': this.mapDetailOptions(source); break
                        default: this[opt] = source[opt]
                    }

                }

            },

            mapFeaturesOptions(source) {

                for (let opt in source.features) {

                    if (RECOGNIZED_FEATURES_OPTIONS.indexOf(opt) < 0) {
                        continue
                    }

                    this.features[opt] = source.features[opt]
                }

            },

            mapFormsOptions(source) {

                if (! source.hasOwnProperty('forms')) {
                    return
                }

                for (let opt in source.forms) {

                    if (RECOGNIZED_FORMS_OPTIONS.indexOf(opt) < 0) {
                        continue
                    }

                    this.forms[opt] = source.forms[opt]
                }

            },

            mapActionsOptions(source) {

                if (! source.hasOwnProperty('actions')) {
                    return
                }

                for (let opt in source.actions) {

                    if (RECOGNIZED_ACTIONS_OPTIONS.indexOf(opt) < 0) {
                        continue
                    }

                    this.actions[opt] = source.actions[opt]
                }

            },

            mapDetailOptions(source) {

                if (! source.hasOwnProperty('detail')) {
                    return
                }

                for (let opt in source.detail) {

                    if (RECOGNIZED_DETAIL_OPTIONS.indexOf(opt) < 0) {
                        continue
                    }

                    this.detail[opt] = source.detail[opt]
                }

            },

            prepareModalEvents() {

                let removeModal = $(this.removeModalId)

                removeModal.on('hidden.bs.modal', () => this.remove = [])

            },

            setTableCoverHeight() {

                let table = this.$refs.realTable
                let cover = this.$refs.cover
                let coverContent = cover.querySelector('.table-cover-content')

                this.setDimension(cover, table)
                this.setDimension(coverContent, table)

            },

            setDimension(thisOne, likeThisOne) {
                thisOne.style.width = likeThisOne.offsetWidth + 'px';
                thisOne.style.height = likeThisOne.offsetHeight + 'px';
            },

            removeChecked() {
                alert('remove all checked')
            },

            customAction(action, id) {
                this.$emit(action, id)
            },

            customDetailAction(action, parentId, id) {
                this.$emit(action, parentId, id)
            },

            checkAll() {

                let checkables = this.$refs.checkables
                
                if (! this.allIsChecked) {
                    checkables = checkables.filter(checkable => ! checkable.checked)
                }

                for (let checkable of checkables) {
                    checkable.check()
                }                

            },

            refresh() {
                alert('refresh')
            },

            sort(index) {
                alert('sort by ' + this.columns[index])
            },

            check(row) {

                let id = row.identifier
                let index = this.checked.indexOf(id)

                if (index < 0) {
                    this.checked.push(id)
                } else {
                    this.checked.splice(index, 1)
                }

            },

            update(id) {
                return this.forms.update.replace('?', id) 
            },

            preRemove(id) {

                let index = this.data.findIndex(piece => piece.id === id)

                if (index >= 0) {
                    this.removable.push(this.data[index])
                }

            },

            remove() {

                this.$emit('remove', this.removable)

                $(this.removeModalId).modal('hide')

            },

            showDetail(id) {

                let detail = $('#collapse-' + id + '-detail')

                if (this.detailIsShown) {

                    detail.collapse('hide')

                    this.detailIsShown = false

                    return

                }

                detail.collapse('show')

                this.detailIsShown = true

                this.$emit('detail-shown', id)

            },

            prevPage() {
                alert('previous page')
            },

            page(n) {
                alert('page ' + n)
            },

            nextPage() {
                alert('next page')
            },

            cellIsImg(cell) {
                return typeof cell === 'string' && cell.indexOf('img:') >= 0
            },

        },

        components: {
            'dropdown': Dropdown,
            'tabulation-row': TabulationRow
        }
    }

</script>
