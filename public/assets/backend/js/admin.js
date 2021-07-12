$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

let is_submit_true = false;
let state_result

moment.locale('id')

function setHarga(val){
    $('input[name="selected_display"]').val(val)
}

function convertToRupiah(angka)
{
    // angka = angka.split('.')[0];
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return 'Rp '+rupiah.split('',rupiah.length-1).reverse().join('');
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function deleteButton(id) {
    cur_page = DT.page();
    Swal.fire({
        title: "Hapus data ini?",
        text: "Data tidak bisa dikembalikan ketika sudah dihapus",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Tidak, kembali",
        confirmButtonText: "Ya, hapus data",
    }).then((willDelete) => {
        if (willDelete.value) {
            $('#btnLoading').show();
            $.ajax({
                type: "POST",
                url: IDH + "/delete",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (res) {
                    console.log(res);
                    $('#btnLoading').hide();
                    if (res.status == 200) {
                        DT.page(cur_page).draw('page');
                        Swal.fire({
                            title: "Sukses",
                            text: "Data yang anda pilih telah berhasil dihapus",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Data yang anda pilih gagal dihapus. " + (ADD_MSG || ''),
                            type: "error",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function (res, options, err) {
                    $('#btnLoading').hide();
                    Swal.fire({
                        title: "Error",
                        text: "Terjadi kesalahan di server. " + res.msg,
                        type: "error",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#failLoading').html(res.responseJSON.exception);
                    $('#failLoading').show();
                }
            });
        } else {
            Swal.fire({
                title: "Batal",
                text: "Data yang anda pilih tidak jadi dihapus",
                type: "error",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

function clearLoading() {
    $('#btnRefresh').find('i').removeClass('fa-spin')
    $('#btnLoading').hide();
}

$(document).on('click', '.restore-button', function(){
    let id = $(this).attr('data-id');
    cur_page = DT.page();
    Swal.fire({
        title: "Restore data ini?",
        text: "Data yang di restore akan kembali ditampilkan",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Tidak, kembali",
        confirmButtonText: "Ya, restore data",
    }).then((result) => {
        if (result.value) {
            $('#btnLoading').show();
            $.ajax({
                type: "POST",
                url: IDH,
                data: {
                    id: id
                },
                dataType: "json",
                success: function (res) {
                    console.log(res);
                    $('#btnLoading').hide();
                    if (res.status == 200) {
                        DT.page(cur_page).draw('page');
                        Swal.fire({
                            title: "Sukses",
                            text: "Data yang anda pilih telah berhasil direstore",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Data yang anda pilih gagal direstore. " + res.msg,
                            type: "error",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function (res, options, err) {
                    $('#btnLoading').hide();
                    Swal.fire({
                        title: "Error",
                        text: "Terjadi kesalahan di server. " + res.msg,
                        type: "error",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#failLoading').html(res.responseJSON.exception);
                    $('#failLoading').show();
                }
            });
        } else {
            Swal.fire({
                title: "Batal",
                text: "Data yang anda pilih tidak jadi direstore",
                type: "error",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
})

$(document).on('click', '.hapus-button', function(){
    let id = $(this).attr('data-id');
    cur_page = DT.page();
    Swal.fire({
        title: "Hapus secara permanen data ini?",
        text: "Data master dan transaksi yang berhubungan dengan data ini akan ikut terhapus, anda yakin?",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Tidak, kembali",
        confirmButtonText: "Ya, hapus data",
    }).then((result) => {
        if (result.value) {
            $('#btnLoading').show();
            $.ajax({
                type: "POST",
                url: IDH + '/hapus',
                data: {
                    id: id
                },
                dataType: "json",
                success: function (res) {
                    console.log(res);
                    $('#btnLoading').hide();
                    if (res.status == 200) {
                        DT.page(cur_page).draw('page');
                        Swal.fire({
                            title: "Sukses",
                            text: "Data yang anda pilih telah berhasil dihapus secara permanen",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Data yang anda pilih gagal dihapus. " + res.msg,
                            type: "error",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function (res, options, err) {
                    $('#btnLoading').hide();
                    Swal.fire({
                        title: "Error",
                        text: "Terjadi kesalahan di server. " + res.msg,
                        type: "error",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#failLoading').html(res.responseJSON.exception);
                    $('#failLoading').show();
                }
            });
        } else {
            Swal.fire({
                title: "Batal",
                text: "Data yang anda pilih tidak jadi dihapus secara permanen",
                type: "error",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
})

$(document).ready(function () {
    LAST_PAGE           = parseInt(getParameterByName('last_page')) || 0;
    let input_status    = getParameterByName('input_status') || '';
    let update_status   = getParameterByName('update_status') || '';
    if (input_status != '') {
        state_result = 'insert'
        Swal.fire({
            title: "Informasi",
            text: "Sukses menambahkan data baru",
            type: "success",
            showConfirmButton: false,
            timer: 2500
        });
        window.history.replaceState({}, document.title, IDH.split('?')[0]);
    }
    if (update_status != '') {
        state_result = 'update'
        Swal.fire({
            title: "Informasi",
            text: "Sukses mengubah data",
            type: "success",
            showConfirmButton: false,
            timer: 2500
        });
        window.history.replaceState({}, document.title, IDH.split('?')[0]);
    } else {
        Cookies.remove(ID_TABLE+'-dt-last-page', {path: ''})
    }

    let dateNow = new Date();
    // $('#datefrom').datetimepicker({
    //     format : 'DD/MM/YYYY HH:mm',
    //     // defaultDate : moment(dateNow).hours(0).minutes(0).seconds(0).milliseconds(0)
    // });

    // $('#datefrom').on('dp.change', function(e) {
    //     if (e.oldDate === null) {
    //         $(this).data('DateTimePicker').date(new Date(e.date._d.setHours(00, 00, 00)));
    //     }
    // });

    // $('#datefrom input').click(function(event){
    //     $('#datefrom').data("DateTimePicker").show();
    // });

    // $('#datetill').datetimepicker({
    //     useCurrent: false, //Important! See issue #1075
    //     format : 'DD/MM/YYYY HH:mm',
    //     // defaultDate : moment(dateNow).hours(0).minutes(0).seconds(0).milliseconds(0)
    // });

    // $('#datetill input').click(function(event){
    //     $('#datetill').data("DateTimePicker").show();
    // });

    // $("#datefrom").on("dp.change", function (e) {
    //     $('#datetill').data("DateTimePicker").minDate(e.date);
    // });

    // $("#datetill").on("dp.change", function (e) {
    //     $('#datefrom').data("DateTimePicker").maxDate(e.date);
    // });

    // $('.clear-tanggal').on('click', function (e) {
    //     $('#datefrom input').val('');
    //     $('#datetill input').val('');
    // });

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });

    if ( !IDH.includes('edit') && !IDH.includes('barang/add') ){
        $('input[type="radio"]').iCheck('uncheck');
    }
    $('input[type="radio"]').on('ifChecked', function(event){
        setHarga($(this).parent().parent().parent().find('input[type="text"]').val())
    })

    $('input:radio[name="is_free"]').on('change', function (e) {
        if ( this.checked && this.value == 1 ) {
            $('#htm-event').hide('300');
        } else {
            $('#htm-event').show('300');
        }
    });

    let iterator = 0
    $('#mainDataTable tfoot td').each(function () {
        let title = $(this).text()
        if (title.length > 0) {
            $(this).html('<input type="text" class="form-control" placeholder="cari ' + title + '" />');
        } else {
            $(this).html('<input type="text" class="form-control" disabled/>');
        }
    });

    $('.datatable').DataTable({
        paging: dt_old.paging || false,
        info: false,
        ordering: false,
        searching: false,
        language: {
            "emptyTable": "Tidak ada data yang bisa ditampilkan",
            "info": "Tampil _START_ s/d _END_ dari _TOTAL_ data",
            "infoEmpty": "Tampil 0 s/d 0 dari 0 data",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "lengthMenu": "Tampil _MENU_ data/halaman",
            "loadingRecords": "Sedang load data...",
            "processing": "Sedang load data...",
            "search": "Pencarian :",
            "zeroRecords": "Pencarian tidak menemukan data",
            "paginate": {
                "first": '<i class="fa fa-backward"></i>',
                "last": '<i class="fa fa-forward"></i>',
                "next": '<i class="fa fa-caret-right"></i>',
                "previous": '<i class="fa fa-caret-left"></i>'
            },
            "aria": {
                "sortAscending": ": urutkan data dari A-Z",
                "sortDescending": ": urutkan data dari Z-A"
            }
        },
    })

    DT = $('#mainDataTable').DataTable({
        rowId: ID_TABLE,
        pageLength: PAGE_LENGTH,
        lengthMenu: [
            [5, 10, 15, 25, 50, 100, -1],
            [5, 10, 15, 25, 50, 100, "Semua"]
        ],
        processing: true,
        serverSide: true,
        aaSorting: [],
        ajax: {
            url: IDH + '/datatable',
            data: AjaxData,
        },
        columnDefs: COLUMNS,
        language: {
            "emptyTable": "Tidak ada data yang bisa ditampilkan",
            "info": "Tampil _START_ s/d _END_ dari _TOTAL_ data",
            "infoEmpty": "Tampil 0 s/d 0 dari 0 data",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "lengthMenu": "Tampil _MENU_ data/halaman",
            "loadingRecords": "Sedang load data...",
            "processing": "Sedang load data...",
            "search": "Pencarian :",
            "zeroRecords": "Pencarian tidak menemukan data",
            "paginate": {
                "first": '<i class="fa fa-backward"></i>',
                "last": '<i class="fa fa-forward"></i>',
                "next": '<i class="fa fa-caret-right"></i>',
                "previous": '<i class="fa fa-caret-left"></i>'
            },
            "aria": {
                "sortAscending": ": urutkan data dari A-Z",
                "sortDescending": ": urutkan data dari Z-A"
            }
        },
        initComplete: function () {
            iterator = 0
            this.api().columns().every(function () {
                if (SELECT_COLUMNS.includes(iterator)) {
                    let column = this;
                    let select = $('<select class="form-control select2"><option value="">Semua</option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    $.ajax({
                        type: "GET",
                        url: IDH + "/combo",
                        data: {
                            col: COLUMNS[column.index()].data
                        },
                        dataType: "json",
                        success: function (res) {
                            $.each(res.data, function (idx, el) {
                                select.append('<option value="' + el.id + '">' + el.value + '</option>')
                            });
                        },
                    });

                    $('.select2').select2()
                }
                iterator++
            });

            if ( update_status != '' ){
                setTimeout(() => {
                    Swal.close()
                }, 500);
                setTimeout(() => {
                    if ( state_result == 'insert' ){
                        DT.page('last')
                    } else {
                        DT.page(parseInt(Cookies.get(ID_TABLE+'-dt-last-page'))||0)
                    }
                    DT.draw('page')
                }, 600);
            }

        },
        drawCallback: function (settings) {
            clearLoading()
        }
    });

    DT.on('order.dt search.dt', function () {
        DT.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1
        })
    }).draw()

    DT.on('page', function () {
        Cookies.set(ID_TABLE+'-dt-last-page', DT.page(), {path: ''})
    }).draw()

    DT.columns().every(function () {
        let that = this;
        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw()
            }
        })
    })

    $(document).on('click', '#btnRefresh', function () {
        $('#btnLoading').show();
        $('#failLoading').hide();
        $(this).find('i').addClass('fa-spin')
        $('td input').val('').trigger('keyup')
        DT.search('').draw()
    })

    $(document).on('click', '#btnAddHarga', function () {
        let tr = '<tr>'
            tr += '<td width="20">'
                tr += '<button class="btn btn-danger btnDeleteHarga" type="button"><i class="fa fa-window-close"></i></button>'
            tr += '</td>'
            tr += '<td>'
                tr += '<input name="harga[nama][]" type="text" class="form-control" required>'
            tr += '</td>'
            tr += '<td>'
                tr += '<input name="harga[stock][]" type="number" class="form-control" required>'
            tr += '</td>'
            tr += '<td class="text-center">'
                tr += '<input name="harga[is_display][]" type="radio" class="icheck" checked="false" required>'
            tr += '</td>'
        tr += '</tr>'
        $('#hargaContainer').append(tr)
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });
        $('input').iCheck('uncheck');
        $('input').on('ifChecked', function(event){
            setHarga($(this).parent().parent().parent().find('input[type="text"]').val())
        })
    })

    $(document).on('click', '.btnDeleteHarga', function () {
        let tr = $(this).parent().parent()
        if ( tr.find('input[type="radio"]')[0].checked ){
            $($('input[type="radio"]')[0]).iCheck('check')
            tr.remove()
        } else {
            tr.remove()
        }
    })

    $('.form-insert').on('submit', function (e) {
        if (is_submit_true == false) {
            e.preventDefault()
            Swal.fire({
                title: "Konfirmasi simpan data",
                text: "Apakah data yang anda masukkan sudah benar?",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Tidak, kembali",
                confirmButtonText: "Ya, simpan data",
            }).then((willSave) => {
                if (willSave.value) {

                    // isikan data quill kedalam inputan
                    if (typeof FLAG_QUILL !== "undefined") {
                        $('#soal').val(
                            quill.root.innerHTML
                        )
                    }

                    is_submit_true = true;
                    $('#btnSubmit').click();
                } else {
                    return false;
                }
            })
        }
    })

    $('.select2').select2()

    $('.select2-mahasiswa').select2({
        placeholder: 'cari mahasiswa...',
        ajax: {
            url: IDH + '/datamahasiswa',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama + ' - ' + item.nrp,
                            id: item.id_mahasiswa
                        }
                    })
                };
            },
            cache: true
        }
    })

    $('.flatpickr_def').flatpickr({
        locale: "id",
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
    })

    $('.flatpickr_time').flatpickr({
        locale: "id",
        altInput: true,
        enableTime: true,
        time_24hr: true,
        altFormat: "j F Y H:i",
        dateFormat: "Y-m-d H:i:S",
    })

    let Drpfy = $('.dropify').dropify({
        // messages: {
        //     'default': 'Drag dan drop sebuah file atau ambil file',
        //     'replace': 'Drag dan drop sebuah file atau ambil file untuk mengganti',
        //     'remove': 'Buang',
        //     'error': 'Ooops, sepertinya ada yang salah'
        // }
    })

    // Drpfy.on('dropify.beforeClear', function (event, element) {
    //     if (confirm("Anda yakin ingin menghapus foto ini?")){
    //         if ( $(element.element).parent().parent().attr('data-edit') != 'true' ) {
    //             $(element.element).parent().parent().remove();
    //         }
    //         if ( $(element.element).parent().parent().attr('data-page') == 'soal' ) {
    //             $('#soal-flag-gambar-deleted').val(1)
    //         }
    //     }
    // });

    // Drpfy.on('dropify.afterClear', function (event, element) {
    //     $('#old_foto').val('')
    // });

    // $(document).on('click', '#tambahGambarBarang', function(evt){
    //     $('#gambarContainer').append('<div class="col-md-6" style="padding: 0px"><input type="file" class="dropify" name="gambar[]" data-max-file-size="3M" data-height="200" /></div>');
    //     Drpfy = $('.dropify').dropify();
    //     Drpfy.on('dropify.beforeClear', function(event, element){
    //         if (confirm("Anda yakin ingin menghapus foto ini?")){
    //             if ( $(element.element).parent().parent().attr('data-edit') != 'true' ) {
    //                 $(element.element).parent().parent().remove();
    //             }
    //         }
    //     });
    //     Drpfy.on('dropify.afterClear', function (event, element) {
    //         $('#old_foto').val('')
    //     });
    // });

    $('.mdk-drawer .simplebar-content').animate({
        scrollTop: $("#sidebar-" + APP).offset().top - 155
    }, 1500);
})
