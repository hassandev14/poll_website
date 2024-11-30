@include('header')
<!-- Start content -->
<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="m-t-0 m-b-30">
                        {{ isset($Poll) ? 'Edit Poll' : 'Add Poll' }}
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
                        action="{{ isset($Poll) ? url('/edit_poll/' . $Poll->id) : url('/add_poll') }}" 
                        method="POST" enctype="multipart/form-data">
                        
                        @csrf
                        @if(isset($Poll))
                            @method('PUT')  <!-- For edit mode -->
                        @endif

                        <!-- Poll Title -->
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="poll-title">Poll Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" value="{{ old('title', $Poll->title ?? '') }}" id="poll-title" required>
                            </div>
                        </div>

                        <!-- Poll Options -->
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="poll-options">Poll Options</label>
                            <div class="col-sm-10">
                                <div id="poll-options">
                                    <!-- Default 2 Options -->
                                    @if(isset($Poll))
                                        @foreach($Poll->options as $option)
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="options[]" value="{{ $option->option_name }}" placeholder="Option" required>
                                                <input type="file" class="form-control" name="images[]" accept="image/*">
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Default 2 Option Inputs -->
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="options[]" placeholder="Option" required>
                                            <input type="file" class="form-control" name="images[]" accept="image/*">
                                        </div>
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
                                    {{ isset($Poll) ? 'Update Poll' : 'Add Poll' }}
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
    // Counter for added options
    let optionCount = 2; // Start with 2 options

    document.getElementById('add-option').addEventListener('click', function () {
        if (optionCount < 4) { // Maximum 4 options
            var newOption = document.createElement('div');
            newOption.classList.add('input-group', 'mb-2');
            newOption.innerHTML = '<input type="text" class="form-control" name="options[]" placeholder="Option" required><input type="file" class="form-control" name="images[]" accept="image/*">';
            document.getElementById('poll-options').appendChild(newOption);
            optionCount++;
        } else {
            alert('You can only add up to 4 options.');
        }
    });
</script>
