@if($type === 'home')
<div class="w-full text-sm">
        <p class="py-4 text-grey-darker">These are the list of variables that can be displayed in this page. Click on the variable name to insert it in the current cursor position in the code editor.</p>
        <p class="font-bold py-4 mt-4">
                <span class="font-mono text-red cursor-pointer p-2">pages</span> Object
        </p>
        <p>
                This is a pagination object with following properties.
        </p>
        <table class="w-full mt-2 bg-white shadow rounded text-left table-collapse text-xs">
                <tbody  class="align-baseline">
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">first_page_url</td>
                                <td><p>URL of the beginning page</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">last_page_url</td>
                                <td><p>URL of the ending page, if there are multiple pages</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">next_page_url</td>
                                <td><p>URL of the next page (nullable)</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">prev_page_url</td>
                                <td><p>URL of the previous page (nullable)</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">total</td>
                                <td><p>Total number of pages available</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">per_page</td>
                                <td><p>Number of items available per page</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">data</td>
                                <td><p>An array of <code class="font-mono text-red">page</code>s. <code class="font-mono text-red">page</code> object is described below.</p></td>
                        </tr>
                </tbody>
        </table>

        <p class="font-bold py-4 mt-6">
                <span class="font-mono text-red cursor-pointer p-2">page</span> Object
        </p>
        <p>
                Each page containing inside the data array has following properties.
        </p>

        <table class="w-full mt-2 bg-white shadow rounded text-left table-collapse text-xs">
                <tbody  class="align-baseline">
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">title</td>
                                <td><p>Title of the page</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">summary</td>
                                <td><p>Summary of the page</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">metakey</td>
                                <td><p>A comma separated list of meta keys assigned to this page</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">metadesc</td>
                                <td><p>A short meta description of the page</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">media_url</td>
                                <td><p>An URL pointing to the main image of the page. This can be empty.</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">created_at</td>
                                <td><p>Date and time when the page was created</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">ago</td>
                                <td><p>How long ago the page was created or last updated.</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">url</td>
                                <td><p>URL of the page</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">category.name</td>
                                <td><p>Name of the category where this page belong</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">category.description</td>
                                <td><p>Name of the category where this page belong</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">category.url</td>
                                <td><p>URL of the category where this page belong</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">category.created_ago</td>
                                <td><p>How long ago was the category of this page last created</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">category.updated_ago</td>
                                <td><p>How long ago was the category of this page last updated</p></td>
                        </tr>
                </tbody>
        </table>


        <p class="font-bold py-4 mt-4">
                <span class="font-mono text-red cursor-pointer p-2">common</span> Object
        </p>
        <p>
                These are the list of common properties or site attributes that accessible in this page
        </p>
        <table class="w-full mt-2 bg-white shadow rounded text-left table-collapse text-xs">
                <tbody  class="align-baseline">
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">sitename</td>
                                <td><p>Name of the site</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">sitetitle</td>
                                <td><p>A one-liner title for your site as defined in the settings</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">metadesc</td>
                                <td><p>A common meta description for your site as defined in the backend settings</p></td>
                        </tr>
                        <tr class="border-b hover:bg-grey-lightest">
                                <td class="variable font-mono text-red cursor-pointer p-2">metakey</td>
                                <td><p>A list of common meta keys for your site as defined in the backend settings</p></td>
                        </tr>
                </tbody>
        </table>
        <p class="my-2">&nbsp;</p>
</div>
@endif