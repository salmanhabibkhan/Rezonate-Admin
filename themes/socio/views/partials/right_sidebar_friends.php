<div class="col-lg-3">
    <div class="row gx-4">
        <div class="card">
            <div class="card-header"> 
                <i class="fas fa-search me-2"></i><?= esc(lang('Web.search')) ?> <!-- Use translation for "Search" -->
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><?= esc(lang('Web.name')) ?></label> <!-- Use translation for "Name" -->
                    <input type="text" class="form-control" name="query" id="keyword" placeholder="<?= esc(lang('Web.name')) ?>"> <!-- Translate placeholder -->
                </div>
                <div class="mb-3">
                    <label class="form-label"><?= esc(lang('Web.gender')) ?></label> <!-- Use translation for "Gender" -->
                    <select class="form-select" name="gender" id="gender">
                        <option value=""><?= esc(lang('Web.any')) ?></option> <!-- Translate "Any" -->
                        <option value="Male"><?= esc(lang('Web.male')) ?></option> <!-- Translate "Male" -->
                        <option value="Female"><?= esc(lang('Web.female')) ?></option> <!-- Translate "Female" -->
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?= esc(lang('Web.relationship')) ?></label> <!-- Use translation for "Relationship" -->
                    <select class="form-select" name="relationship" id="relation">
                        <option value=""><?= esc(lang('Web.any')) ?></option> <!-- Translate "Any" -->
                        <option value="1"><?= esc(lang('Web.single')) ?></option> <!-- Translate "Single" -->
                        <option value="3"><?= esc(lang('Web.married')) ?></option> <!-- Translate "Married" -->
                        <option value="4"><?= esc(lang('Web.engaged')) ?></option> <!-- Translate "Engaged" -->
                    </select>
                </div>
                <div class="d-grid">
                    <button type="button" class="btn btn-primary searchformbuttton"><?= esc(lang('Web.search')) ?></button> <!-- Use translation for "Search" button -->
                </div>
            </div>
        </div>
    </div>
</div>
