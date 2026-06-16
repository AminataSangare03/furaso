@if(session('success') || session('error') || $errors->any())
    <div class="container" style="padding-top:16px">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul style="margin:6px 0 0 18px">
                    @foreach($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif
