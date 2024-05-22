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

        console.log(event.target)
    })
})