@section('Searchcategorias')	
  <div class="iso-item">
                               
                            <article class="post post-masonry">
@if(count($catalogo)>0 || $catalogo!=null)

   @foreach ($catalogo as $cat)
   
              <?php
                        $nombre = str_replace(' ', '-', $cat->nombre_servicio);
                        $nombre = str_replace('/', '-', $nombre);
                        ?>
                            
                            
                          
                                <div class="post-image">
                                        <div class="product col-sms-6 col-sm-6 col-lg-4 box">
                                <a href="{!!asset('/detalle')!!}/{!!$nombre!!}/{!!$cat->id_usr_serv!!}"  onclick="$('.container').LoadingOverlay('show');" class="product-image">
                                    <div class="first-img">
                                        <img src="{{ asset('images/icon/'.$cat->filename)}}" alt="{!!$cat->nombre_servicio!!}">
                                    </div>
                                
                                </a>
                               <div class="product-content">
                                    <h5 class="product-title"><a href="{!!asset('/detalle')!!}/{!!$nombre!!}/{!!$cat->id_usr_serv!!}"  onclick="$('.container').LoadingOverlay('show');">{!!$cat->nombre_servicio!!}</a></h5>
                                    
                                    <span class="product-price"><span class="currency-symbol">{{ trans('publico/labels.label59')}} $</span>{!!$cat->precio_desde!!}</span>
                                    <span data-toggle="tooltip" title="4" class="star-rating">
                                        <span data-stars="4"></span>
                                    </span>
                                </div>
                              
                                
                                <div class="product-action">
                                      
                                    @include('public_page.reusable.btnLikeReus', ['atraccion' =>$cat->id_usr_serv,'load'=>'btn-add-to-cart','cantidad'=>$cat->satisfechos])  
                                    
                                    
                                </div>
                                
                            </div>
                                </div>
                               
                          
                                   
                                   
                         
                            
                            
                        
                            
                            @endforeach  
                            @endif
                            
                           
                                </article>
                        </div>
                  
                                @endsection