<table>
    <thead>
    <tr>
        <th>Student ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Image</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>Country</th>
        <th>Pin Code</th>
        <th>Is Admin</th>
        <th>Password</th>
        <th>Social ID</th>
        <th>Social Type</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->gender }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->address }}</td>
            <td>{{ $user->city }}</td>
            <td>{{ $user->state }}</td>
            <td>{{ $user->country }}</td>
            <td>{{ $user->zip_code }}</td>
            <td>{{ $user->is_admin }}</td>
            <td>{{ $user->password }}</td>
            <td>{{ $user->social_id }}</td>
            <td>{{ $user->social_type }}</td>
        </tr>
    @endforeach
    </tbody>
</table>