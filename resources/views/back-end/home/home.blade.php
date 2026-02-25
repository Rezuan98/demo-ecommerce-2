@extends('back-end.master')

@section('admin-title')
 Dashboard || {{ config('app.name') }}
@endsection

@push('admin-styles')
 <style>
 	  .button-area a{
      text-align: center;
    }
    .btn.btn-md.d-btn {
    border: 1px solid rgba(0,0,0,.5);
    border-radius: 0;
}
.btn.btn-md.d-btn {
	border: 1px solid rgba(0,0,0,.5);
	border-radius: 0;
	width: 100px;
  box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.3);
  margin:10px 5px;
}

 .button-area a{
      text-align: center;
    }
    .home-box{
      height: 120px;
      background: #000;
    }
    .home-area{
      margin-bottom: 30px;
    }

.small-box {
    border: 1px solid rgba(0,0,0,.2);
    box-shadow: none;
    background: #444034;
    background: #fff;
    color: #000;
    border-radius: 0;
    box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 5px rgba(0,0,0,.4);
}

.chart-1 {
    background: #fff;
    padding: 20px;
    margin-bottom: 20px;
}
.chart-2 {
    background: #fff;
    padding: 20px 10px;
    margin-bottom: 20px;
}
.pending-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
/*            max-width: 200px;*/
            border:1px solid rgba(0,0,0,.2);
            margin-bottom: 10px;
        }
        .pending-card .icon {
            font-size: 20px;
            color: #6c757d;
            margin-right: 10px;
        }
        .pending-card .count {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-weight: bold;
            color: #495057;
        }
        .bg-padding{
          padding:10px 10px 0px 10px;
        }
 </style>
@endpush

@section('admin-content')

  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

        <div class="row">
          
          <div class="col-lg-3 col-6">
         
            <div class="small-box">
              <div class="inner">
            <h3>{{ $today_sales }}</h3>

                <p>Today's Sale</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>

          <div class="col-lg-3 col-6">
         
         <div class="small-box">
           <div class="inner">
             <h3>{{ $totalsales }}</h3>

             <p>Total Sale</p>
           </div>
           <div class="icon">
             <!-- <i class="ion ion-person-add"></i> -->
             <i class="ion ion-stats-bars"></i>
           </div>
          <!--  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
         </div>
       </div>
          

          <div class="col-lg-3 col-6">
         
            <div class="small-box">
              <div class="inner">
                <h3>{{ $total_order }}</h3>

                <p>Total Orders</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-person-add"></i> -->
                <i class="ion ion-stats-bars"></i>
              </div>
            <!--   <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>


          <div class="col-lg-3 col-6">
         
            <div class="small-box">
              <div class="inner">
                <h3>{{ $total_customer }}</h3>

                <p>Total Customer Account</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-person-add"></i> -->
                <i class="ion ion-stats-bars"></i>
              </div>
             <!--  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>

        </div>
        <!-- /.row -->


           <div class="col-lg-12 bg-white bg-padding">
            <div class="row mb-4">

           <div class="col-lg-3">
              <div class="pending-card">
                  <div class="d-flex align-items-center">
                      <span class="icon"><i class="fas fa-clock"></i></span>
                      <span>Pending</span>
                  </div>
                  <div class="count">{{ $pending_orders }}</div>
              </div>
          </div>

           <div class="col-lg-3">
              <div class="pending-card">
                  <div class="d-flex align-items-center">
                      <span class="icon"><i class="fas fa-clock"></i></span>
                      <span>Confirm</span>
                  </div>
                  <div class="count">2</div>
              </div>
          </div>

           <div class="col-lg-3">
              <div class="pending-card">
                  <div class="d-flex align-items-center">
                      <span class="icon"><i class="fas fa-clock"></i></span>
                      <span>Processing</span>
                  </div>
                  <div class="count">{{ $processing_orders }}</div>
              </div>
          </div>

           {{-- <div class="col-lg-3">
              <div class="pending-card">
                  <div class="d-flex align-items-center">
                      <span class="icon"><i class="fas fa-clock"></i></span>
                      <span>Pickup</span>
                  </div>
                  <div class="count">{{ $pickup_orders }}</div>
              </div>
          </div> --}}

           {{-- <div class="col-lg-3">
              <div class="pending-card">
                  <div class="d-flex align-items-center">
                      <span class="icon"><i class="fas fa-clock"></i></span>
                      <span>On The Way</span>
                  </div>
                  <div class="count">{{ $ontheway_orders }}</div>
              </div>
          </div> --}}

           <div class="col-lg-3">
              <div class="pending-card">
                  <div class="d-flex align-items-center">
                      <span class="icon"><i class="fas fa-clock"></i></span>
                      <span>Delivered</span>
                  </div>
                  <div class="count">{{ $delivered_orders }}</div>
              </div>
          </div>

           <div class="col-lg-3">
              <div class="pending-card">
                  <div class="d-flex align-items-center">
                      <span class="icon"><i class="fas fa-clock"></i></span>
                      <span>Calcelled</span>
                  </div>
                  <div class="count">{{ $cancelled_orders }}</div>
              </div>
          </div>

         </div>
        </div> 

    
@endsection


@push('admin-scripts')


@endpush