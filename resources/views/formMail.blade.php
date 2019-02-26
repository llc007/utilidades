@extends('layout.master')

@section('content')



    <div class="offset-md-2 col-md-8 pb-4 pt-3 card justify-content-center">
        @if(isset($mensaje))
            <div id="alertaMail" class="alert alert-success" role="alert">
                Su correo fue enviado con exito! {{$mensaje}}
            </div>
            <script>
                setTimeout(function() { $('#alertaMail').fadeOut(); }, 2000);
            </script>
        @endif
        <h4 class="mb-3">Enviar correo</h4>
        <form class="needs-validation" novalidate method="POST" action="{{url('sendMail')}}">
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="username">Para</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">@</span>
                    </div>
                    <input name="email" type="email" class="form-control" id="username" placeholder="Username" required>
                    <div class="invalid-feedback" style="width: 100%;">
                        Your username is required.
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="address">Asunto</label>
                <input name="asunto" type="text" class="form-control" id="address" placeholder="" required>
                <div class="invalid-feedback">
                    Please enter your shipping address.
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <label for="address2">Mensaje<span class="text-muted">(Optional)</span></label>
                <textarea name="mensaje" id="" style="width: 100%;" rows="10"></textarea>
            </div>
            <hr class="mb-4">

            <button class="btn btn-primary btn-lg btn-block" type="submit">Enviar</button>
        </form>

    </div>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'

            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation')

                // Loop over them and prevent submission
                Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            }, false)
        }())
    </script>

@endsection