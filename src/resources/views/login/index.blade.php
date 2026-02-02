@extends('master.master_login')

@section('title')
    Login
@endsection

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Login</h3>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control" id="username" type="text" placeholder="Username" />
                                <label for="inputUsername">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password" type="password" placeholder="Password" />
                                <label for="inputPassword">Password</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button class="btn btn-primary btn-sm" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault()

            $.ajax({
                url: '/api/login',
                method: 'POST',
                data: {
                    username: $('#username').val(),
                    password: $('#password').val(),
                },
                success: function(res) {
                    localStorage.setItem('token', res.token)

                    alert('Login Berhasil')
                    window.location.href = '/dashboard'
                },
                error: function(xhr) {
                    let msg = 'Terjadi kesalahan';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    alert(msg);
                }

            })
        })
    </script>
@endsection
