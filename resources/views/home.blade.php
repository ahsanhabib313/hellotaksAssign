@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                     @if (session('error'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
            <div class="mt-3"></div>
               <div class="card reset-card">
                <div class="card-header">Re-set Password Or Email</div>

                <div class="card-body">
                   
                     

                        <form id="resetForm" method="POST" action="{{ route('reset.credentials') }}">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" name="email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" type="password" name="password">
                            </div>
                            <div class="form-group">
                                <button type="submit" id="reset" class="btn btn-success">Re-set</button>
                            </div>
                        </form>
                    

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
