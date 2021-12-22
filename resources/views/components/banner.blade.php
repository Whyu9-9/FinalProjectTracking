<div class="section section-banner__container">
    <img class="section-banner__img" src="{{asset('images/banner-bg.svg')}}">
    <div class="container section-banner__content">
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach($blogs as $blog)
                <div class="swiper-slide">
                    <a class="text" href="{{route('detail_blog', $blog->slug)}}">                        
                        <div class="row mb-4 bg-white align-items-center">
                            <div class="col-4">
                                <div class="section-banner__content-container">
                                    <img class="section-banner__content-img" src="{{asset(Storage::url('blog_images/'.$blog->image))}}">
                                </div>
                            </div>
                            <div class="col-7">
                                <p class="section-banner__date-created font-weight-bold">{{$blog->published_at}} - {{$blog->user->name}}</p>
                                <h2 class="text-dark">
                                    {{$blog->title}}
                                </h2>
                                <p class="section-banner__desc" id="bannerDesc">
                                    {{$blog->content}}
                                </p>                                
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>