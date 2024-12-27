<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Nom</th>
        <th>Ecole</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->school->name ?? 'N/A' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
