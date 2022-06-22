@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Statement of account</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">DATETIME</th>
                                <th scope="col">AMOUNT</th>
                                <th scope="col">TYPE</th>
                                <th scope="col">DETAILS</th>
                                <th scope="col">BALANCE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($statements->count())
                                @foreach($statements as $statement)
                                    <tr>
                                        <td>{{$statements->firstItem() + $loop->index}}</td>
                                        <td>{{ $statement->created_at }}</td>
                                        <td>{{ $statement->amount }}</td>
                                        <td>{{ $statement->transactionType->name }}</td>
                                        <td>{{ $statement->details }}</td>
                                        <td>{{ $statement->balance }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align: center">No transaction data available</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {{ $statements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

