@include('header')

<div class="content">
    <div class="container">
        <h4 class="mt-4">Active User List</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>Poll Participation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->votes->count() > 0)
                                <ul>
                                    @foreach($user->votes as $vote)
                                        <li>{{ $vote->poll->title ?? 'Poll Deleted' }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>No Poll Participation</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('footer')
