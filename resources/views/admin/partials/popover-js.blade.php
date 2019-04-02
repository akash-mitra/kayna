<script>
    /**
     * Popper invocation for user menu
     */
    let ref = document.querySelector('#user-ref')
    let popup = document.querySelector('#popup')
    let popper = null
    document.onclick = function(e) {
        if (e.target.classList.contains('popup-opener')) {
            e.preventDefault();
            popup.style.display = popup.style.display === 'none' ? 'block' : 'none'
            popper = new Popper(ref, popup, {
                placement: 'auto',
                modifiers: {
                    offset: {
                        enabled: true,
                        offset: '0px, 5px'
                    }
                }
            });
        } else {
            popup.style.display = 'none'
            popper.destroy()
        }
    }
</script> 