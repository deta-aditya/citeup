
import _ from 'lodash'

const DICTIONARY = {
    'alerts':           { keyName: 'Kelola Notifikasi', navName: 'Notifikasi', icon: 'bell' },
    'activities':       { keyName: 'Kelola Acara', navName: 'Acara', icon: 'bullhorn' },
    'schedules':        { keyName: 'Kelola Jadwal' },
    'entries':          { keyName: 'Kelola Peserta', navName: 'Peserta', icon: 'user' },
    'submissions':      { keyName: 'Kelola Submisi', navName: 'Submisi', icon: 'paper-plane' },
    'documents':        { keyName: 'Kelola Dokumen', navName: 'Dokumen', icon: 'folder' },
    'testimonials':     { keyName: 'Kelola Testimoni', navName: 'Testimoni', icon: 'star' },
    'attempts':         { keyName: 'Kelola Percobaan (Quiz)' },
    'questions':        { keyName: 'Kelola Pertanyaan (Quiz)', navName: 'Quiz', icon: 'map-signs' },
    'choices':          { keyName: 'Kelola Pilihan (Quiz)' },
    'answers':          { keyName: 'Kelola Jawaban (Quiz)'  },
    'galleries':        { keyName: 'Kelola Galeri', navName: 'Galeri', icon: 'picture-o' },
    'news':             { keyName: 'Kelola Berita', navName: 'Berita', icon: 'file-text' },
    'sponsors':         { keyName: 'Kelola Sponsor', navName: 'Sponsor', icon: 'handshake-o' },
    'faqs':             { keyName: 'Kelola FAQ', navName: 'FAQ', icon: 'question-circle' },
    'contact-people':   { keyName: 'Kelola Contact Person', navName: 'Contact Person', icon: 'phone' },
    'html-contents':    { keyName: 'Kelola Konten', navName: 'Konten', icon: 'archive' },
    'edits':            { keyName: 'Lihat Suntingan', navName: 'Suntingan', icon: 'pencil-square-o' },
}

export default {
    filters: {
        translateKeyName(value) {
            return DICTIONARY.hasOwnProperty(value) ? DICTIONARY[value].keyName : 'Tidak Diketahui'
        },
    },
    methods: {
        mapKeys(raw) {
            var ripe = []
            let prefix = 'null'
            let latest = {}

            for (let item of raw) {
                let sliced = item.slug.split('-').slice(1)
                let joined = sliced.join('-')

                if (sliced.length === 2 && ! (joined === 'contact-people' || joined === 'html-contents') || item.slug.endsWith('users'))
                    continue

                if (item.slug.endsWith(prefix)) {
                    latest.items.push(item)
                    continue
                }

                if (! _.isEmpty(latest)) 
                    ripe.push(latest)

                prefix = joined
                latest = { slug: prefix, items: [ item ] }
            }

            ripe.push(latest)

            return ripe
        },
        getNavs(keys) {
            return this.mapKeys(keys).filter(item => {
                return DICTIONARY.hasOwnProperty(item.slug) 
                    && DICTIONARY[item.slug].hasOwnProperty('navName')
            }).map(item => {
                return {
                    name: DICTIONARY[item.slug].navName,
                    icon: DICTIONARY[item.slug].icon,
                }
            })
        },
    },
}
