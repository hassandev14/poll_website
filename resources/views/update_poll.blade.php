@include('header')
<!-- Start content -->
<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="m-t-0 m-b-30">
                        {{ isset($poll) ? 'Update Poll' : 'Add Poll' }}
                    </h4>

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" 
                        action="{{ url('/edit_poll/' . $poll->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Poll Title -->
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="poll-title">Poll Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" value="{{ old('title', $poll->title ?? '') }}" id="poll-title" required>
                            </div>
                        </div>

                        <!-- Poll Options -->
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="poll-options">Poll Options</label>
                            <div class="col-sm-10">
                                <div id="poll-options">
                                    @if(isset($poll))
                                        @foreach($poll->options as $index => $option)
                                            <div class="input-group mb-2">
                                                <!-- Option name -->
                                                <input type="text" class="form-control" name="options[]" value="{{ old('options.' . $index, $option->option_name) }}" placeholder="Option" required>
                                                
                                                <!-- Option image upload -->
                                                @if($option->image)
                                                    <div>
                                                        <img src="{{ asset('storage/' . $option->image) }}" alt="Option Image" width="50" height="50">
                                                        <p>Current Image</p>
                                                    </div>
                                                @endif
                                                
                                                <input type="file" class="form-control" name="images[]" accept="image/*">
                                                <button type="button" class="btn btn-danger remove-option" style="margin-left: 10px;">Remove</button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="options[]" placeholder="Option" required>
                                            <input type="file" class="form-control" name="images[]" accept="image/*">
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-success" id="add-option">Add Option</button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group row">
                            <div class="col-sm-12 text-center"> <!-- Align to center -->
                                <button type="submit" class="btn btn-info">
                                    {{ isset($poll) ? 'Update Poll' : 'Add Poll' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- End row -->
</div> <!-- content -->

@include('footer')

<script>
    // Add new option dynamically
    document.getElementById('add-option').addEventListener('click', function () {
        var newOption = document.createElement('div');
        newOption.classList.add('input-group', 'mb-2');
        newOption.innerHTML = '<input type="text" class="form-control" name="options[]" placeholder="Option" required><input type="file" class="form-control" name="images[]" accept="image/*"><button type="button" class="btn btn-danger remove-option" style="margin-left: 10px;">Remove</button>';
        document.getElementById('poll-options').appendChild(newOption);
    });

    // Remove an option
    document.getElementById('poll-options').addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-option')) {
            e.target.parentElement.remove();  // Remove the option
        }
    });
</script>
