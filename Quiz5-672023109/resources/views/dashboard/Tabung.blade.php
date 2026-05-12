{{-- resources/views/dashboard/Tabung --}} 
@extends('layouts.master') 
 
@section('title', 'Tambah Tabung') 
 
@section('content') 
<div class="row justify-content-center"> 
    <div class="col-md-8 col-lg-6"> 
        <div class="card"> 
            <div class="card-header bg-primary text-white"> 
                <h4 class="mb-0">Tabung Uang</h4> 
            </div> 
            <div class="card-body"> 
                <form action="{{ route('products.store') }}" 
method="POST"> 
                    @csrf 
                     
                    {{-- Nama Tabung --}} 
                    <div class="mb-3"> 
                        <label for="name" class="form-label">Tabung Uang
<span class="text-danger">*</span></label> 
                        <input type="text" class="form-control 
@error('name') is-invalid @enderror"  
                               id="name" name="name" value="{{ 
old('name') }}" required> 
                        @error('name') 
                            <div class="invalid-feedback">{{ $message 
}}</div> 
                        @enderror 
                    </div> 

                     
                    <div class="row"> 
                        {{-- Jumlah Tabungan --}} 
                        <div class="col-md-6 mb-3"> 
                            <label for="price" class="form-label">Jumlah Tabungan  
<span class="text-danger">*</span></label> 
                            <div class="input-group"> 
                                <span class="input-group-text">Rp</span> 
                                <input type="number" class="form-control 
@error('price') is-invalid @enderror"  
                                       id="price" name="price" value="{{ 
old('price') }}" required> 
                            </div> 
                            @error('price') 
                                <div class="invalid-feedback">{{ $message 
}}</div> 
                            @enderror 
                        </div> 

                    <div class="d-flex justify-content-between"> 
                        <a href="{{ route('products.index') }}" 
class="btn btn-secondary">Kembali</a> 
                        <button type="submit" class="btn 
btn-primary">Simpan Tabungan</button> 
                    </div> 
                </form> 
            </div> 
        </div> 
    </div> 
</div> 
@endsection 