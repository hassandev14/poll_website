@include('header')

<div class="content">
    <div class="page-header-title">
        <h4 class="page-title">Poll Cast</h4>
    </div>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <!-- Loop through the polls -->
                @foreach($polls as $poll)
                    <div class="col-lg-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">{{ $poll->title }}</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <!-- Loop through poll options -->
                                    @foreach($poll->options as $option)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <input type="radio" class="form-check-input me-2 vote-btn" name="vote_{{ $poll->id }}" value="{{ $option->id }}" id="option{{ $option->id }}" data-poll-id="{{ $poll->id }}" data-option-id="{{ $option->id }}">
                                                <label class="form-check-label" for="option{{ $option->id }}">
                                                    {{ $option->option_name }}
                                                </label>
                                            </div>
                                            @if($option->image)
                                                <img src="{{ asset('storage/' . $option->image) }}" alt="Option Image" class="img-thumbnail ms-3" style="width: 50px; height: 50px;">
                                            @else
                                                <img src="{{ asset('storage/poll_images/dummy_image.webp') }}" class="img-thumbnail ms-3" style="width: 70px; height: 70px;">
                                            @endif
                                            <span id="vote-count-{{ $option->id }}" class="badge bg-success rounded-pill">{{ $option->votes_count }} Votes</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
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
