try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    require('datatables.net/js/jquery.dataTables');
    require('datatables.net-bs4/js/dataTables.bootstrap4');
    require('datatables.net-responsive/js/dataTables.responsive');
    require('datatables.net-responsive-bs4/js/responsive.bootstrap4');
    require('bootstrap-switch/dist/js/bootstrap-switch');
    require('select2/dist/js/select2.full');
    require('summernote/dist/summernote-bs4');
    window.Toastr = require('toastr/toastr');
    window.FileInput = require('bs-custom-file-input');
    require('daterangepicker');
    require('admin-lte');
    window.Dropzone = require('dropzone');
} catch (e) {
    console.log(e);
}
