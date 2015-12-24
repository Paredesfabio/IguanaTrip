@section('descripcionGeografica')	

        
        
@foreach ($descripcion as $operadorData)
<?php
$descripcion_esp = $operadorData->descripcion_esp;
$descripcion_eng = $operadorData->descripcion_eng;
$id = $operadorData->id;
?>
@endforeach     




<div class="wrapper uwa-font-aa">
    <div class="form-group-step2">
        <input type="hidden" value="{!!Session::get('user_id')!!}" name="id_usuario" id="id_usuario">


        {!!Form::label('detalle_servicio_1', 'Descripción Español', array("title"=>"Descripcion",'class'=>'control-label-1'))!!}
        <textarea id="descripcion_esp" name="descripcion_esp" class="ptm chng" placeholder="Descripcion" title="Descripción.">
                        {!!$descripcion_esp!!}
        </textarea>

    </div>
    <div class="form-group-step2">


        {!!Form::label('detalle_servicio_1', 'Descripción Inglés', array("title"=>"Descripcion",'class'=>'control-label-1'))!!}
        <textarea id="descripcion_eng" name="descripcion_eng" class="ptm chng" placeholder="Descripcion" title="Descripción.">
                        {!!$descripcion_eng!!}
        </textarea>
    </div>

    <div class="form-group-step2">
        <div class="box-content-button-step2">
            <a class="button" onclick="AjaxContainerRegistroWithMessage('postGeoLoc','wrapper','Se ha guardado con éxito')" href="#">Siguiente</a>
        </div>
    </div>    

</div>






@include('reusable.imageContainer',['objetoImg' => $ImgPromociones])




{!! HTML::script('js/imageContainer/jquery.tinycarousel.js') !!}

<script type="text/javascript">
            $(document).ready(function()
    {
    $('#slider1').tinycarousel();
    
    });
    



</script>
    {!! HTML::script('/js/jsModal/jquery.simplemodal.js') !!}
    {!! HTML::script('/js/jsModal/basic.js') !!}
    {!!HTML::script('js/loadingScreen/loadingoverlay.min.js') !!}
            
            {!!HTML::script('js/loadingScreen/loadingoverlay.min.js') !!}
            
    
    
    <script>
    function alertaConfirm(id){
        
        var r = confirm("Está seguro de que desea eliminar esta imagen?");
if (r == true) {
           AjaxContainerRetrunMessage("deleteImage", id)
} else {
    txt = "Cencelado";
}
    }
   </script>



@endsection
