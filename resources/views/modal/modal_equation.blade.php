<div class="modal fade" id="eqModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h4>Insert Equation</h4>
            </div>

            <div class="modal-body">
                <p>Start typing math below:</p>
                <math-field id="mf" virtual-keyboard-mode="off"></math-field>


            </div>

            <div class="modal-footer">
                <button class="btn btn-primary"
                    onclick="insertEquation()">Insert</button>

                <button class="btn btn-default"
                    data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>