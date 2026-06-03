<div class="modal fade" id="modal-add" data-backdrop="static">
    <div class="modal-dialog">
        <form id="form-simpan">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <input type="hidden" id="id_bank_soal" name="id_bank_soal" value="{{ $banksoal->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>No Soal</label>
                                        <input type="text" class="form-control" id="no_soal" name="no_soal" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Soal</label>
                                        <span id="soal-latex-container" style="display: none;">
                                            <math-field id="mf-soal" virtual-keyboard-mode="off"></math-field>
                                            <button onclick="insertEquation('mf-soal','soal')" type="button" style="margin-bottom: 5px;" class="btn btn-success btn-sm">Insert Equation</button>

                                            <button onclick="clearEquation('mf-soal')" type="button" style="margin-bottom: 5px;" class="btn btn-warning btn-sm">Clear</button>

                                            <button id="btn-hide-soal-latex-container" onclick="hideEquation('soal-latex-container')" type="button" style="margin-bottom: 5px;float:right;" class="btn btn-danger btn-sm">Hide Equation</button>
                                        </span>

                                        <div>
                                            <button id="btn-show-soal-latex-container" onclick="showEquation('soal-latex-container')" type="button" style="margin-bottom: 5px;" class="btn btn-info btn-sm">Show Equation</button>

                                        </div>

                                        <textarea class="form-control" id="soal" name="soal" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Gambar Soal</label>
                                        <input type="file" class="form-control" id="gambar_soal" name="gambar_soal">
                                    </div>
                                    <div class="form-group">
                                        <label>Lanjutan Soal setelah gambar (Opsional)</label>
                                        <span id="soal-bawah-latex-container" style="display: none;">
                                            <math-field id="mf-soal_bawah" virtual-keyboard-mode="off"></math-field>
                                            <button onclick="insertEquation('mf-soal_bawah','soal_bawah')" type="button" style="margin-bottom: 5px;" class="btn btn-success btn-sm">Insert Equation</button>

                                            <button onclick="clearEquation('mf-soal_bawah')" type="button" style="margin-bottom: 5px;" class="btn btn-warning btn-sm">Clear</button>

                                            <button id="btn-hide-soal-latex-container" onclick="hideEquation('soal-bawah-latex-container')" type="button" style="margin-bottom: 5px;float:right;" class="btn btn-danger btn-sm">Hide Equation</button>
                                        </span>

                                        <div>
                                            <button id="btn-show-soal-latex-container" onclick="showEquation('soal-bawah-latex-container')" type="button" style="margin-bottom: 5px;" class="btn btn-info btn-sm">Show Equation</button>

                                        </div>
                                        <textarea class="form-control" id="soal_bawah" name="soal_bawah"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Gambar A</label>
                                        <input type="file" class="form-control" id="gambar_a" name="gambar_a">
                                    </div>
                                    <div class="form-group">
                                        <label>Jawaban A</label>
                                        <span id="jawaban-a-latex-container" style="display: none;">
                                            <math-field id="mf-jawaban_a" virtual-keyboard-mode="off"></math-field>
                                            <button onclick="insertEquation('mf-jawaban_a','jawaban_a')" type="button" style="margin-bottom: 5px;" class="btn btn-success btn-sm">Insert Equation</button>

                                            <button onclick="clearEquation('mf-jawaban_a')" type="button" style="margin-bottom: 5px;" class="btn btn-warning btn-sm">Clear</button>

                                            <button id="btn-hide-jawaban-a-latex-container" onclick="hideEquation('jawaban-a-latex-container')" type="button" style="margin-bottom: 5px;float:right;" class="btn btn-danger btn-sm">Hide Equation</button>
                                        </span>

                                        <div>
                                            <button id="btn-show-jawaban-a-latex-container" onclick="showEquation('jawaban-a-latex-container')" type="button" style="margin-bottom: 5px;" class="btn btn-info btn-sm">Show Equation</button>

                                        </div>
                                        <textarea class="form-control" id="jawaban_a" name="jawaban_a" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Gambar B</label>
                                        <input type="file" class="form-control" id="gambar_b" name="gambar_b">
                                    </div>
                                    <div class="form-group">
                                        <label>Jawaban B</label>
                                        <span id="jawaban-b-latex-container" style="display: none;">
                                            <math-field id="mf-jawaban_b" virtual-keyboard-mode="off"></math-field>
                                            <button onclick="insertEquation('mf-jawaban_b','jawaban_b')" type="button" style="margin-bottom: 5px;" class="btn btn-success btn-sm">Insert Equation</button>

                                            <button onclick="clearEquation('mf-jawaban_b')" type="button" style="margin-bottom: 5px;" class="btn btn-warning btn-sm">Clear</button>

                                            <button id="btn-hide-jawaban-b-latex-container" onclick="hideEquation('jawaban-b-latex-container')" type="button" style="margin-bottom: 5px;float:right;" class="btn btn-danger btn-sm">Hide Equation</button>
                                        </span>

                                        <div>
                                            <button id="btn-show-jawaban-b-latex-container" onclick="showEquation('jawaban-b-latex-container')" type="button" style="margin-bottom: 5px;" class="btn btn-info btn-sm">Show Equation</button>

                                        </div>
                                        <textarea class="form-control" id="jawaban_b" name="jawaban_b" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Gambar C</label>
                                        <input type="file" class="form-control" id="gambar_c" name="gambar_c">
                                    </div>
                                    <div class="form-group">
                                        <label>Jawaban C</label>
                                        <span id="jawaban-c-latex-container" style="display: none;">
                                            <math-field id="mf-jawaban_c" virtual-keyboard-mode="off"></math-field>
                                            <button onclick="insertEquation('mf-jawaban_c','jawaban_c')" type="button" style="margin-bottom: 5px;" class="btn btn-success btn-sm">Insert Equation</button>

                                            <button onclick="clearEquation('mf-jawaban_c')" type="button" style="margin-bottom: 5px;" class="btn btn-warning btn-sm">Clear</button>

                                            <button id="btn-hide-jawaban-c-latex-container" onclick="hideEquation('jawaban-c-latex-container')" type="button" style="margin-bottom: 5px;float:right;" class="btn btn-danger btn-sm">Hide Equation</button>
                                        </span>

                                        <div>
                                            <button id="btn-show-jawaban-c-latex-container" onclick="showEquation('jawaban-c-latex-container')" type="button" style="margin-bottom: 5px;" class="btn btn-info btn-sm">Show Equation</button>

                                        </div>
                                        <textarea class="form-control" id="jawaban_c" name="jawaban_c" required></textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Gambar D</label>
                                        <input type="file" class="form-control" id="gambar_d" name="gambar_d">
                                    </div>
                                    <div class="form-group">
                                        <label>Jawaban D</label>
                                        <span id="jawaban-d-latex-container" style="display: none;">
                                            <math-field id="mf-jawaban_d" virtual-keyboard-mode="off"></math-field>
                                            <button onclick="insertEquation('mf-jawaban_d','jawaban_d')" type="button" style="margin-bottom: 5px;" class="btn btn-success btn-sm">Insert Equation</button>

                                            <button onclick="clearEquation('mf-jawaban_d')" type="button" style="margin-bottom: 5px;" class="btn btn-warning btn-sm">Clear</button>

                                            <button id="btn-hide-jawaban-d-latex-container" onclick="hideEquation('jawaban-d-latex-container')" type="button" style="margin-bottom: 5px;float:right;" class="btn btn-danger btn-sm">Hide Equation</button>
                                        </span>

                                        <div>
                                            <button id="btn-show-jawaban-d-latex-container" onclick="showEquation('jawaban-d-latex-container')" type="button" style="margin-bottom: 5px;" class="btn btn-info btn-sm">Show Equation</button>

                                        </div>
                                        <textarea class="form-control" id="jawaban_d" name="jawaban_d" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-danger">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label>Gambar E</label>
                                        <input type="file" class="form-control" id="gambar_e" name="gambar_e">
                                    </div>
                                    <div class="form-group">
                                        <label>Jawaban E</label>
                                        <span id="jawaban-e-latex-container" style="display: none;">
                                            <math-field id="mf-jawaban_e" virtual-keyboard-mode="off"></math-field>
                                            <button onclick="insertEquation('mf-jawaban_e','jawaban_e')" type="button" style="margin-bottom: 5px;" class="btn btn-success btn-sm">Insert Equation</button>

                                            <button onclick="clearEquation('mf-jawaban_e')" type="button" style="margin-bottom: 5px;" class="btn btn-warning btn-sm">Clear</button>

                                            <button id="btn-hide-jawaban-e-latex-container" onclick="hideEquation('jawaban-e-latex-container')" type="button" style="margin-bottom: 5px;float:right;" class="btn btn-danger btn-sm">Hide Equation</button>
                                        </span>

                                        <div>
                                            <button id="btn-show-jawaban-e-latex-container" onclick="showEquation('jawaban-e-latex-container')" type="button" style="margin-bottom: 5px;" class="btn btn-info btn-sm">Show Equation</button>

                                        </div>
                                        <textarea class="form-control" id="jawaban_e" name="jawaban_e" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Kunci Jawaban</label>
                                        <select class="form-control" id="kunci_jawaban" name="kunci_jawaban" required>
                                            <option value=""> - Pilih - </option>
                                            <option value="a"> A </option>
                                            <option value="b"> B </option>
                                            <option value="c"> C </option>
                                            <option value="d"> D </option>
                                            <option value="e"> E </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Score</label>
                                        <input type="number" class="form-control" id="score" name="score" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Is Active</label>
                                        <select class="form-control" id="is_active" name="is_active" required>
                                            <option value=""> - Pilih - </option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->