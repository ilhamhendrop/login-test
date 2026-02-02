@extends('master.master_dashboard')

@section('title')
    Dashboard
@endsection

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        authAjax({
            url: '/api/dashboard-data',
            method: 'GET',
            success: function(res) {
                if (res.user) {
                    $('#logUser').text(res.user.username)
                }
            }
        })

        $(document).on('click', '#btnLogout', function(e) {
            e.preventDefault()

            authAjax({
                url: '/api/logout',
                method: 'POST',
                success: function(res) {
                    if (res.message) {
                        alert(res.message)
                    }

                    localStorage.removeItem('token')
                    window.location.href = '/'
                },
                error: function(xhr) {
                    let msg = 'Logout Gagal'

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    alert(msg);
                    localStorage.removeItem('token');
                    window.location.href = '/';
                }
            })
        })
    </script>
@endsection
