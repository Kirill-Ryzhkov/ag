@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row h-100 bg-white mt-0">
        <div class="col-sm-12 p-0">
            <div class="container">
                <div class="col-sm-12 col-12 p-0">
                    <div class="col-sm-2 col-5 text-sm-center text-left align-middle float-left">
                        <img src="{{ asset('systemImages/camera.svg') }}" alt="Choose the photo" class="logo mt-2">
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="col-sm-10 col-7 company-name company-country float-right mt-sm-4 mt-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="companyName" placeholder="Введите название компании" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="companyCountry" placeholder="Введите страну компании" required>
                            </div>
                            <div class="form-group float-right">
                                <input type="submit" class="btn btn-primary" name="submit" value="Отправить">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// document.getElementById('uploadfile').addEventListener('change', function() {
//     var fileName = this.files[0].name;
//     $('.upload').text(fileName);
// });
</script>
@endsection
