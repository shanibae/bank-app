@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Deposit Money</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('depositMoney') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control" placeholder="Enter amount to deposit" name="amount">
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="hidden" class="form-control" name="type" value="1">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Deposit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

