@include('layouts.header')
            @if (trim($message) == 'archivo_importado')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            El archivo fue importado con éxito, puede proceder a <a href="<?php echo route('pdf.generar_grupal'); ?>">Generar el PDF</a>.
                <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
            </div>
            @elseif (trim($message) == 'error')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ocurrió un error, por favor inténtelo nuevamente.
                <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
          <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header"><strong>Importar reporte grupal</strong></div>
                    <div class="card-body">
                    <div class="example">
                        <form method="post" action="<?php echo route('pdf.convertir_grupal'); ?>" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                            <label class="form-label" for="formFileMultiple">Inserte su archivo en formato Excel (xls o xlsx)</label>
                            <!-- <input class="form-control" id="archivos" name="archivos[]" type="file" multiple="" accept=".xlsx, .xls">-->
                            <input class="form-control" id="archivos" name="archivos" type="file" accept=".xlsx, .xls">
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary px-4" type="submit">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
          </div>
          <!-- /.row-->
@include('layouts.footer')