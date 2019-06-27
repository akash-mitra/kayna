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