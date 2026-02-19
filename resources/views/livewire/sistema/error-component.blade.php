@section('title')
Error
@endsection
@section('cintillo')
ERROR
@endsection


<div>

    <div class="alert alert-danger center" style="width:80%; position: relative; ">

        <H1 class="center">ERROR</H1>
        <br>

        <span style="font-size: 150%;">
            {{ $msg }}
        </span>
        <center>
            <div class="center" style="width:100%;">
                <button class="btn btn-primary center" onclick="history.back()"> Regresar </button>
            </div>
        </center>
    </div>
    <br><br>
</div>
