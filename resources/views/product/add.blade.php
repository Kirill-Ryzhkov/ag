@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row h-100 bg-white mt-0">
        <div class="col-sm-12 p-0">
            <div class="container">
                <div class="col-sm-12 col-12 p-0">
                    <h2 class="mt-3 text-center">Добавить новый товар</h2>
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-2 col-4 text-sm-center text-left align-middle float-left">
                            <label>
                                <img src="{{ asset('systemImages/camera.svg') }}" alt="Choose the photo" class="logo mt-2">
                                <input type="file" name="productPhoto" id="uploadfileinp" accept="image/*" hidden>
                            </label>
                        </div>
                        <div class="col-sm-10 col-8 company-name company-country float-right mt-sm-4 mt-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="productName" placeholder="Введите название товара">
                            </div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    {{ $errors->first('productName') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <textarea type="text" class="form-control" name="productDescription" placeholder="Введите описание товара"></textarea>
                            </div>
                            <div class="form-group float-left w-100">
                                 <input type="number" class="form-control" name="productCount" placeholder="Количество товара" min="0">
                            </div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger w-100 float-left">
                                    {{ $errors->first('productCount') }}
                                </div>
                            @endif
                            <div class="form-group float-right w-100">
                                <input type="number" class="form-control" name="productPrice" placeholder="Цена товара" min="0" step="0.01">
                            </div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger w-100 float-right">
                                    {{ $errors->first('productPrice') }}
                                </div>
                            @endif
                            <br><br><br>
                            <div class="form-group float-right">
                                <input type="submit" class="btn btn-primary" name="submit" value="Отправить">
                            </div>
                            <div class="form-group float-right mr-1">
                                <input type="submit" class="btn btn-outline-primary" name="cancel" value="Отмена">
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
    $('#uploadfileinp').on('change', function(event) {
        var filePath = URL.createObjectURL(event.target.files[0]);
        var html = '<img src="' + filePath + '">';
        $('.logo').attr('src', filePath);
    });
})

</script>
@endsection