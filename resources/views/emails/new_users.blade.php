<div>
    <div>Les identifiants des nouveaux comptes sont les suivants (format : Login - Mot de passe) :</div>
    @foreach ($data as $row)
        <p>{{ $row['login'] }} - {{ $row['pass'] }}</p>
    @endforeach
</div>