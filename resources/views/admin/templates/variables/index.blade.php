<div class="w-full text-sm">
    
    <p class="py-4 text-grey-darker">These are the list of variables that can be displayed in this page. Click on the variable name to insert it in the current cursor position in the code editor.</p>

        <!-- These are the various variables available in "home" templates -->
        @includeWhen($type === 'home', 'admin.templates.variables.pages')

        @includeWhen($type === 'home', 'admin.templates.variables.page')

        @includeWhen($type === 'home', 'admin.templates.variables.common')


        <!-- These are the various variables available in "category" templates -->
        @includeWhen($type === 'category', 'admin.templates.variables.category')
        
        @includeWhen($type === 'category', 'admin.templates.variables.page')
        
        @includeWhen($type === 'category', 'admin.templates.variables.common')


        <!-- These are the various variables available in "page" templates -->
        @includeWhen($type === 'page', 'admin.templates.variables.page')

        @includeWhen($type === 'page', 'admin.templates.variables.category')

        @includeWhen($type === 'page', 'admin.templates.variables.author')

        @includeWhen($type === 'page', 'admin.templates.variables.common')


        <!-- These are the various variables available in "profile" templates -->
        @includeWhen($type === 'profile', 'admin.templates.variables.author')

        @includeWhen($type === 'profile', 'admin.templates.variables.common')


    <p class="my-2">&nbsp;</p>

</div>


