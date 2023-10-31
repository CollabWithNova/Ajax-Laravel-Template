<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExampleAdd" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add position</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
    {{-- <form action="{{ route('admin.store') }}" method="POST"> --}}
    {{-- @csrf --}}
      <div class="offcanvas-body mx-3">
        <div class="mb-4 row ">
          <span>Nama Position</span>
          <input class="form-control" type="text" name="nama_position" placeholder="Insert Nama Position" aria-label="default input example" id="nama_position">
        </div>
        <div class="mb-4 row ">
          <span>Kode Position</span>
          <input class="form-control" type="text" name="kode_position"  placeholder="Insert Kode Position" aria-label="default input example" id="kode_position">
        </div>
        <div class="mb-4 row ">
          <span>Deskripsi Position</span>
          <input class="form-control" type="text" name="deskripsi_position"  placeholder="Insert Deskripsi Position" aria-label="default input example" id="deskripsi_position">
        </div>
        <div class="mb-4 row ">
          <span class="mb-3">Position Status</span>
          <div class="d-flex justify-content-between">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="isaktif_position" id="isaktif_position" value="1">
                <label class="form-check-label" for="isaktif_position">
                  Active
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="isaktif_position" id="isaktif_position_non" value="0" style="border-radius: 18px;border: 1px solid #A3AED0;">
                <label class="form-check-label" for="isaktif_position">
                  Non Active
                </label>
              </div>
          </div>
        </div>
        <div class="mb-4 row justify-content-center">
          <button type="button" class="btn btn-primary confir w-full" style="border-radius: 13px;background: linear-gradient(90deg, #217AFF 0%, #7F2DE7 100%);">Tambah data</button>
        </div>
      </div>
  </div>
