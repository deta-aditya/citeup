
const STAGES = {
    0: {
        1: 'Baru Mendaftar',
        2: 'Baru Mendaftar',
        3: 'Baru Mendaftar',
    },
    1: {
        1: 'Tahap Penyisihan',
        2: 'Tahap Penyisihan',
        3: 'Siap Mengikuti Seminar',
    },
    2: {
        1: 'Telah Mengikuti Penyisihan',
        2: 'Telah Mengirim Submisi',
    },
    3: {
        1: 'Finalis',
        2: 'Finalis',        
    },
    4: {
        1: 'Pemenang',
        2: 'Pemanang',        
    }
}

export default {
    filters: {
        translateStage(stage, activity) {
            return STAGES[stage][activity]
        },
    }
}