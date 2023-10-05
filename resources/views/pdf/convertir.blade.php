@include('layouts.header')
    <div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header"><strong>Reportes convertidos</strong></div>
            <div class="card-body">
            <div class="example">
                <div class="mb-3">
                    <!--<ul>
                    <li>ABC</li>
                    </ul>-->
                </div>
                <div class="mb-3">
                    <a class="btn btn-primary px-4" href="<?php echo route('pdf.importar'); ?>">Volver</a>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- /.col-->
    </div>
    <!-- /.row-->
    <script>
        //@foreach ($archivos_originales as $archivo)
        let fetchRes = fetch( 
            '<?php echo route('pdf.usiltemplate'); ?>?archivo={{ $new_name }}'); 
            fetchRes.then(res => 
                res.json()).then(d => { 
                    console.log(d) 
                }) 
        //@endforeach
    </script>
@include('layouts.footer')