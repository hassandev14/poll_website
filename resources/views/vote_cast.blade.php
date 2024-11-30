@include('header')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Dashboard</h4>
        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <!-- Loop through the polls -->
                @foreach($polls as $poll)
                    <div class="col-lg-12 mb-4">
                        <!-- Poll Title -->
                        <h4 class="font-weight-bold mb-4">{{ $poll->title }}</h4>
                        
                        <ul class="list-group">
                            <!-- Loop through poll options -->
                            @foreach($poll->options as $option)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <form method="POST" action="{{ route('polls.vote', $poll->id) }}" class="vote-form" data-poll-id="{{ $poll->id }}">
                                        @csrf
                                        <div class="form-check">
                                            <input type="radio" class="vote-btn form-check-input" name="vote" value="{{ $option->id }}" id="option{{ $option->id }}" data-poll-id="{{ $poll->id }}" data-option-id="{{ $option->id }}">
                                            <label class="form-check-label" for="option{{ $option->id }}">
                                                {{ $option->option_name }}
                                                @if($option->image)
                                                    <img src="{{ asset('storage/' . $option->image) }}" alt="Option Image" class="img-fluid mt-2" style="max-width: 50px; border-radius: 5px;">
                                                @endif
                                            </label>
                                        </div>
                                    </form>
                                    <span id="vote-count-{{ $option->id }}" class="badge bg-primary rounded-pill">{{ $option->votes_count }} Votes</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div><!-- End of Row -->
        </div><!-- container-fluid -->
    </div><!-- Page content Wrapper -->
</div><!-- content -->

@include('footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.vote-btn').on('change', function() {
        var pollId = $(this).data('poll-id');       // Get poll ID
        var optionId = $(this).data('option-id');   // Get option ID
        
        // AJAX request to cast the vote and get updated count
        $.ajax({
            url: '/polls/' + pollId + '/vote',       // URL for voting
            method: 'POST',
            data: {
                vote: optionId,
                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
            },
            success: function(response) {
                // Update vote count display for this option
                $('#vote-count-' + optionId).text(response.new_vote_count + " Votes");
                
                // Disable all radio buttons and submit button in this poll
                $('input[name="vote"][data-poll-id="' + pollId + '"]').prop('disabled', true);
                alert("Vote cast successfully!");

                // Redirect the user to the polls page
                if (response.redirect) {
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseJSON.error);       // Show error message if any
            }
        });
    });
});

</script>
