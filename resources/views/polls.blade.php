@include('header')
<!-- Start content -->
<div class="content">

    <h2 class="page-title">Polls Data</h2>
    <div class="row">
        <div class="col-lg-12">        
            @if(auth()->user() && auth()->user()->role == 'admin')
            <a href="/add_poll" class="btn-link">
                <button type="button" class="btn btn-info">Add Poll</button>
            </a>
             @endif           
             @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif       
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Poll Title</th>
                                        <th>Vote count</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($polls as $poll)
                                    <tr>
                                        <td>{{ $poll->id }}</td>
                                        <td>{{ $poll->title }}</td>
                                        <td>{{ $poll->voting_list_count }}</td>
                                        <td>
                                            @if(auth()->user()->role === 'admin') 
                                                <!-- Admin Actions -->
                                                <a href="/edit_poll/{{ $poll->id }}" class="text-warning">
                                                    <i class="mdi mdi-account-edit"></i>
                                                </a>
                                                <a href="/delete_poll/{{ $poll->id }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this poll?')">
                                                    <i class="ion ion-md-trash"></i>
                                                </a>
                                            @else
                                                <!-- Check if the user has already voted -->
                                                @php
                                                    $userHasVoted = \App\Models\VotingList::where('poll_id', $poll->id)
                                                        ->where('voter_id', auth()->user()->id)
                                                        ->exists();
                                                @endphp

                                                @if(!$userHasVoted)
                                                    <!-- User Action to Cast Vote -->
                                                    <a href="/polls/{{ $poll->id }}" class="text-primary">
                                                        <i class="mdi mdi-vote"></i> Cast Vote
                                                    </a>
                                                @else
                                                    <!-- Message or indication that the user has already voted -->
                                                    <span class="text-success">You have already voted</span>
                                                @endif
                                            @endif
                                        </td>   
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!-- Pagination Links -->
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $polls->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End row -->

</div> <!-- content -->
@include('footer')
