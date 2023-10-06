@include('layouts.header')
          <div class="row">
            <div class="col-md-12">
              @if (trim($message) == 'archivo_importado')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                El archivo fue importado y convertido con éxito.
                  <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                </div>
              @elseif (trim($message) == 'error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Ocurrió un error, por favor inténtelo nuevamente.
                  <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
              <div class="card mb-4">
                <div class="card-header">Listado de Reportes convertidos</div>
                  <div class="table-responsive">
                    <table class="table border mb-0">
                      <thead class="table-light fw-semibold">
                        <tr class="align-middle">
                          <th class="text-center">Candidato</th>
                          <th class="text-center">Fecha Conversión</th>
                          <th>Link Descarga</th>
                          <th>Archivo original</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($documents as $document)
                        <tr class="align-middle">
                          <td class="text-center">
                            <div>{{$document->person}}</div>
                          </td>
                          <td class="text-center">
                            <div class="fw-semibold">{{$document->created_at}}</div>
                          </td>
                          <td>
                            <div class="fw-semibold"><a href="{{$storage_url."/reportes/".$document->converted_file}}" target="_blank">{{$document->converted_file}}</a></div>
                          </td>
                          <td>
                            <div class="fw-semibold"><a href="{{$storage_url."/originales/".$document->original_file}}" target="_blank">{{$document->original_file}}</a></div>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
          </div>
          <!-- /.row-->
@include('layouts.footer')