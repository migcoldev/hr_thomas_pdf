@include('layouts.header')
          <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header"><strong>Importar reporte grupal</strong></div>
                    <div class="card-body">
                    <div class="example">
                        <form method="post" action="<?php echo route('pdf.usiltemplate_grupal'); ?>" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="select_facultad" class="form-label">Facultad</label>
                                <select id="select_facultad" name="select_facultad" class="form-select" aria-label="Default select example">
                                    @foreach ($faculties as $faculty)
                                    <option value="{{$faculty->id}}">{{$faculty->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="imagen_ppa" class="form-label">PPA - Gráfica externa y explicación</label>
                                <input class="form-control" id="imagen_ppa" name="imagen_ppa" type="file" accept=".png, .jpg, .jpeg">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="explicacion_ppa" name="explicacion_ppa" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imagen_teiq" class="form-label">TEIQ - Gráfica externa y explicación</label>
                                <input class="form-control" id="imagen_teiq" name="imagen_teiq" type="file" accept=".png, .jpg, .jpeg">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="explicacion_teiq" name="explicacion_teiq" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imagen_hpti" class="form-label">HPTI - Gráfica externa y explicación</label>
                                <input class="form-control" id="imagen_hpti" name="imagen_hpti" type="file" accept=".png, .jpg, .jpeg">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="explicacion_hpti" name="explicacion_hpti" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary px-4" type="submit">Generar</button>
                            </div>
                        </form>
                    </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
          </div>
          <!-- /.row-->
          <script>
            $( document ).ready(function() {
                tinymce.init({
                selector: 'textarea',
                plugins: '',
                toolbar: '',
                forced_root_block : "",
                content_style: "p { margin: 0; }",
                });
            });
          </script>
@include('layouts.footer')