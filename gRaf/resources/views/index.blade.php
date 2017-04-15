@extends("app")


@section('days')
    <ul id="rig">
        <li>
            <a class="rig-cell" href="http://graf.dev/location?city=New%20York%20City&from=06-11-2016&to=10-11-2016">
                <img class="rig-img" src="images/NewYork1.jpg">
                <span class="rig-overlay"></span>
                <span class="rig-text">New York</span>
            </a>
        </li>
        <li>
            <a class="rig-cell" href="http://graf.dev/location?city=San%20Francisco&from=06-11-2016&to=10-11-2016">
                <img class="rig-img" src="images/NewYork3.jpeg">
                <span class="rig-overlay"></span>
                <span class="rig-text">San Francisco</span>
            </a>
        </li>
        <li>
            <a class="rig-cell" href="http://graf.dev/location?city=Chicago&from=06-11-2016&to=10-11-2016">
                <img class="rig-img" src="images/NewYork2.jpg">
                <span class="rig-overlay"></span>
                <span class="rig-text">Chicago</span>
            </a>
        </li>
        <li>
            <a class="rig-cell" href="http://graf.dev/location?city=London&from=06-11-2016&to=10-11-2016">
                <img class="rig-img" src="images/London1.jpg">
                <span class="rig-overlay"></span>
                <span class="rig-text">London</span>
            </a>
        </li>
        <li>
            <a class="rig-cell" href="http://graf.dev/location?city=Belgrade&from=06-11-2016&to=10-11-2016">
                <img class="rig-img" src="images/London2.jpg">
                <span class="rig-overlay"></span>
                <span class="rig-text">Belgrade</span>
            </a>
        </li>
        <li>
            <a class="rig-cell" href="http://graf.dev/location?city=Paris&from=06-11-2016&to=10-11-2016">
                <img class="rig-img" src="images/London3.jpg">
                <span class="rig-overlay"></span>
                <span class="rig-text">Paris</span>
            </a>
        </li>
        <li>
            <a class="rig-cell" href="http://graf.dev/location?city=Bratislava&from=06-11-2016&to=10-11-2016">
                <img class="rig-img" src="images/Viena1.jpg">
                <span class="rig-overlay"></span>
                <span class="rig-text">Bratislava</span>
            </a>
        </li>
        <li>
            <a class="rig-cell" href="http://graf.dev/location?city=Prague&from=06-11-2016&to=10-11-2016">
                <img class="rig-img" src="images/Prague2.jpg">
                <span class="rig-overlay"></span>
                <span class="rig-text">Prague</span>
            </a>
        </li>
        <li>
            <a class="rig-cell" href="http://graf.dev/location?city=Wien&from=06-11-2016&to=10-11-2016">
                <img class="rig-img" src="images/Prague1.jpg">
                <span class="rig-overlay"></span>
                <span class="rig-text">Viena</span>
            </a>
        </li>
    </ul>
@stop

@section("content")



@stop

@section('scripts')
    <script src="js/app.js"></script>
@stop
