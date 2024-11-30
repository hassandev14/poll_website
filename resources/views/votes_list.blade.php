<!-- resources/views/votes_list.blade.php -->
@include('header')

<div class="content">
    <div class="container">
        <h4 class="mt-4">Detailed Votes List</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Poll Title</th>
                    <th>Option Voted</th>
                    <th>Vote Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($votes as $index => $vote)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $vote->user->name }}</td> <!-- Assuming 'user' relationship exists -->
                        <td>{{ $vote->poll->title }}</td> <!-- Assuming 'poll' relationship exists -->
                        <td>{{ $vote->pollOption->option_name }}</td> <!-- Assuming 'option' relationship exists -->
                        <td>{{ $vote->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('footer')
