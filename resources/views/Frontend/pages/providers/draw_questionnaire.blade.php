@if(!empty($questionnaire))
<div class="wizard-inner">
    <ul class="nav nav-tabs" role="tablist">
        @foreach($questionnaire as $item=>$value)
            <li role="presentation" class="{{ ($loop->first) ? 'active' : 'disabled' }}">
                <a href="#step{{$item}}" data-toggle="tab" aria-controls="step{{$item}}" role="tab" title="Step {{$item}}">
                  <span class="round-tab">
                    <i class="fas fa-user-md"></i>
                  </span>
                </a>
            </li>
        @endforeach
        <li role="presentation" class="disabled">
            <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
              <span class="round-tab">
                <i class="fas fa-user-md"></i>
              </span>
            </a>
        </li>
    </ul>
</div>

<div class="tab-content">
    @foreach($questionnaire as $key=>$questions)
        <div class="tab-pane {{ ($loop->first) ? 'active' : '' }}" role="tabpanel" id="step{{$key}}">
            <div class="row">
            @foreach($questions as $question)
                @if($question->type ==0)
                    {{--Text Input--}}
                    <div class="col-sm-12 col-md-6">
                        <div class="check_content">
                            <h3>{{ $question->title }}</h3>
                            <aside class="radio_input">
                                @foreach(unserialize($question->options) as $radio_number=>$radio_value)
                                    <label for="IDR{{$radio_number}}"><input id="IDR{{$radio_number}}" type="radio" name="answer[{{$question->id}}]" value="{{$radio_number}}" placeholder="{{$question->subtitle}}" {{ ($question->is_required==1)?'required' : '' }}>
                                        <span>{{$radio_value}}</span>
                                    </label>
                                @endforeach
                            </aside>
                        </div>
                    </div>
                @endif

                @if($question->type ==1)
                    {{--Text Input--}}
                    <div class="col-sm-12 col-md-6">
                        <h3>{{ $question->title }}</h3>
                        @foreach(unserialize($question->options) as $checkbox_number=>$checkbox_value)
                            <label class="checkbox_input"><input type="checkbox" name="answer[{{$question->id}}][]" value="{{$checkbox_number}}" placeholder="{{$question->subtitle}}" {{ ($question->is_required==1)?'required' : '' }}>
                                <span>{{$checkbox_value}}</span>
                            </label>
                        @endforeach
                    </div>
                @endif

                @if($question->type ==2)
                    {{--Text Input--}}
                    <div class="col-sm-12 col-md-6">
                        <h3>{{ $question->title }}</h3>
                        <input type="text" name="answer[{{$question->id}}]" placeholder="{{$question->subtitle}}" {{ ($question->is_required==1)?'required' : '' }}>
                    </div>
                @endif

                @if($question->type ==3)
                    {{--Text Input--}}
                    <div class="col-sm-12 col-md-6">
                        <h3>{{ $question->title }}</h3>
                        <textarea name="answer[{{$question->id}}]" placeholder="{{$question->subtitle}}" {{ ($question->is_required==1)?'required' : '' }}></textarea>
                    </div>
                @endif

                @if($question->type ==4)
                    {{--Text Input--}}
                    <div class="col-sm-12 col-md-6">
                        <h3>{{ $question->title }}</h3>
                        <input type="date" name="answer[{{$question->id}}]" placeholder="{{$question->subtitle}}" {{ ($question->is_required==1)?'required' : '' }}>
                    </div>
                @endif

                @if($question->type ==5)
                    {{--Text Input--}}
                    <div class="col-sm-12 col-md-6">
                        {{--@if($question->rating_symbol == 1)--}}
                            <h3>{{ $question->title }}</h3>
                            <input type="number" max="{{ $question->rating_levels }}" name="answer[{{$question->id}}]" placeholder="{{$question->subtitle}}" {{ ($question->is_required==1)?'required' : '' }}>
                        {{--@else--}}
                            {{--<div class="rating_area">--}}
                                {{--<h3>{{ $question->title }}</h3>--}}
                                {{--<section class='rating-widget'>--}}
                                    {{--<!-- Rating Stars Box -->--}}
                                    {{--<div class='rating-stars'>--}}
                                        {{--<ul id='stars'>--}}
                                            {{--<li class='star' title='Poor' data-value='1'>--}}
                                                {{--<i class='fa fa-star fa-fw'></i>--}}
                                            {{--</li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                {{--</section>--}}
                            {{--</div>--}}
                        {{--@endif--}}
                    </div>
                @endif
            @endforeach
            </div>
            <ul class="list-inline ">
                <li><button type="button" class="button next-step">حفظ واستكمال</button></li>
            </ul>
        </div>
    @endforeach
    <div class="tab-pane" role="tabpanel" id="complete">
            <!-- Start Time Booking-->
            <div class="booking_content">
                <aside class="">
                    <i class="far fa-calendar-alt"></i>
                    <span> 02 -نوفمبر - 2017 </span>
                </aside>

                <aside class="">
                    <i class="far fa-clock"></i>
                    <span> من الساعة 11 صباحا </span>
                </aside>
            </div>
            <!-- End Time Booking-->

            <!-- Start Table Details Booking-->
            <table class="table">
                <thead>

                <tr>
                    <th>الخدمــات</th>
                    <th>الوقت</th>
                    <th>السعر</th>
                </tr>

                </thead>
                <tbody>
                <tr>
                    <td>فحص اسبوعى</td>
                    <td>15 دقيقة </td>
                    <td> <span> 200 ريال</span> </td>
                </tr>
                <tr>
                    <td>فحص اسبوعى</td>
                    <td>15 دقيقة </td>
                    <td> <span> 200 ريال</span> </td>
                </tr>

                </tbody>
            </table>
            <!-- End Table Details Booking-->

            <div class="row">
                <div class="col-sm-12 col-nd-6 ">

                </div>
                <div class="col-sm-12 col-md-6 ">
                    <div class="input_content">
                        <span> رمز ترويجي</span>
                        <input type="text" name="" value="">
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 ">
                    <div class="input_content">
                        <span>القيمة المضافة</span>
                        <input type="text" name="" value="">
                    </div>
                </div>
            </div>
            <ul class="list-inline ">
                <button class="button" type="submit" name="button"> تأكيد الحجز</button>
            </ul>
</div>
    <div class="clearfix"></div>
</div>
@endif