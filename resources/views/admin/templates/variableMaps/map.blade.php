<!-- This file needs to be changed in rare cases when/if a new content type is introduced -->
@includeWhen($type === 'home', 'admin.templates.variableMaps.var-map-home')
@includeWhen($type === 'category', 'admin.templates.variableMaps.var-map-category')
@includeWhen($type === 'page', 'admin.templates.variableMaps.var-map-page')
@includeWhen($type === 'profile', 'admin.templates.variableMaps.var-map-profile')