<section class="amenities" style=" ">

    <div class="container">
        <div class="row" > <!-- Gray background -->
            <div class="col-lg-3 text-center"> <!-- Center alignment -->
                <div class="home_delivery">
                    <img src="{{asset('amenities/1.png')}}" style="height: 45px;width:50px;" alt=""> 
                    <h5 class="text-muted mt-3">Home Delivery</h5>
                    <p class="text-muted">We have home delivery service all over the Bangladesh</p>
                </div>
            </div>
            <div class="col-lg-3 text-center">
                <div class="trends">
                     <img src="{{asset('amenities/2.png')}}" style="height: 45px;width:50px;" alt=""> 
                    <h5 class="text-muted mt-3">Newest Trends</h5>
                    <p class="text-muted">Keep your eyes out for the newest trends.</p>
                </div>
            </div>
            <div class="col-lg-3 text-center">
                <div class="quality">
                    <img src="{{asset('amenities/3.png')}}" style="height: 45px;width:50px;" alt=""> 
                    <h5 class="text-muted mt-3">Best Quality</h5>
                    <p class="text-muted">Scinan delivers only the best quality products.</p>
                </div>
            </div>
            <div class="col-lg-3 text-center">
                <div class="caring_support">
                     <img src="{{asset('amenities/4.png')}}" style="height: 45px;width:50px;" alt=""> 
                    <h5 class="text-muted mt-3">Caring Support</h5>
                    <p class="text-muted">24/7 Caring Customer Support</p>
                </div>
            </div>
        </div>
    </div>
    
</section>

<style>
    /* Centering content */
.home_delivery,
.trends,
.quality,
.caring_support {
    padding: 20px 10px;
    text-align: center;
}

h4 {
    margin-top: 15px; /* Spacing between icon and title */
    font-weight: 600; /* Bold text */
}

p {
    font-size: 14px; /* Slightly smaller muted text */
}

/* end style for amenities part */

.amenities {
    background-color: #cc7fac;
}

</style>