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
                            @if ($logoName == 'camera.svg')
                                <img src="{{ asset('systemImages/' . $logoName) }}" alt="Choose the photo" class="logo mt-4 w-100">
                            @else 
                                <img src="{{ asset('images/' . $user_id . '/' . $logoName) }}" alt="Choose the photo" class="logo mt-4 w-100">
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
                <div class="col-sm-10 col-8 float-right mt-sm-4 mt-3 full-info">
                    <div class="company-name border-bottom border-dark" title="Редактировать" alt="Редактировать" onclick="editCompanyInfo()"> 
                        <h1>{{ $companyInfo->name }}</h1>
                    </div>
                    <div class="company-country border-bottom border-dark mt-3" title="Редактировать" alt="Редактировать" onclick="editCompanyInfo()">
                        <h1>{{ $companyInfo->country }}</h1>
                    </div>
                    <div class="edit float-right mt-4 btn btn-primary" onclick="editCompanyInfo()">
                        <p class="mb-0">Редактировать</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    
document.getElementById('uploadfileinp').addEventListener('change', function(event) {
    var filePath = URL.createObjectURL(event.target.files[0]);
    var html = '<img src="' + filePath + '">';
    $('.logo').attr('src', filePath);
});

document.getElementById('uploadfileinp').addEventListener('change', function() {
    document.getElementById('sendLogo').style.display = 'block';
});

function editCompanyInfo(){
    var companyName = $('.company-name h1').text();
    var companyCountry = $('.company-country h1').text();
    var html = '<form method="POST" action="/main/edit">@csrf<div class="form-group"><input type="text" class="form-control" name="companyName" value="' + companyName + '" required></div><div class="form-group"><input type="text" class="form-control" name="companyCountry" value="' + companyCountry + '" required></div><div class="form-group float-right edit"><input type="submit" class="btn btn-outline-primary mr-1 cancel" name="cancel" value="Отмена" onclick="cancelEdit()"><input type="submit" class="btn btn-primary send" name="submit" value="Отправить"></div></form>';
    $('.full-info').html(html);
}
function cancelEdit(){
    var oldHtml =   '<div class="company-name border-bottom border-dark" title="Редактировать" alt="Редактировать" onclick="editCompanyInfo()">' + 
                        '<h1>{{ $companyInfo->name }}</h1>' +
                    '</div>' +
                    '<div class="company-country border-bottom border-dark mt-3" title="Редактировать" alt="Редактировать" onclick="editCompanyInfo()">' +
                        '<h1>{{ $companyInfo->country }}</h1>' + 
                    '</div>' +
                    '<div class="edit float-right mt-4 btn btn-primary" onclick="editCompanyInfo()">' +
                        '<p class="mb-0">Редактировать</p>' +
                    '</div>';
    $('.full-info').html(oldHtml);
}

</script>
@endsection

@section('controlProducts')
<div class="container">
    <div class="row h-100 bg-white mt-0">
        <div class="col-sm-2 col-4">
            <form action="/product/new" method="POST">
                @csrf
                <div class="addNewProduct mt-4">
                    <button name="addNew" class="btn btn-outline-success p-2 addNewButton"><i class="fas fa-plus-circle"></i> Добавить товар</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('allProducts')
<div class="container">
    <h2 class="mt-3">Все товары</h2>
    @if ($product == "Нет товаров")
        <div class="row h-100 bg-white mt-0 text-center mr-0 ml-0">
            <div class="col-sm-4 mt-4"> </div>
            <div class="col-sm-4 mt-4 pt-4">
                <h1 class="product-message">{{ $product }}<h1>
            </div>
    @else
        <table class="table table-hover mt-3">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Фото</th>
                <th scope="col" class="w-25">Название</th>
                <th scope="col" class="w-25">Количество</th>
                <th scope="col">Цена</th>
                <th scope="col">Изменить</th>
                <th scope="col">Удалить</th>
            </tr>
            </thead>
            <tbody>
            
                @foreach ($product as $key => $item)
                    <? global $user_id; ?>
                    <tr>
                        <th scope="row">{{ $key+1 }}</th>
                        <td width="100px"><img src="{{ asset('images/' . $user_id . '/' . $item->photo_name) }}" alt="photo" width='100%'></td>
                        <td><a href="/product/view/{{ $item->id }}">{{ $item->name }}</a></td>
                        <td class="count">
                            <div class="count-{{ $key+1 }}">
                                <a href="#" onclick="return false" class="text-danger"><i class="fas fa-minus-circle"></i></a> 
                                    <input type="text" id="{{ $item->id }}" value="{{ $item->count }}" class="w-50 input-{{ $key+1 }} form-control d-inline"> 
                                <a href="#" onclick="return false" class="text-success"><i class="fas fa-plus-circle"></i></a>
                                <div class="input-buffer"></div> 
                            </div>
                        </td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <a href="/product/edit/{{ $item->id }}"><i class="fas fa-edit fa-3x"></i></a>
                        </td>
                        <td>
                            <a href="/product/delete/{{ $item->id }}" class="text-danger"><i class="fas fa-trash-alt fa-3x"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    @endif

</div>
<script>

$(function() {

    $('.count').click(function(e){
        var count = e.target.classList[1];
        var parentCount = e.target.parentElement.parentElement.className;
        var countNum = parentCount.split('-')[1];
        
        if (count == 'fa-minus-circle'){
            var inputField = $('.input-' + countNum);
            var inputVal = inputField.val();
            inputField.val(parseInt(inputVal) - 1);
            var count = inputField.val();
            var product_id = inputField.attr('id');
            
            $.ajax ({
                url: '/changeCount',
                type: "GET",
                data: ({
                    count: count,
                    product_id: product_id
                }),
                dataType: "html",
                success: funcSuccess
            });
        } else if (count == 'fa-plus-circle'){
            var inputField = $('.input-' + countNum);
            var inputVal = inputField.val();
            inputField.val(parseInt(inputVal) + 1);
            var count = inputField.val();
            var product_id = inputField.attr('id');
            
            $.ajax ({
                url: '/changeCount',
                type: "GET",
                data: ({
                    count: count,
                    product_id: product_id
                }),
                dataType: "html",
                success: funcSuccess
            });

        } else if (count.slice(0, 5) == 'input') {
            $('.' + count).on('keyup', function(e){
                if(e.originalEvent.code == 'Enter' || e.originalEvent.code == 'Escape'){
                    $('.input').focusout();
                }
            });

            $('.' + count).focusout(function(){
                var countVal = $('.' + count).val();
                var product_id = $('.' + count).attr('id');
                $.ajax ({
                    url: '/changeCount',
                    type: "GET",
                    data: ({
                        count: countVal,
                        product_id: product_id
                    }),
                    dataType: "html",
                    success: funcSuccess
                });
            });
        } else {

        }
    });

    function funcSuccess(data){}
   
});


</script>
<style>
    .product-message{
        font-family: 'Noto Sans', sans-serif !important;
        font-weight: lighter;
        color: rgb(129, 129, 129)
    }
    .input-buffer{
        position: absolute;
        top: -1000px;
        left: -1000px;
        visibility: hidden;
        white-space: nowrap;
    }
</style>

@endsection