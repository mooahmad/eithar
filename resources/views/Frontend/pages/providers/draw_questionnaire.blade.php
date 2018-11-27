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
                    {{--Radio Input--}}
                    <div class="col-sm-12 col-md-6">
                        <div class="check_content">
                            <h3>{{ $question->title }} {!! ($question->is_required==1)?'<span class="text-danger">*</span>' : '' !!}</h3>
                            <aside class="radio_input">
                                @foreach(unserialize($question->options) as $radio_number=>$radio_value)
                                    <label for="IDR{{$radio_number}}"><input id="IDR{{$radio_number}}" type="radio" name="answer[{{$question->id}}]" value="{{$radio_number}}" placeholder="{{$question->subtitle}}">
                                        <span>{{$radio_value}}</span>
                                    </label>
                                @endforeach
                            </aside>
                        </div>
                    </div>
                @endif

                @if($question->type ==1)
                    {{--checkbox Input--}}
                    <div class="col-sm-12 col-md-6">
                        <h3>{{ $question->title }} {!! ($question->is_required==1)?'<span class="text-danger">*</span>' : '' !!}</h3>
                        @foreach(unserialize($question->options) as $checkbox_number=>$checkbox_value)
                            <label class="checkbox_input"><input type="checkbox" name="answer[{{$question->id}}][]" value="{{$checkbox_number}}" placeholder="{{$question->subtitle}}">
                                <span>{{$checkbox_value}}</span>
                            </label>
                        @endforeach
                    </div>
                @endif

                @if($question->type ==2)
                    {{--Text Input--}}
                    <div class="col-sm-12 col-md-6">
                        <h3>{{ $question->title }} {!! ($question->is_required==1)?'<span class="text-danger">*</span>' : '' !!}</h3>
                        <input type="text" name="answer[{{$question->id}}]" placeholder="{{$question->subtitle}}" {{ ($question->is_required==1)?'required' : '' }}>
                    </div>
                @endif

                @if($question->type ==3)
                    {{--Textarea Input--}}
                    <div class="col-sm-12 col-md-6">
                        <h3>{{ $question->title }} {!! ($question->is_required==1)?'<span class="text-danger">*</span>' : '' !!}</h3>
                        <textarea name="answer[{{$question->id}}]" placeholder="{{$question->subtitle}}" {{ ($question->is_required==1)?'required' : '' }}></textarea>
                    </div>
                @endif

                @if($question->type ==4)
                    {{--Date Input--}}
                    <div class="col-sm-12 col-md-6">
                        <h3>{{ $question->title }} {!! ($question->is_required==1)?'<span class="text-danger">*</span>' : '' !!}</h3>
                        <input type="date" name="answer[{{$question->id}}]" placeholder="{{$question->subtitle}}" {{ ($question->is_required==1)?'required' : '' }}>
                    </div>
                @endif

                @if($question->type ==5)
                    {{--Rating Input--}}
                    <div class="col-sm-12 col-md-6">
                        @if($question->rating_symbol == 1)
                            <h3>{{ $question->title }} {!! ($question->is_required==1)?'<span class="text-danger">*</span>' : '' !!}</h3>
                            <input type="number" max="{{ $question->rating_levels }}" name="answer[{{$question->id}}]" placeholder="{{$question->subtitle}}" {{ ($question->is_required==1)?'required' : '' }}>
                        @else
                            <div class="rating_area">
                                <h3>{{ $question->title }} {!! ($question->is_required==1)?'<span class="text-danger">*</span>' : '' !!}</h3>
                                <section class='rating-widget'>
                                    <!-- Rating Stars Box -->
                                    <div class='rating-stars'>
                                        <ul id='stars'>
                                            @for ($i = 1; $i <= $question->rating_levels; $i++)
                                                <li class="star fa" title="{{$i}}" data-value="{{$i}}">
                                                    <i class="fa fa-star fa-fw">
                                                        <input type="radio" name="answer[{{$question->id}}]" value="{{$i}}">
                                                    </i>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </section>
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
            </div>
            <ul class="list-inline ">
                <li><button type="button" class="button next-step">{{ trans('main.save_and_complete') }}</button></li>
            </ul>
        </div>
    @endforeach
    <div class="tab-pane" role="tabpanel" id="complete">
            <!-- Start Time Booking-->
            <div class="booking_content">
                <aside id="DayBooked">
                    <i class="far fa-calendar-alt"></i>
                    <span id="DayBooked"></span>
                </aside>

                <aside id="TimeBooked">
                    <i class="far fa-clock"></i>
                    <span></span>
                </aside>
            </div>
            <!-- End Time Booking-->

            <!-- Start Table Details Booking-->
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ trans('main.services') }}</th>
                        <th>{{ trans('main.time') }}</th>
                        <th>{{ trans('main.price') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ trans('main.home_visit') }}</td>
                        <td>{{ $provider->visit_duration }} {{ trans('main.minutes') }}</td>
                        <td> <span>{{ $provider->price }} {{ ($provider->currency) ? $provider->currency->name : ''}}</span> </td>
                    </tr>
                </tbody>
            </table>
            <!-- End Table Details Booking-->
            <div class="row">
                <div class="col-sm-12 col-md-6 ">
                    <aside class="price">
                        <h3 class="price_title">{{ trans('main.amount_original') }}:</h3>
                        <span class="price_value amount_original"></span>
                    </aside>
                    <aside class="price">
                        <h3 class="price_title">{{ trans('main.amount_after_discount') }}:</h3>
                        <span class="price_value amount_after_discount"></span>
                    </aside>
                    <aside class="price">
                        <h3 class="price_title">{{ trans('main.amount_after_vat') }}:</h3>
                        <span class="price_value amount_after_vat"></span>
                    </aside>
                    <aside class="price">
                        <h3 class="price_title">{{ trans('main.amount_final') }}:</h3>
                        <span class="price_value amount_final"></span>
                    </aside>
                </div>

                <div class="col-sm-12 col-md-6 ">
                    <h3>{{ trans('main.promo_code') }}</h3>
                    <div class="input_content">
                        <input type="text" id="PromoCodeID" name="promo_code" value="">
                        <button type="button" class="button" onclick="CheckPromoCode(this);">{{ trans('main.submit_code') }}</button>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div id="PromoCodeMessage" class="text-center"></div>
                    <div class="alert alert-danger hidden">
                        <ul id="validationError"></ul>
                    </div>
                </div>
            </div>
            <ul class="list-inline ">
                {{--<button class="button" type="submit" name="button" data-toggle="modal" data-target="#reservation_confirmation">{{ trans('main.confirm_appointment') }}</button>--}}
                <button class="button" type="button" name="button" onclick="validateForm();">{{ trans('main.confirm_appointment') }}</button>
            </ul>
    </div>
        <div class="clearfix"></div>
    </div>

    <!--=01=Start Popup confirmation_code-->
    <div class="confirmation_code">
        <div class="container">
            <!-- The Modal -->
            <div class="modal fade" id="reservation_confirmation">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button class="close fas fa-times" type="button" data-dismiss="modal"> </button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body model_code">
                            <!-- Start Form content-->
                            <div class="form_content">
                                <form class="glopal_form middel_form ">
                                    <h5 class="send_code"> {{ trans('main.press_confirm_appointment') }} </h5>
                                    <!-- End List icon Registration -->
                                    <aside class="sign_button-content">
                                        <button class="button" type="button" onclick="submitQuestionnaireForm();">{{ trans('main.confirm_appointment') }}</button>
                                    </aside>
                                </form>
                            </div>
                            <!-- End  Form content-->
                            <aside class="form_man">
                                <img src="{{ asset('public/Frontend/img/confirm.png') }}" alt="{{ trans('main.site_name') }}">
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--=01= Send Code confirmation_code -->
@endif