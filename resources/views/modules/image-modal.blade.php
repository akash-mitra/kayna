<div class="fixed pin-t pin-l w-full h-full flex justify-center items-center overflow-auto" style="background: rgba(0,0,0, 0.75); display: none" id="img-overlay">
        <!-- <div class="relative overflow-auto"> -->
            <img id="modal-image" src="#" />
        <!-- </div> -->
</div>
<script>
        const modal = document.getElementById('img-overlay');
        const modalImage = document.getElementById('modal-image');
        const closeModal = function () {
            modal.style.display = 'none'
            modalImage.src = '#'
        }

        const showImageModal = function (imageUrl) {
            modal.style.display = 'flex'
            modalImage.src = imageUrl
        }

        /**
         * Shows the modal when clicked on an image
         */
        const mainElement = document.getElementsByTagName("MAIN")[0]
        mainElement.addEventListener('click', function (e) {
            // close if clicked on image overlay
            if (e.target.id === 'img-overlay') {closeModal()}

            // show modal if clicked on an image
            if(e.target.tagName.toUpperCase() === 'IMG' && !e.target.classList.contains('no-modal')) {
                showImageModal(e.target.src)
            }
        })

        /**
         * Closes the Escape key event and closes the modal if escape
         * if pressed
         */
        document.onkeydown = function(evt) {
            evt = evt || window.event;
            var isEscape = false;
            if ("key" in evt) {
                isEscape = (evt.key === "Escape" || evt.key === "Esc");
            } else {
                isEscape = (evt.keyCode === 27);
            }
            if (isEscape) {
                closeModal()
            }
        };
        
</script>