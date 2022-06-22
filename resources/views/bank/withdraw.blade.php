@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Withdraw Money</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('invalid'))
                            <div class="alert alert-danger">
                                {{ session('invalid') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('withdrawMoney') }}">
                            @csrf
                            <input type="hidden" class="form-control" name="type" value="2">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control" placeholder="Enter amount to withdraw"
                                       name="amount">
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Withdraw</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

