<p class="font-bold py-4 mt-6">
        <span class="font-mono text-red cursor-pointer p-2">category</span> Object
</p>
<p>
        Category object contains following properties / attributes.
</p>

<table class="w-full mt-2 bg-white shadow rounded text-left table-collapse text-xs">
        <tbody  class="align-baseline">
                <tr class="border-b hover:bg-grey-lightest">
                        <td class="variable font-mono text-red cursor-pointer p-2">name</td>
                        <td><p>Name of the catgeory</p></td>
                </tr>
                <tr class="border-b hover:bg-grey-lightest">
                        <td class="variable font-mono text-red cursor-pointer p-2">description</td>
                        <td><p>Description of the category (can be NULL)</p></td>
                </tr>
                <tr class="border-b hover:bg-grey-lightest">
                        <td class="variable font-mono text-red cursor-pointer p-2">url</td>
                        <td><p>URL pointing to this category</p></td>
                </tr>
                <tr class="border-b hover:bg-grey-lightest">
                        <td class="variable font-mono text-red cursor-pointer p-2">created_ago</td>
                        <td><p>How long ago was the category created</p></td>
                </tr>
                <tr class="border-b hover:bg-grey-lightest">
                        <td class="variable font-mono text-red cursor-pointer p-2">updated_ago</td>
                        <td><p>How long ago was the category last updated</p></td>
                </tr>
                <tr class="border-b hover:bg-grey-lightest">
                        <td class="variable font-mono text-red cursor-pointer p-2">subcategories</td>
                        <td><p>An array containing all the sub-categories under this category. 
                            Each sub-category inside contains the same attributes as that of a category.</p></td>
                </tr>
                <tr class="border-b hover:bg-grey-lightest">
                        <td class="variable font-mono text-red cursor-pointer p-2">parent</td>
                        <td><p>The parent category of this category. If this category is the top level category, then this will be NULL</p></td>
                </tr>
                <tr class="border-b hover:bg-grey-lightest">
                        <td class="variable font-mono text-red cursor-pointer p-2">pages</td>
                        <td><p>An array of pages inside this category. </p></td>
                </tr>
                
        </tbody>
</table>