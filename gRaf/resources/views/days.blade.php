@extends("app")

@section('days')

@stop

@section("content")
    <div class="row box">
        <div class="col-sm-3 col-xs-7">
            <h1>{{ $city }}</h1>
            <h2>{{ $country }}</h2>
            <p>{{ $lat }} / {{ $lng }}</p>
        </div>
        <div class="col-sm-3 col-xs-7">
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>You trip plan</h3>
        </div>
        <div class="col-xs-8">
              <ul class="timeline">
                  <li class="timeline-node">
                      <a class="btn btn-primary">START</a>
                  </li>

                  @if(count($days) > 0)
                          @foreach($days as $date => $day)
                          <li class="timeline-node">
                              <button data-time="{{$date}}"
                                  class="markersOnTimeline btn btn-primary"

                              >{{$date}}
                              </button>
                          </li>

                          <li>
                            <div class="timeline-datetime">
                                <span class="timeline-time">
                                    {{$date}}
                                </span>
                            </div>
                            <div class="timeline-badge blue">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-header bordered-bottom bordered-blue">
                                  <span class="col-xs-offset-1 timeline-title">
                                    Weather
                                  </span>
                                </div>
                                <div class="timeline-body">
                                  <div class="row">
                                    <div class=" col-xs-offset-1 col-xs-10">
                                      <div class="databox databox-lg databox-halved radius-bordered databox-shadowed databox-vertical">
                                          <div class="databox-top myBlue no-padding">
                                              <div class="databox-icon">
                                                  <i class="wi wi-cloudy-windy"></i>
                                              </div>
                                          </div>
                                          <div class="databox-bottom bg-white no-padding">
                                              <div class="databox-row text-align-center">
                                                  <div class="databox-cell cell-6 bordered-right bordered-platinum padding-5">
                                                      <span class="databox-number lightcarbon">{{ $weather[$date]["minTempC"]  }}°</span>
                                                      <span class="databox-header lightcarbon"><i class="wi wi-strong-wind"></i></span>
                                                  </div>
                                                  <div class="databox-cell cell-6 padding-5">
                                                      <span class="databox-number lightcarbon">{{ $weather[$date]["maxTempC"] }}°</span>
                                                      <span class="databox-header lightcarbon"><i class="wi wi-rain"></i></span>

                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>

                          </li>

                          @foreach($day as $x)
                            <li>
                              <div class="timeline-datetime">
                                  <span class="timeline-time">
                                      {{$date}}
                                  </span>
                              </div>
                              <div class="timeline-badge blue">
                                  <i class="fa fa-tag"></i>
                              </div>
                              <div class="timeline-panel">
                                  <div class="timeline-header bordered-bottom bordered-blue">
                                      <span class="col-xs-offset-1 timeline-title">
                                          {{$x["name"]}}
                                      </span>
                                      <p class="timeline-datetime">
                                          <small class="text-muted">
                                              <i class="glyphicon glyphicon-time">
                                              </i>
                                              <span class="timeline-date">Today</span>
                                              -
                                              <span class="timeline-time">8:19</span>
                                          </small>
                                      </p>
                                  </div>
                                  <div class="timeline-body">
                                    <div class="row">
                                      <div class=" col-xs-offset-1 col-xs-10">
                                        @if($x["photo"] != "")
                                            <img style="width:100%" src="{{ $x["photo"] }}">
                                        @endif
                                      </div>
                                    </div>
                                  </div>
                              </div>

                          </li>
                          @endforeach
                          @endforeach
                  @endif

                  <li class="timeline-node">
                      <a class="btn btn-danger">FINISH</a>
                  </li>
              </ul>
        </div>
        <div class="col-xs-4">
            <div id="cityMapDashboard"></div>
        </div>
    </div>


@stop

@section('js')
    var lat = {{ $lat }};
    var lng = {{ $lng }};
    var mapID = "cityMapDashboard";


@stop

@section('scripts')
    <script src="js/map.js"></script>
@stop