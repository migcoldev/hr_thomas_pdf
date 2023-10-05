@include('layouts.header')
          <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header"><strong>Importar reporte</strong></div>
                    <div class="card-body">
                    <div class="example">
                        <!-- <div class="mb-3">
                        <label class="form-label" for="formFile">Default file input example</label>
                        <input class="form-control" id="formFile" type="file">
                        </div>-->
                        <form method="post" action="<?php echo route('pdf.convertir'); ?>">
                            <div class="mb-3">
                            <label class="form-label" for="formFileMultiple">Inserte sus archivos en formato Excel (xls o xlsx)</label>
                            <input class="form-control" id="archivos" type="file" multiple="">
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