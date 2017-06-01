<html>

<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    
    <h3>Coba Authorize</h3>
    <form id="coba_authorize" class="form-async" method="post" 
        action="oauth/token">
        <button type="submit" class="btn btn-primary">Coba</button>
    </form>

    <div class="auth-dulu" style="display:none">
        <h3>Coba Panggil API User</h3>
        <div><button id="panggil_user" class="btn btn-default" type="button">Coba</button></div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var auth = '';
        $('#coba_authorize').on('submit', function(e) {
            e.preventDefault();

            var meta = $('meta[name="csrf_token"]').attr('content');
            var action = $(this).attr('action');
            var data = {
                'grant_type': 'password',
                'client_id': 2,
                'client_secret': 'o9MrfcCrHs551QRyHj6h3HGiMgFfWQ9ypJmIudkW',
                'username': 'muhammaddetaaditya@gmail.com',
                'password': 'justtellmewhy',
                'scope': ''
            };

            $.ajax({
                method: 'post',
                data: data,
                url: action,
            }).done(function (data) {
                auth = data.token_type + ' ' + data.access_token;
                $('.auth-dulu').fadeIn();
            }).fail(function (err) {
                console.error(err);
            });

            return false;
        })

        $('#panggil_user').on('click', function(e) {
            axios.get('/api/user', {
                headers: {'Authorization': auth}
            }).then(response => {
                console.log(response.data);
            });
        });
    </script>
</body>
</html>