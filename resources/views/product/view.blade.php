@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row h-100 bg-white mt-0">
        <div class="col-sm-12">
            <div class="container p-0">
                <div class="col-sm-2 col-4 text-sm-center text-left align-middle float-left">
                    <label class="w-100">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($product->photo_name == '')
                                <img src="{{ asset('systemImages/' . $logoName) }}" class="logo mt-4 w-100">
                            @else 
                                <img src="{{ asset('images/' . Auth::user()->id . '/' . $product->photo_name) }}" class="logo mt-4 w-100">
                            @endif
                            <input type="file" id="uploadfileinp" name="logo" accept="image/*" hidden >
                            <input type="submit" name="send" id="sendLogo" style="display: none" value="Сохранить" class="col-sm-12 mt-1">
                        </form>
                    </label>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="p-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="col-sm-10 col-8 float-right mt-sm-5 mt-3 full-info">
                    <div class="company-country border-bottom border-dark mt-3">
                        <h1>{{ $product->name }}</h1>
                    </div>
                </div>
                <div class="col-sm-12 col-12 float-left mt-3 lead">
                    <p>{{ $product->description }}</p>
                </div>
                <div class="col-sm-12 col-12 float-left mt-1 lead">
                    <p>Количество: <b>{{ $product->count }}</b> шт.</p> 
                </div>
                <div class="col-sm-12 col-12 float-left mt-1 lead">
                    <p>Цена: <b>{{ $product->price }}</b> бел. руб.<p> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection