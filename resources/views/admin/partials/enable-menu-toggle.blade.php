<script>
    /**
     * This code is for creating the left side menu toggle 
     * behavior. 
     */
    let toggleMenu = function() {
        let menu_list = document.getElementsByClassName('menu-list');
        for (let i = 0; i < menu_list.length; i++) {
            menu_list[i].classList.toggle("hidden");
        }
    }
</script> 