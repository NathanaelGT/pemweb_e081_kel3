const airDatepickerLocale = {
    days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
    daysShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
    daysMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
    months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
    today: 'Hari ini',
    clear: 'Hapus',
    dateFormat: 'dd/MM/yyyy',
    timeFormat: 'hh:mm aa',
    firstDay: 1
}

const xIcon = '<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>'

document.querySelectorAll('.info').forEach(info => {
    info.insertAdjacentHTML('beforeend', xIcon)

    info.addEventListener('click', event => {
        let tag = event.target
        while (tag !== info) {
            if (tag.tagName === 'svg') {
                info.remove()
                break
            }

            tag = tag.parentElement
        }
    })
})

document.querySelectorAll('.input').forEach(inputable => {
    if (inputable.tagName === 'INPUT') {
        return
    }

    const input = inputable.querySelector('input')
    if (input === null) {
        return
    }

    inputable.addEventListener('click', event => {
        if (event.target !== input) {
            input.focus()
        }
    })
})

Array.from(document.querySelectorAll('a')).filter(a => a.href.includes('hapus'))
    .filter(a => a.href.includes('hapus'))
    .map(a => {
        a.onclick = () => confirm('Apakah Anda yakin ingin menghapus data ini?')
    })
