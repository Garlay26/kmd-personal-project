@extends('layouts.master')
@section('title')
   Notification
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
        Notifications
        @endslot
        @slot('title')
        Notification List
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th class="align-middle">Time</th>
                                    <th class="align-middle">Message</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            {{ date('d/M/Y H:i', strtotime($notification->created_at)) }}
                                        </td>
                                        <td>
                                            {{ $notification->message }}
                                        </td>
                                            <td>
                                                <a href="{{ route('noti-delete', ['noti_id' => $notification->id]) }}">
                                                    <button type="button"
                                                        class="btn btn-soft-danger waves-effect waves-light"><i
                                                            class="fas fa-trash"></i></button>
                                                </a>
                                            </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $notifications->links('layouts.paginate') }}
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{ route('noti-store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Title</label>
                                        <input class="form-control" type="text" value="" id="example-text-input"
                                            name="title" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Message</label>
                                        <textarea name="message" id="" cols="30" rows="10" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <button class="btn btn-success" type="submit">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
