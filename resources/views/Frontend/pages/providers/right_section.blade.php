<div class="doctor_info-block">
    <div class="doctor_pic">
        <img src="{{ $provider->profile_picture_path }}" alt="{{ $provider->full_name }}">
    </div>
    <div class="doctor_info-description">
        <h2>{{ $provider->full_name }}</h2>
        <span>{{ $subcategory->name }}</span>
        <h3>
            @if($provider->cities)
                (
                @foreach($provider->cities as $city)
                    {{ $city->name }} {{ ($loop->last) ? '' : '-' }}
                @endforeach
                )
            @endif
        </h3>
        <span>{{ $provider->speciality_area }}</span>
        <div class="social_media-content">
            <ul class="social_media list-unstyled">
                <li> <a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" target="_blank" title="Facebook" class="fab fa-facebook-f"></a></li>
                <li> <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $provider->full_name }}&summary={{ \App\Helpers\Utilities::beautyName($provider->about) }}&source={{ trans('main.site_name') }}" target="_blank" title="{{ trans('main.site_name') }}" class="fab fa-linkedin-in"></a></li>
                <li> <a href="https://twitter.com/share?url={{ url()->current() }}" target="_blank" title="twitter " class="fab fa-twitter"></a></li>
                <li> <a href="https://plus.google.com/share?url={{url()->current()}}" target="_blank" title="GooglePlus" class="fab fa-google-plus-g"></a></li>
            </ul>
        </div>
        <div class="rate_content">
            <aside>
                <span>{{ $provider->no_of_views }}</span>
                <i class="far fa-share-square"></i>
            </aside>

            <aside>
                <span>{{ $provider->no_of_ratings }}</span>
                <i class="far fa-star"></i>
            </aside>

            <aside>
                <span>{{ $provider->no_of_likes }}</span>
                <i class="far fa-heart LikeAction" data-action=""></i>
            </aside>
        </div>

        <div class="rate_area">
            <ul class="list-unstyled rate_area-stars">
                {!! \App\Helpers\Utilities::stars($provider->no_of_ratings) !!}
            </ul>
            <span>( {{ ($provider->ratings) ? count($provider->ratings) : '' }} )</span>
            <span>of 5</span>
            <span>{{ $provider->no_of_ratings }}</span>
        </div>
    </div>
</div>