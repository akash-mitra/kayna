@extends('admin.layout')

@section('css')
<link href='https://metricsgraphicsjs.org/metricsgraphics.css' rel='stylesheet' type='text/css'>
<style>
    .chart-container {
        position: relative;
        width: 80vw;
        /* height: 10px; */
    }

    @media only screen and (max-width: 760px) {
        .chart-container {
            position: relative;
            width: 100vw;
            /* height: 10px; */
        }
    }
</style>
@endsection

@section('header')
<div class="px-6 py-4">
    <h1 class="w-full py-2">
        <span class="text-lg font-light text-indigo-dark uppercase">
            Dashboard
        </span>
    </h1>
</div>
@endsection


@section('main')

<div class="py-4 w-full">


    <div class="relative mx-auto chart-container">
        <div class="px-6 sm:flex">
            <div class="flex items-center mt-1 mr-6 p-4 bg-white border-b shadow rounded-lg">
                <div class="px-4 text-5xl font-mono text-teal font-light">{{ $growth[count($growth)-1]->users_total }}</div>
                <div class="px-2">
                    <p class="text-teal font-semibold text-xl">Users</p>
                    <p class="my-2 text-teal-darker text-xs">{{ $recentGrowth['users'] }} in last 7 days</p>
                </div>
            </div>
            <div class="flex items-center mt-1 mr-6 p-4 bg-white border-b shadow rounded-lg">
                <div class="px-4 text-5xl font-mono text-indigo">{{ $growth[count($growth)-1]->pages_total }}</div>
                <div class="px-2">
                    <p class="text-indigo-light font-semibold text-xl">Pages</p>
                    <p class="my-2 text-indigo-darker text-xs">{{ $recentGrowth['pages'] }} in last 7 days</p>
                </div>
            </div>
            <div class="flex items-center mt-1 mr-6 p-4 bg-white border-b shadow rounded-lg">
                <div class="px-4">
                    <span class="text-5xl font-mono text-blue">12</span>
                    <span class="text-2xl text-blue-light">K</span>
                </div>
                <div class="px-2">
                    <p class="text-blue font-semibold text-xl">Monthly Views</p>
                    <p class="my-2 text-blue-darker text-xs">225 in last 7 days</p>
                </div>
            </div>
        </div>

        <div class="hidden sm:block -mt-4 result w-full" id="plot"></div>
        <div class="legend w-1/2 mx-auto flex justify-between h-0" style="display: none"></div>
    </div>

</div>



@endsection

@section('script')

<script>
    //     new Vue({
    //         el: 'main',
    //         data: {},
    //         computed: {},
    //         methods: {}
    //     })
</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script> -->
<script src="https://d3js.org/d3.v4.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/metrics-graphics/2.15.6/metricsgraphics.min.js" integrity="sha256-QFwUntQpro6H+h/btQ+8nVVDqeZnVQSuqsTTUGz2o44=" crossorigin="anonymous"></script> -->
<script src='https://metricsgraphicsjs.org/js/MG.js'></script>
<script src='https://metricsgraphicsjs.org/js/misc/utility.js'></script>
<script src='https://metricsgraphicsjs.org/js/common/data_graphic.js'></script>
<script src='https://metricsgraphicsjs.org/js/common/hooks.js'></script>
<script src='https://metricsgraphicsjs.org/js/common/register.js'></script>
<!-- <script src='https://metricsgraphicsjs.org/js/common/bootstrap_tooltip_popover.js'></script> -->
<script src='https://metricsgraphicsjs.org/js/common/chart_title.js'></script>
<script src='https://metricsgraphicsjs.org/js/common/scales.js'></script>
<script src='https://metricsgraphicsjs.org/js/common/y_axis.js'></script>
<script src='https://metricsgraphicsjs.org/js/common/x_axis.js'></script>
<script src='https://metricsgraphicsjs.org/js/common/init.js'></script>
<script src='https://metricsgraphicsjs.org/js/common/markers.js'></script>
<script src='https://metricsgraphicsjs.org/js/common/rollover.js'></script>
<!-- <script src='https://metricsgraphicsjs.org/js/common/zoom.js'></script> -->
<!-- <script src='https://metricsgraphicsjs.org/js/common/brush.js'></script> -->
<script src='https://metricsgraphicsjs.org/js/common/window_listeners.js'></script>
<!-- <script src='https://metricsgraphicsjs.org/js/layout/bootstrap_dropdown.js'></script> -->
<!-- <script src='https://metricsgraphicsjs.org/js/layout/button.js'></script> -->
<script src='https://metricsgraphicsjs.org/js/charts/line.js'></script>
<!-- <script src='https://metricsgraphicsjs.org/js/charts/histogram.js'></script> -->
<!-- <script src='https://metricsgraphicsjs.org/js/charts/point.js'></script> -->
<!-- <script src='https://metricsgraphicsjs.org/js/charts/bar.js'></script> -->
<!-- <script src='https://metricsgraphicsjs.org/js/charts/table.js'></script> -->
<!-- <script src='https://metricsgraphicsjs.org/js/charts/missing.js'></script> -->
<script src='https://metricsgraphicsjs.org/js/misc/process.js'></script>
<!-- <script src='https://metricsgraphicsjs.org/js/misc/smoothers.js'></script> -->
<script src='https://metricsgraphicsjs.org/js/misc/formatters.js'></script>
<!-- <script src='https://metricsgraphicsjs.org/js/misc/transitions.js'></script> -->
<!-- <script src='https://metricsgraphicsjs.org/js/misc/error.js'></script> -->
<script>
    let data = @json($growth);

    MG.convert.date(data, 'date', '%Y-%m-%d');

    MG.data_graphic({
        // title: "UFO Sightings",
        // description: "Yearly UFO sightings from 1945 to 2010.",
        data: data,
        // markers: [{
        //     'year': 1964,
        //     'label': '"The Creeping Terror" released'
        // }],
        // width: 800,
        full_width: true,
        height: 300,
        right: 40,
        left: 40,
        // x_extended_ticks: true,
        // height: 500,
        target: ".result",
        x_accessor: "date",
        y_accessor: ["pages_total", "users_total"],
        y_axis: false,
        // xax_count: 5,
        area: [true, true],
        aggregate_rollover: true,
        legend: ['Pages added', 'New Users Joined'],
        legend_target: '.legend',
        show_tooltips: false
    });
</script>

@endsection 