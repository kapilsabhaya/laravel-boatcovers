<x-app-layout>
    @push('title')
    <title>SealSkin Covers</title>
    @endpush

    {{-- @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif --}}

    <div id="pre-loader">
        <img src="{{ asset('uploads/loader.gif') }}" alt="Loading..." />
    </div>

    
    <!-- Main Start -->
    <div class="container-main container-fluid">
        <!-- main-head sec 1 -->
        <div class="head-section">
            <div class="container d-flex flex-wrap flex-column">
                <h4 class="mt-5">The Cover That Cares. Feel The Difference.</h4>
                <small>400,000 Verified Customers. Established in 2005, 95K+ Reviews</small>
                <a href="" onMouseOver="this.style.color='white'" onMouseOut="this.style.color='black'" class="mt-4">Call Now 800-915-0038</a>
            </div>
        </div>
        <div class="container head-section-bottom d-flex flex-wrap">
            <div class="col-md-3 d-flex">
                <div class="benifits-logo text-center col-4 m-2">
                    <i class="bi bi-piggy-bank-fill"></i>
                </div>
                <div class="col-8 m-2">
                    <h6>Best Prices</h6>
                    <small>No Middlemen, Free Shipping!</small>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="benifits-logo text-center col-4 m-2">
                    <i class="bi bi-umbrella-fill"></i>
                </div>
                <div class="col-8 m-2">
                    <h6>100% Water Proof</h6>
                    <small>Yet Extremely Breathable</small>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="benifits-logo text-center col-4 m-2">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <div class="col-8 m-2">
                    <h6>Snug Fit</h6>
                    <small>Quality Handpicked Fabric</small>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="benifits-logo text-center col-4 m-2">
                    <i class="bi bi-award-fill"></i>
                </div>
                <div class="col-8 m-2">
                    <h6>Full Warranty</h6>
                    <small>Let the Seal Worry. You sleep well!</small>
                </div>
            </div>

        </div>


        <!-- main-head sec-3  -->
        <div class="container-fluid" style="height: 900px; max-height: auto;min-height: auto;">
            <div class="container section-2 " style=" background-image: url( {{asset('resource/boat.png')}} );">
                <div class="col-md-6 sec2-desc p-5">
                    <div>
                        <strong>
                            <h3>
                                Guaranteed Fit Boat Covers
                            </h3>
                        </strong>
                    </div>
                    <div class="mt-3">
                        <small>
                            Love your boat? Throw away that cheap tarp and give your pride and joy the protection it
                            deserves. Use
                            our selector to
                            find the perfect cover for your boat.
                        </small>
                    </div>
                    <div class="mt-3">
                        <a style="width:16rem;padding:0.50rem" href="" class="btn">
                            Shop Now
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="sec2-cards p-3">
                        <a href="" class="card col-md-5 m-2">
                            <div class="card-img">
                                <img src="{{ asset('resource/boat3.png') }}" alt="">
                            </div>
                            <div class="card-desc mt-3">
                                <div class="mt-2" style="font-size: 16px; font-weight: bold;">
                                    Seal Skin Supreme Boat Covers
                                </div>
                                <div class="mt-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="mt-2">
                                    <p>
                                        <strike> $480.00 </strike>
                                        &nbsp;
                                        <strong> $239.00 </strong>
                                    </p>
                                </div>
                                <div>
                                    <button class="btn w-100 p-2">
                                        Lund Boat Covers
                                    </button>
                                </div>
                            </div>

                        </a>
                        <a href="" class="card col-md-5 m-2">
                            <div class="card-img">
                                <img src="{{ asset('resource/boat4.png') }}" alt="">
                            </div>
                            <div class="card-desc mt-3">
                                <div class="mt-2" style="font-size: 16px; font-weight: bold;">
                                    Seal Skin Elite Boat Covers
                                </div>
                                <div class="mt-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="mt-2">
                                    <p>
                                        <strike> $398.00 </strike>
                                        &nbsp;
                                        <strong> $199.00 </strong>
                                    </p>
                                </div>
                                <div>
                                    <button class="btn w-100 p-2">
                                        Tracker Boat Covers
                                    </button>
                                </div>
                            </div>

                        </a>
                        <a href="" class="card col-md-5 m-2">
                            <div class="card-img">
                                <img src="{{ asset('resource/boat5.png') }}" alt="Boat cover">
                            </div>
                            <div class="card-desc mt-3">
                                <div class="mt-2" style="font-size: 15px; font-weight: bold;">
                                    Seal Skin Supreme Jet Ski Covers
                                </div>
                                <div class="mt-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="mt-2">
                                    <p>
                                        <strike> $229.99 </strike>
                                        &nbsp;
                                        <strong> $129.99 </strong>
                                    </p>
                                </div>
                                <div>
                                    <button class="btn w-100 p-2">
                                        Shop Sea-Doo Covers
                                    </button>
                                </div>
                            </div>

                        </a>
                        <a href="" class="card col-md-5 m-2">
                            <div class="card-img">
                                <img src="{{ asset('resource/boat6.png') }}" alt="">
                            </div>
                            <div class="card-desc mt-3">
                                <div class="mt-2" style="font-size: 15px; font-weight: bold;">
                                    Seal Skin Elite Jet Ski Covers
                                </div>
                                <div class="mt-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="mt-2">
                                    <p>
                                        <strike> $199.99 </strike>
                                        &nbsp;
                                        <strong> $99.99 </strong>
                                    </p>
                                </div>
                                <div>
                                    <button class="btn w-100 p-2">
                                        Lund Boat Covers
                                    </button>
                                </div>
                            </div>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- main-head sec-2 -->
    <div class="container-fluid" style="height: 900px; max-height: auto;min-height: auto;">
        <div class="container section-2 " style=" background-image: url({{ asset('resource/car-cover.png') }});">
            <div class="col-md-6">
                <div class="sec2-cards p-3">
                    <a href="" class="card col-md-5 m-2">
                        <div class="card-img">
                            <img src="{{ asset('resource/car-cover1.png') }}" alt="">
                        </div>
                        <div class="card-desc mt-3">
                            <div class="mt-2" style="font-size: 16px; font-weight: bold;">
                                Seal Skin Supreme Car Covers
                            </div>
                            <div class="mt-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <div class="mt-2">
                                <p>
                                    <strike> $369.99 </strike>
                                    &nbsp;
                                    <strong> $169.99 </strong>
                                </p>
                            </div>
                            <div>
                                <button class="btn btn-warning w-100 p-2">
                                    Corvette Car Covers
                                </button>
                            </div>
                        </div>

                    </a>
                    <a href="" class="card col-md-5 m-2">
                        <div class="card-img">
                            <img src="{{ asset('resource/car-cover2.png') }}" alt="">
                        </div>
                        <div class="card-desc mt-3">
                            <div class="mt-2" style="font-size: 16px; font-weight: bold;">
                                Seal Skin Elite Car Covers
                            </div>
                            <div class="mt-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <div class="mt-2">
                                <p>
                                    <strike> $349.99 </strike>
                                    &nbsp;
                                    <strong> $149.99 </strong>
                                </p>
                            </div>
                            <div>
                                <button class="btn btn-warning w-100 p-2">
                                    Mustang Car Covers
                                </button>
                            </div>
                        </div>

                    </a>
                    <a href="" class="card col-md-5 m-2">
                        <div class="card-img">
                            <img src="{{ asset('resource/car-cover3.png') }}" alt="">
                        </div>
                        <div class="card-desc mt-3">
                            <div class="mt-2" style="font-size: 15px; font-weight: bold;">
                                Seal Skin ProGuard Car Covers
                            </div>
                            <div class="mt-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <div class="mt-2">
                                <p>
                                    <strike> $199.99 </strike>
                                    &nbsp;
                                    <strong> $89.99 </strong>
                                </p>
                            </div>
                            <div>
                                <button class="btn btn-warning w-100 p-2">
                                    Camaro Car Covers
                                </button>
                            </div>
                        </div>

                    </a>
                    <a href="" class="card col-md-5 m-2">
                        <div class="card-img">
                            <img src="{{ asset('resource/car-cover4.png') }}" alt="">
                        </div>
                        <div class="card-desc mt-3">
                            <div class="mt-2" style="font-size: 15px; font-weight: bold;">
                                Seal Skin Organizer
                            </div>
                            <div class="mt-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <div class="mt-2">
                                <p>
                                    <strike> $39.99 </strike>
                                    &nbsp;
                                    <strong> $19.99 </strong>
                                </p>
                            </div>
                            <div>
                                <button class="btn btn-warning w-100 p-2">
                                    Lund Boat Covers
                                </button>
                            </div>
                        </div>

                    </a>
                </div>
            </div>
            <div class="col-md-6 sec2-desc p-5">
                <div>
                    <strong>
                        <h3>
                            Guaranteed Fit Car Covers
                        </h3>
                    </strong>
                </div>
                <div class="mt-3">
                    <small>
                        I ordered this car cover and I could not be happier, it fits well and it seems to be holding up
                        quite great. The cover
                        was shipped very quickly as promised. 5 Stars!!
                    </small>
                </div>
                <div class="mt-3">
                    <a style="width:16rem;padding:0.50rem" href="" class="btn">
                        Shop Now
                    </a>
                </div>
            </div>

        </div>
    </div>
    </div>

    <!-- coustmers reviews -->
    <div class="container mt-5">
        <div class="container-reviews">
            <div class="head text-center">
                <h4>Real Customers, Real Reviews</h4>
                <small>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </small>
            </div>
            <div class="body container-fluid d-flex flex-wrap">
                <a href="" class="col-md-2 card">
                    <div class="d-flex flex-wrap text-center card-image">
                        <img src="{{ asset('resource/boat1.png') }}" alt="">
                    </div>
                    <div class="card-text">
                        <strong> <small>"Great cover, i trailer from the lake & back with the cover
                                on"</small></strong><br />
                        <h6 class="mt-3" style="color: gray;"> @Mich-Florida</h6>
                    </div>

                </a>
                <a href="" class="col-md-2 card">
                    <div class="d-flex flex-wrap text-center card-image">
                        <img src="{{ asset('resource/car1.png') }}" alt="">
                    </div>
                    <div class="card-text">
                        <strong> <small>"Great cover, i trailer from the lake & back with the cover
                                on"</small></strong><br />
                        <h6 class="mt-3" style="color: gray;"> @Mich-Florida</h6>
                    </div>

                </a>
                <a href="" class="col-md-2 card">
                    <div class="d-flex flex-wrap text-center card-image">
                        <img src="{{ asset('resource/boat2.png') }}" alt="">
                    </div>
                    <div class="card-text">
                        <strong> <small>"Great cover, i trailer from the lake & back with the cover
                                on"</small></strong><br />
                        <h6 class="mt-3" style="color: gray;"> @Mich-Florida</h6>
                    </div>

                </a>
                <a href="" class="col-md-2 card">
                    <div class="d-flex flex-wrap text-center card-image">
                        <img src="{{ asset('resource/car2.png') }}" alt="">
                    </div>
                    <div class="card-text">
                        <strong> <small>"Great cover, i trailer from the lake & back with the cover
                                on"</small></strong><br />
                        <h6 class="mt-3" style="color: gray;"> @Mich-Florida</h6>
                    </div>

                </a>
                <a href="" class="col-md-2 card">
                    <div class="d-flex flex-wrap text-center card-image">
                        <img src="{{ asset('resource/bike1.png') }}" alt="">
                    </div>
                    <div class="card-text">
                        <strong> <small>"Great cover, i trailer from the lake & back with the cover
                                on"</small></strong><br />
                        <h6 class="mt-3" style="color: gray;"> @Mich-Florida</h6>
                    </div>

                </a>
            </div>
        </div>
    </div>

    <!-- From Blogs -->
    <div class="container-fluid mt-5">
        <div class="from-blog " style="background-color: black;">
            <div class="blog-sec-1 d-flex flex-wrap justify-content-center ">
                <h3 class="mt-5">From The Blog</h3>
            </div>
            <div class="blog-sec-2">
                <div class="blog-items container">
                    <div class="col-md-4 p-2">
                        <a href="">
                            <div class="blog-item-card">
                                <div class="blog-card-img">
                                    <img src="{{ asset('resource/blog-boat-1.png') }}" alt="blog boat image">
                                </div>
                                <div class="item-desc p-3">
                                    <strong>
                                        <p>
                                            The 6 Best Jet Ski Accessories You Need This Summer
                                        </p>
                                    </strong>
                                    <small>
                                        July 29, 2024
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 p-2">
                        <a href="">
                            <div class="blog-item-card">
                                <div class="blog-card-img">
                                    <img src="{{ asset('resource/blog-boat-2.png') }}" alt="blog boat image">
                                </div>
                                <div class="item-desc p-3">
                                    <strong>
                                        <p>
                                            The 6 Best Jet Ski Accessories You Need This Summer
                                        </p>
                                    </strong>
                                    <small>
                                        July 29, 2024
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 p-2">
                        <a href="">
                            <div class="blog-item-card">
                                <div class="blog-card-img">
                                    <img src="{{ asset('resource/blog-boat-3.png') }}" alt="blog boat image">
                                </div>
                                <div class="item-desc p-3">
                                    <strong>
                                        <p>
                                            The 6 Best Jet Ski Accessories You Need This Summer
                                        </p>
                                    </strong>
                                    <small>
                                        July 29, 2024
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- more -->
    <div class="more">
        <div class="content container">
            <div class="content-1 mt-5">
                <h3 class="heading">What is the Seal Skin Waterproof Car Cover</h3>
                <p>
                    Seal Skin offers car, boat, and other recreational vehicle owners a way to protect their
                    investments. The Seal Skin
                    outdoor car cover protects exterior paint, protecting the vehicle from the damaging rays of the sun
                    and deterring
                    natural hazards like tree sap, bird droppings, and more.
                </p>
                <p>
                    The Seal Skin waterproof car cover is made from the finest materials and offers extreme protection
                    for just about
                    anything Mother Nature can throw in your direction. We add several layers of water-resistant
                    protection that wicks
                    moisture away from your vehicle. At the heart of the Seal Skin cover is the inner layer soft fleece
                    lining. Where
                    generic car tarps can create micro scratches on the outer surface of your car, the Seal Skin outdoor
                    car cover keeps
                    your exterior finishes as clean as the day they rolled off the assembly line.
                </p>
            </div>
            <div class="content-2 mt-5">
                <h3 class="heading">
                    Does Seal Skin Just Protect Cars?
                </h3>
                <p>
                    Big or small, if it’s got tires or floats, we have a Seal Skin cover for you. Rather than just being
                    an outdoor car
                    cover, Seal Skin also has designs for smaller vehicles, from ATVs to jet skis. We even offer seat
                    covers to extend this
                    superior quality protective shield to the inside of your vehicle. Each product, no matter the size,
                    is carefully crafted
                    to provide you with the protection you need for your vehicle.
                </p>
                <p>
                    If you want your car, boat, or other recreational vehicle to look showroom-worthy, there is simply
                    no better product on
                    the market. Seal Skin waterproof outdoor vehicle covers give you a cleaner, newer-looking exterior.
                    This vehicle care
                    product reduces the risk of small dings and nicks in the paint caused by wind, grit, or other
                    outdoor elements. The Seal
                    Skin outdoor car cover can even act as a deterrent to vandals or thieves. Are they going to take the
                    time to unlock and
                    uncover your car or boat when there are so many other tempting targets out there?
                </p>
                <p>
                    From cars and boats to scooters and snowmobiles, we have a top-notch cover designed to fit your
                    every vehicular need. If
                    you’re looking for the best and most cost-effective vehicle cover on the market, whether it’s a Seal
                    Skin waterproof
                    boat cover or an outdoor car cover, look no further for the ultimate in weather protection.
                </p>
            </div>
            <div class="content-3 mt-5">
                <h3 class="heading">
                    What is the Seal Skin Waterproof Boat Cover?
                </h3>
                <p>
                    For recreational water lovers, the Seal Skin waterproof boat cover is the industry’s finest, made
                    from an incredibly
                    durable and long-lasting marine quality polyester. Our waterproof boat covers are guaranteed to
                    never shrink, stretch
                    out, or warp from the sun’s punishing rays. From the desert sun to blizzards, Seal Skin waterproof
                    boat covers are there
                    to ensure your marine toys are kept clean and well-maintained. The benefits of our durable outdoor
                    marine covers
                    include:
                </p>
                <p>
                    Layers of highest quality materials ensure protection from even the toughest outdoor elements. From
                    UV burn to mold or
                    mildew, Seal Skin stands up to just about anything nature can blow your way.
                </p>
                <p>
                    On the outside, our form fitting Seal Skin covers grip the watercraft tightly, form fitting to the
                    size you need. On the
                    inside, a soft membrane of protection caresses the paint job, avoiding the minute external scratches
                    common from plain
                    old tarping.
                </p>
                <p>
                    Seal Skin offers top-of-the-line protection for your recreational watercraft Don’t trust your
                    beloved boat, jet ski, or
                    other watercraft to anyone else.
                </p>
            </div>
            <div class="content-4 mt-5">
                <h3 class="heading">
                    Why Choose Seal Skin?
                </h3>
                <p>
                    Seal Skin’s waterproof car, boat, and motorsport covers are designed with one idea in mind:
                    Protecting the external
                    surface of your investment. The benefits of this product are what keeps our customers coming back
                    every time they
                    purchase a new car, boat, cycle, snowmobile, or other human conveyance. What sets our product apart
                    from a plain old car
                    or boat cover?
                </p>
                <p>
                    The Fit
                </p>
                <p>
                    Seal Skin waterproof car and boat covers are designed to fit snugly, gently gripping the vehicle
                    with urethane elastic
                    hems on the inside, while creating a tough, durable shield around the exterior. This isn’t a
                    one-size-fits-all
                    experience, either. Seal Skin waterproof vehicle covers are available in a variety of different
                    sizes and colors for a
                    variety of water and land craft, including:
                </p>
            </div>
            <div class="list-options">
                <div>
                    <h6>
                        <li>Land vehicles</li>
                    </h6>
                    <ul>
                        <a href="">
                            <li>CARs</li>
                        </a>
                        <a href="">
                            <li>SUVs</li>
                        </a>
                        <a href="">
                            <li>Trucks</li>
                        </a>
                        <a href="">
                            <li>Vans</li>
                        </a>
                    </ul>
                </div>
                <div>
                    <a href="">
                        <h6>
                            <li>
                                Seat Covers
                            </li>
                        </h6>
                    </a>
                </div>
                <div>
                    <h6>
                        <li>Motorsports</li>
                    </h6>
                    <ul>
                        <a href="">
                            <li>ATVs</li>
                        </a>
                        <a href="">
                            <li>Motorcycles</li>
                        </a>
                        <a href="">
                            <li>Scooters</li>
                        </a>
                        <a href="">
                            <li>snowmobiles</li>
                        </a>
                        <a href="">
                            <li>UTV</li>
                        </a>
                    </ul>
                </div>
                <div>
                    <h6 class="bold">
                        <li>Water Craft</li>
                    </h6>
                    <ul>
                        <a href="">
                            <li>Bimini Tops</li>
                        </a>
                        <a href="">
                            <li>Boats</li>
                        </a>
                        <a href="">
                            <li>Jet skis</li>
                        </a>
                        <a href="">
                            <li>Pontoon boats</li>
                        </a>
                    </ul>
                </div>
            </div>
            <div class="content-5 mt-5">
                <h3 id="protection">
                    The Protection
                </h3>
                <p>
                    Waterproof — not water-resistant — yet still breathable, Seal Skin’s line of durable transportation
                    covers offer
                    unparalleled protection from the elements. Through sun, rain, wind, hail, Seal Skin has your back —
                    and your front. Seal
                    Skin protection includes:
                </p>
                <ul>
                    <li>
                        Five layers of waterproof material suitable for all weather conditions.
                    </li>
                    <li>
                        An internal layer of fleece that lies against the paint.
                    </li>
                    <li>
                        Non-scratch grommets that still manage being tough as nails.
                    </li>
                    <li>
                        Seams are double-stitched and durable.
                    </li>
                </ul>
            </div>
            <div class="content-6 mt-5">
                <h2 id="guarantee">
                    The Guarantee
                </h2>
                <p>
                    Seal Skin products are warranted for five-years to help protect your investment. You can even try
                    the cover for 30-days
                    to see how it fits. We can exchange it for you quickly with no cost if you’re not happy with the
                    sizing. You can also
                    return the product for a refund—but we doubt you’ll want to.
                </p>
                <strong>
                    <p>
                        If it floats or rolls, Seal Skin has an ultra-tough cover that creates an exceptional layer of
                        protection between your
                        car, boat, or motorsports equipment. We know how important this investment is; our Seal Skin
                        outdoor protection products
                        help vehicle owners sleep a little better at night.
                    </p>
                </strong>
            </div>
        </div>
    </div>
    </div>
    <!-- main end -->

    <!-- footer start -->
    <div class="container-fluid mt-5">
        <div class="container-footer p-3">
            <div class="container d-flex flex-wrap">
                <div class="col-md-2">
                    <div class="footer-brand">
                        <div class="brand-image mt-3">
                            <img src="{{ asset('resource/brand2.png') }}" alt="brand logo" />
                        </div>
                        <div class="brand-links d-flex flex-wrap m-3">
                            <a href="">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 p-3">
                    <div class="footer-menus-1 d-flex flex-wrap flex-column">
                        <strong>
                            <p>
                                Company
                            </p>
                        </strong>
                        <a href=""><small>About</small></a>
                        <a href=""><small>Reviews</small></a>
                        <a href=""><small>Contact Us</small></a>
                        <a href=""><small>Privacy Policy</small></a>
                        <a href=""><small>Blog</small></a>
                    </div>
                </div>
                <div class="col-md-2 p-3">
                    <div class="footer-menus-2 d-flex flex-wrap flex-column">
                        <strong>
                            <p>
                                Collections
                            </p>
                        </strong>
                        <a href=""><small>Boats</small></a>
                        <a href=""><small>Jet Ski</small></a>
                        <a href=""><small>Cars</small></a>
                        <a href=""><small>Trucks</small></a>
                        <a href=""><small>SUV</small></a>
                        <a href=""><small>Motorcycles</small></a>
                        <a href=""><small>snowmobile</small></a>
                        <a href=""><small>Patio</small></a>
                        <a href=""><small>All Covers</small></a>
                        <a href=""><small>Supreme Covers</small></a>
                        <a href=""><small>Seal Skin Supreme Fabrics</small></a>
                        <a href=""><small></small></a>
                    </div>
                </div>
                <div class="col-md-2 p-3">
                    <div class="footer-menus-1 d-flex flex-wrap flex-column">
                        <strong>
                            <p>
                                Information
                            </p>
                        </strong>
                        <a href=""><small>Return & Exchanges</small></a>
                        <a href=""><small>Return/Exchange Policy</small></a>
                        <a href=""><small>Warranty</small></a>
                        <a href=""><small>Instructions</small></a>
                        <a href=""><small>FAQs</small></a>
                        <a href=""><small>Shipping Info</small></a>
                        <a href=""><small>My Account</small></a>
                    </div>
                </div>

                <div class="col-md-4 p-3">
                    <div>
                        <small>
                            Get discounts, promotions, blog posts and news straight to your inbox. We don't spam!
                        </small>
                        <div class="mt-2 d-flex flex-warp">
                            <input type="text" class="form-control" placeholder="Enter Your Email Address">
                            <button class="btn btn-outline-warning ms-2"> Subscribe</button>
                        </div>
                    </div>
                    <div class="mt-5 d-flex flex-wrap">
                        <div class="col-md-4 d-flex flex-warp flex-column">
                            <i class="bi bi-telephone-x mb-2" style="font-size: 24px;"></i>
                            <small>Toll Free</small>
                            <a href="tel:8009150038"><small>800-915-0038</small></a>
                        </div>
                        <div class="col-md-4  d-flex flex-warp flex-column">
                            <i class="bi bi-question-circle mb-2" style="font-size: 24px;"></i>
                            <a href="#"><small>Email Us</small></a>
                        </div>
                        <div class="col-md-4 d-flex flex-warp flex-column">
                            <i class="bi bi-geo-alt mb-2" style="font-size: 24px;"></i>
                            <small>281 Fields Lan,</small>
                            <small>Brewster NY 10509</small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container-footer-copy">
            <div class="container p-3 d-flex flex-wrap">
                <div class="col-md-6 text-start p-3">Copyright © 2024 Seal Skin Covers - All Rights Reserved.</div>
                <div class="col-md-6 d-flex slex-wrap flex-end justify-content-end">
                    <img src="{{ asset('resource/visa.svg') }}" class="p-2">
                    <img src="{{ asset('resource/mastercard.svg') }}" class="p-2">
                    <img src="{{  asset('resource/american-express.svg') }}" class="p-2">
                    <img src="{{ asset('resource/discover.svg') }}" class="p-2">
                    <img src="{{ asset('resource/jcb.svg') }}" class="p-2">
                    <img src="{{ asset('resource/paypal.svg') }}" class="p-2">
                </div>
            </div>
        </div>
    </div>
    <!-- footer end -->
    <script>
        $(document).ready(function () {
            function pre_loader() {
                $("#pre-loader").delay(0).fadeOut("slow");
            }
            pre_loader();
        });
    </script>
</x-app-layout>
