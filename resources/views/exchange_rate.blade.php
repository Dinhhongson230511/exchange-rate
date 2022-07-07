<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="_token" content="{{csrf_token()}}" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <title>Exchange rate!</title>
   </head>
   <body>
      <div class="card text-center">
         <div class="card-header">
            Currency Converter
         </div>
         <div class="card-body">
            <form class="form-inline mx-auto" style="width: 800px;">
               <div class="form-group mb-2">
                  <label for="inputPassword2" class="sr-only">Currency 1</label>
                  <input type="text" name="fromCurrency" class="form-control" id="currency_1" placeholder="Currency 1" required>
               </div>
               &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-arrow-left"></i>
               <div class="form-group mx-sm-3 mb-2">
                  <label for="inputPassword2" class="sr-only">Currency 1</label>
                  <input type="text" name="toCurrency" class="form-control" id="currency_2" placeholder="Currency 2" required>
               </div>
               <button type="button" id="sub_exchange" class="btn btn-primary mb-2">Submit</button>
            </form>
            <div class="result" style="display:none;">
               <br>
               <h1 >Result:</h1>
               </br>
               <h2 class="rate-number"> &nbsp; </h2>
            </div>
            <div class="show-sign"></div>
         </div>
         <div class="card-footer text-muted">
            {{ date('Y-m-d H:i:s') }}
         </div>
      </div>
      <style>
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url('/images/loader.gif') center no-repeat;
        }
        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;   
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
        </style>
      <div class="overlay"></div>
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <script>
         $(document).ready(function(){
           $("#currency_1").keyup(function () {  
               $(this).val($(this).val().toUpperCase());  
           });
           $("#currency_2").keyup(function () {  
               $(this).val($(this).val().toUpperCase());  
           });
           $('#sub_exchange').click(function(e){
               e.preventDefault();
               var show_sign = $('.show-sign');
               $.ajax({
                   url: "{{ url('/exchange-rate/get-rate') }}",
                   method: 'get',
                   data: {
                     symbols: $('#currency_1').val(),
                     base: $('#currency_2').val(),
                   },
                   success: function(result){
                     $('.result').css('display', 'block');
                     if(result.status === 200) {
                       $('.rate-number').text(result.data.rate);
                       if(result.data.sign == 'Down') {
                        show_sign.html('<i class="fa-solid fa-down-long"></i>');
                       } else if (result.data.sign == 'Up') {
                        show_sign.html('<i class="fa-solid fa-up-long"></i>');
                       } else {
                        show_sign.html('<i class="fa-solid fa-dash"></i>');
                       }
                     }
                   },
                   error: function(XMLHttpRequest, textStatus, errorThrown) { 
                       alert("Wrong currency or currency not invalid");
                   }
               });
             });

             $(document).on({
                ajaxStart: function(){
                    $("body").addClass("loading"); 
                },
                ajaxStop: function(){ 
                    $("body").removeClass("loading"); 
                }    
            });
           });
      </script>
   </body>
</html>