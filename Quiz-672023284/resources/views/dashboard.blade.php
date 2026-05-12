<!-- resources/views/dashboard.blade.php -->

@extends('layouts.dashboard')

@section('content')

<div class="section-card">

    <h5 class="mb-3">
        Pinjaman Aktif
    </h5>

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>Tanggal</th>

                <th>Total Pinjaman</th>

                <th>Sisa Pinjaman</th>

                <th>Status</th>

            </tr>

        </thead>

        <tbody>

            @forelse($pinjamans as $pinjaman)

                <tr>

                    <td>
                        {{ $pinjaman->created_at->format('d M Y') }}
                    </td>

                    <td>
                        Rp {{ number_format($pinjaman->nominal) }}
                    </td>

                    <td>
                        Rp {{ number_format($pinjaman->sisa) }}
                    </td>

                    <td>

                        @if($pinjaman->status == 'LUNAS')

                            <span class="badge bg-success">
                                Lunas
                            </span>

                        @else

                            <span class="badge bg-warning text-dark">
                                Active
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4"
                        class="text-center">

                        Tidak ada pinjaman aktif

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection