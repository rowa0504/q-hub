@extends('layouts.app')

@section('title','Admin: Categories')

@section('content')
    <div class="container d-flex justify-content-center"> {{-- 追加した中央寄せの外枠 --}}
        <div class="row w-50">
            <div class="form-group mb-2">
                <form action="{{ route('admin.reportReasons.store') }}" method="post" class="d-flex">
                    @csrf
                    <input type="text" name="reportReason" id="reportReason" placeholder="Enter Report Reason" class="form-control me-2" autofocus>
                    <button type="submit" class="btn btn-info" style="min-width: 55px;">
                        Add
                    </button>
                    @error('reportReason')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </form>
            </div>
            <table class="table table-hover align-middle bg-white border text-secondary">
                <thead class="small table-secondary text-secondary">
                    <tr>
                        <th>#</th>
                        <th>Report Reasons</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_reportReasons as $reportReason)
                        <tr>
                            <td>{{ $reportReason->id }}</td>
                            <td>{{ $reportReason->name }}</td>
                            <td class="text-end">
                                <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#edit-reportReason-{{ $reportReason->id }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                @include('admin.reports.modal.report-reason-edit-modal')
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-reportReason-{{ $reportReason->id }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                @include('admin.reports.modal.report-reason-delete-modal')
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>No Report Reasons</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $all_reportReasons->links() }}
            </div>
        </div>
    </div> {{-- containerの閉じタグ --}}
@endsection
