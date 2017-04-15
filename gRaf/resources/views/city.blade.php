@extends("app")

@section('days')

@stop

@section("content")

    <div class="row box">
        <div class="col-md-12">
            <h1>{{ $city }}, {{ $country }}</h1>
        </div>
        <p class="col-md-12">{{$wiki->summary}}</p>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>Choose hotels you may reside in</h3>
        </div>
    </div>

    <div class="container-fluid">
    <div class="row equal" >
        @if(count($hotels) > 0)
            <?php $i = 0; ?>
            @foreach($hotels as $hotel)
                <div class="col-xs-3 panel">
                  <div class="thumbnail">
                    <img src="{{$hotel["image"]}}" alt="...">
                    <div class="caption">
                      <h3>{{$hotel["name"]}}</h3>
                      <p>{{$hotel["description"]}}</p>
                      <p><a href="{{$hotel["link"]}}" target="_blank" class="btn btn-primary" role="button">Reservate</a></p>
                    </div>
                  </div>
                </div>
                @break($i++ > 2)
              @endforeach
          @endif
      </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>Choose places you must visit</h3>
        </div>


        <div class="row" >
          <div class="col-md-12">
            <div class="carousel slide" id="myCarousel">
              <div class="carousel-inner">
                @if(count($places) > 0)
                  <?php $i = 0; ?>
                      @foreach($places as $k => $place)
                        <?php $i ++ ?>
                        <div class="item {{($i == 1) ? 'active' : ''}}">
                          <div class="col-md-4 place" data-id="{{$place["placeID"]}}" data-name="{{$place["name"]}}" data-lat="{{$place["lat"]}}" data-lng="{{$place["lng"]}}">
                            <a href="#">
                              @if($place["photo"] != "")
                                  <img src="{{ $place["photo"] }}" class="place-photo img-responsive" style="max-height: 200px">
                              @endif
                              </a>
                              <div class="panel-info">
                                  <p><strong>{{ $place["name"] }}</strong></p>

                                  <div class="panel-rating">

                                      <?php
                                          for ($i = 0; $i < $place["rating"]; $i++) {
                                          ?>
                                              <span class="glyphicon glyphicon-star"></span>
                                          <?php
                                          }
                                          for ($i = $place["rating"]; $i < 5; $i++) {
                                          ?>
                                          <span class="glyphicon glyphicon-star-empty"></span>
                                          <?php
                                          }
                                      ?>

                                      <span class="like glyphicon glyphicon-heart-empty"></span>
                                  </div>

                              </div>
                          </div>
                        </div>
                        @endforeach
                    @endif

                  </div>
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
                </div>
              </div>
            </div>


        <div class="row">
            <button class="col-xs-offset-3 col-xs-6 btn btn-primary" style="margin-top:30px;margin-bottom:30px;" data-toggle="modal" data-target="#myModal">Get plan</button>

        </div>
    </div>

    <div id="cityMap"></div>

    <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Choose hours</h4>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-xs-12">
                  <h5>How many hours would you like to go around the city each day?</h5>
              </div>
              @foreach($days as $date => $day)
                  <div class="days col-xs-6">
                      <div class="form-group">
                          <label for="">{{$date}}</label>
                          <input type="text" class="form-control days-hours" placeholder="Number of hours">
                      </div>
                  </div>
              @endforeach
          </div>
        </div>
        <div class="modal-footer">
          {!! Form::open(['url' => 'days', 'method' => 'get',  'id'=>'planForm']) !!}
          {!! Form::hidden('city', $city) !!}
          {!! Form::hidden('from', $from) !!}
          {!! Form::hidden('to', $to) !!}
          {!! Form::hidden('places', "", ["id" => "places"]) !!}
          {!! Form::hidden('times', "", ["id" => "times"]) !!}
          {!! Form::submit('Get plan', ['class'=>'col-xs-offset-1 col-xs-10 btn btn-primary', 'style'=>'margin-bottom:10px']) !!}
          {!! Form::close() !!}
        </div>
      </div>

    </div>
  </div>

@stop

@section('js')
    var lat = {{ $lat }};
    var lng = {{ $lng }};
    var mapID = "";
@stop

@section('scripts')
    <script src="js/app.js"></script>
    <script>
    $('#myCarousel').carousel({
      interval: 10000
      })

      $('.carousel .item').each(function(){
      var next = $(this).next();
      if (!next.length) {
        next = $(this).siblings(':first');
      }
      next.children(':first-child').clone().appendTo($(this));

      if (next.next().length>0) {
        next.next().children(':first-child').clone().appendTo($(this));
      }
      else {
        $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
      }
      });

    </script>
@stop
