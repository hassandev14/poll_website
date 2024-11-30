@include('header')
<div class="content">

                    <div class="">
                        <div class="page-header-title">
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                    </div>

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card text-center">
                                        <div class="card-heading">
                                            <h4 class="card-title text-muted mb-0"><a href="{{ route('/polls') }}">
                                                                                   <h4>Total Active polls</h4>
                                                                                   </a>
                                                                                   </h4>
                                            </h4>
                                        </div>
                                        <div class="card-body p-t-10">
                                            <h2 class="m-t-0 m-b-15"></i><b> {{ $polls->count() }}</b></h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <div class="card text-center">
                                        <div class="card-heading">
                                            <h4 class="card-title text-muted mb-0"><a href="{{ route('votes.list') }}">
                                                                                    <h4>Total Votes Cast</h4>
                                                                                    </a>
                                                                                    </h4>
                                        </div>
                                        <div class="card-body p-t-10">
                                            <h2 class="m-t-0 m-b-15"></i><b>{{ $totalVotes }}</b></h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <div class="card text-center">
                                        <div class="card-heading">
                                            <h4 class="card-title text-muted mb-0">Unique Visitors</h4>
                                        </div>
                                        <div class="card-body p-t-10">
                                            <h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-up text-success m-r-10"></i><b>452</b></h2>
                                            <p class="text-muted m-b-0 m-t-20"><b>22%</b> From Last 24 Hours</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <div class="card text-center">
                                        <div class="card-heading">
                                            <h4 class="card-title text-muted mb-0">Monthly Earnings</h4>
                                        </div>
                                        <div class="card-body p-t-10">
                                            <h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-down text-danger m-r-10"></i><b>5621</b></h2>
                                            <p class="text-muted m-b-0 m-t-20"><b>35%</b> From Last 1 Month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- container-fluid -->
                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->
@include('footer')