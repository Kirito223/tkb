function reloadthongbao() {
    loaddanhsachthongbao();
    var dataGrid = $("#girddsthongbao").dxDataGrid("instance");
    dataGrid.clearSelection();
    dataGrid.refresh();
    // dataGrid.reload();
}

function loaddanhsachthongbao() {
    axios.get('getdsthongbao').then(function(response) {
        var data1 = response.data;
        var datas = data1.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });
        $("#girddsthongbao").dxDataGrid({
            dataSource: datas,
            showBorders: true,
            paging: {
                pageSize: 30
            },
            /* xap xep */
            sorting: {
                mode: "multiple"
            },
            /* loc du lieu */
            // filterRow: {
            //  visible: true,
            //  applyFilter: "auto"
            // },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Tìm kiếm..."
            },
            pager: {
                showPageSizeSelector: true,
                allowedPageSizes: [10, 20, 30],
                showInfo: true
            },
            /* co dan cot */
            allowColumnResizing: true,
            columnResizingMode: "widget",
            selection: {
                mode: "single",
            },
            columns: [{
                caption: "STT",
                dataField: "stt",
                width: 50,
            }, {
                caption: "Số hiệu",
                dataField: "sohieu",
            }, {
                caption: "Tiêu đề",
                dataField: "tieude",
            }, {
                caption: "Loại",
                dataField: "loai",
                cellTemplate: function (container, options) {
                    if (options.data.loai == 1) {
                        $(
                            "<span>Công tác quản lý</span>"
                        ).appendTo(container);
                    }
                    if (options.data.loai == 2) {
                        $(
                            "<span>Công tác chuyên môn</span>"
                        ).appendTo(container);
                    }
                    if (options.data.loai == 3) {
                        $(
                            "<span>Lịch kiểm tra</span>"
                        ).appendTo(container);
                    }
                    if (options.data.loai == 4) {
                        $(
                            "<span>Thông báo khác</span>"
                        ).appendTo(container);
                    }
                },
            }, {
                caption: "Người cập nhật",
                dataField: "tentaikhoan"
            }, {
                caption: "Gửi",
                dataField: "gui",
                cellTemplate: function (container, options) {
                    if (options.data.gui == 0) {
                        $(
                            "<span style='color:red'>Chưa gửi</span>"
                        ).appendTo(container);
                    }
                    if (options.data.gui == 1) {
                        $(
                            "<span style='color:blue'>Đã gửi</span>"
                        ).appendTo(container);
                    }
                },
            }, {
                caption: "Tình trạng",
                dataField: "trangthai",
                cellTemplate: function (container, options) {
                    if (options.data.trangthai == 0) {
                        $(
                            "<span style='color:red'>Chưa xem</span>"
                        ).appendTo(container);
                    }
                    if (options.data.trangthai == 1) {
                        $(
                            "<span style='color:blue'>Đã xem</span>"
                        ).appendTo(container);
                    }
                },
            }, {
                fixed: true,
                fixedPosition: "right",
                caption: "Xem",
                cellTemplate: function(container, options) {
                    container.addClass("center");
                    $("<div>")
                        .dxButton({
                            template: function(e) {
                                return $('<i class="fa fa-eye"></i>');
                            },
                            onClick: function(e) {
                                var data = options.data;
                                loaddatamodalthongtinchung(data);
                                $('#modalthongtinchung').modal('show');

                            },
                        })
                        .css('background-color', '#008CBA')
                        .appendTo(container);
                },
                width: 50,
            }, {
                fixed: true,
                fixedPosition: "right",
                caption: "Sửa",
                cellTemplate: function(container, options) {
                    container.addClass("center");
                    $("<div>")
                        .dxButton({
                            template: function(e) {
                                return $('<i class="fa fa-pencil-square-o"></i>');
                            },
                            onClick: function(e) {
                                var data = options.data;
                                if(data.gui == 1){
                                    Swal.fire(
                                        "Thông báo đã được gửi đi",
                                        "Thông báo đã được gửi không thể sửa",
                                        "info"
                                    );
                                }else{
                                    loadmodalsua(data);
                                    $('#modalsuathongbao').modal('show');
                                }
                            },
                        })
                        .css('background-color', '#4CAF50')
                        .appendTo(container);
                },
                width: 50,
            }, {
                fixed: true,
                fixedPosition: "right",
                caption: "Xoá",
                cellTemplate: function(container, options) {
                    container.addClass("center");
                    $("<div>")
                        .dxButton({
                            template: function(e) {
                                return $('<i class="fa fa-trash-o"></i>');
                            },
                            onClick: function(e) {
                                var data = options.data;
                                if(data.gui == 1){
                                    Swal.fire(
                                        "Thông báo đã được gửi đi",
                                        "Thông báo đã được gửi không thể xoá",
                                        "info"
                                    );
                                }else{
                                   Swal.fire({
                                        title: 'Xoá?',
                                        text: "Bạn có muốn xoá!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.value) {
                                            axios.post('delthongbao', {
                                                idthongbao: data.id
                                            }).then(function(response) {
                                                var data = response.data;
                                                if(data == 1){
                                                    Swal.fire(
                                                        'Xoá!',
                                                        'Xoá thành công.',
                                                        'success'
                                                    )
                                                    reloadthongbao();
                                                }
                                            });
                                        }
                                    }) 
                                }
                                
                            },
                        })
                        .css('background-color', '#f44336')
                        .appendTo(container);
                },
                width: 50,
            }, {
                fixed: true,
                fixedPosition: "right",
                caption: "Gửi",
                cellTemplate: function(container, options) {
                    container.addClass("center");
                    $("<div>")
                        .dxButton({
                            template: function(e) {
                                return $('<i class="fa fa-share-square-o"></i>');
                            },
                            onClick: function(e) {
                                var data = options.data;
                                if(data.gui == 1){
                                    Swal.fire(
                                        "Thông báo đã được gửi không thể gửi lại",
                                        "Thông báo đã được gửi đi",
                                        "info"
                                    );
                                }else{
                                    axios.post('sendthongbao',{
                                        idthongbao: data.id
                                    }).then(function(response) {
                                        var data = response.data;
                                        if (data == 1) {
                                            Swal.fire(
                                                "Đã gửi",
                                                "Bạn đã gửi thành công",
                                                "success"
                                            )
                                            reloadthongbao();
                                        }
                                    });
                                }
                            },
                        })
                        .css('background-color', '#C71585')
                        .appendTo(container);
                },
                width: 50,
            }],
            onToolbarPreparing: function(e) {
                var dataGrid = e.component;
                e.toolbarOptions.items.unshift({
                    location: "after",
                    widget: "dxButton",
                    options: {
                        text: "Thêm mới",
                        icon: "fa fa-plus-square",
                        onClick: function() {
                            $('#modalthemthongbao').modal('show');
                        },
                    },

                }, );
            },
        });
    });

}

$('#btnluu').click(function() {
    var idloai = $('#idloai').val();
    var idsohieu = $('#idsohieu').val();
    var idtieude = $('#idtieude').val();
    var idngaytao = $('#idngaytao').val();
    var iddonvi = $('#iddonvi').val();
    var idnoidung = $('#idnoidung').val();
    var formData = new FormData();
    var imagefile = document.querySelector('#file');
    formData.append("file", imagefile.files[0]);
    formData.append("idloai", idloai);
    formData.append("idsohieu", idsohieu);
    formData.append("idtieude", idtieude);
    formData.append("idngaytao", idngaytao);
    formData.append("iddonvi", iddonvi);
    formData.append("idnoidung", idnoidung);
    axios.post('addthongbao', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(function(response) {
        var data = response.data;
        if (data == 1) {
            Swal.fire({
                title: 'Lưu',
                text: 'Đã lưu thành công',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            $('#modalthemthongbao').modal("hide");
            $('#modalthemthongbao').on('hidden.bs.modal', function() {
                $(this).find('#formthemthongbao')[0].reset();
                // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
            });
            reloadthongbao();
        }
    });
});

$('#btnsua').click(function() {
    var idthongbao = $('#idthongbao').val();
    var idloai = $('#idloaisua').val();
    var idsohieu = $('#idsohieusua').val();
    var idtieude = $('#idtieudesua').val();
    var idngaytao = $('#idngaytaosua').val();
    var iddonvi = $('#iddonvisua').val();
    var idnoidung = $('#idnoidungsua').val();
    var formData = new FormData();
    var imagefile = document.querySelector('#filesua');
    formData.append("file", imagefile.files[0]);
    formData.append("idthongbao", idthongbao);
    formData.append("idloai", idloai);
    formData.append("idsohieu", idsohieu);
    formData.append("idtieude", idtieude);
    formData.append("idngaytao", idngaytao);
    formData.append("iddonvi", iddonvi);
    formData.append("idnoidung", idnoidung);
    axios.post('updatethongbao', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(function(response) {
        var data = response.data;
        if (data == 1) {
            Swal.fire({
                title: 'Cập nhật',
                text: 'Đã cập nhật thành công',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            $('#modalsuathongbao').modal("hide");
            $('#modalsuathongbao').on('hidden.bs.modal', function() {
                $(this).find('#formsuathongbao')[0].reset();
                // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
            });
            reloadthongbao();
        }
    });
});

function loaddatamodalthongtinchung(data){
  var datattc = data;
  var tenloai;
  if(datattc.loai == 1){
    tenloai = "Công tác quản lý";
  }else if(datattc.loai == 2){
    tenloai = "Công tác chuyên môn";
  }else if(datattc.loai == 3){
    tenloai = "Lịch kiểm tra";
  }else if(datattc.loai == 4){
    tenloai = "Thông báo khác";
  }
  var ngaytao = datattc.ngaytao;
  var formatngaytao = moment(ngaytao).format('DD-MM-YYYY');
  var ngaygui = datattc.ngaygui;
  if(ngaygui != null){
    $('#formngaygui').show();
  }else{
    $('#formngaygui').hide();
  }
  var formatngaygui = moment(ngaygui).format('DD-MM-YYYY');
  $('#idloaixem').val(tenloai);
  $('#idsohieuxem').val(datattc.sohieu);
  $('#idtieudexem').val(datattc.tieude);
  $('#idngaytaoxem').val(formatngaytao);
  $('#idngayguixem').val(formatngaygui);
  $('#idnoidungxem').text(datattc.noidung);
  var bodytruong = document.getElementById("bodytruong");
  var datatruong = datattc.truong;
  var counttruong = datatruong.length;
  for (var i = 0; i < counttruong; i++) {
        tr = document.createElement("tr");
        tr.appendChild(document.createElement('td'));
        tr.appendChild(document.createElement('td'));

        tr.cells[0].appendChild(document.createTextNode(i+1));
        tr.cells[1].appendChild(document.createTextNode(datatruong[i][0].tentruong));
        bodytruong.appendChild(tr); 
    }
    var tenfile = datattc.file;
      // var url = url('public/uploads/thongbao/'+tenfile);
      var divfile = document.getElementById("filedinhkem");
      var a = document.createElement('a');
      a.textContent= tenfile;
      a.href = "uploads/thongbao/"+tenfile+"";
      // a.target = '_blank';
      divfile.appendChild(a);
}

function loadmodalsua(data){
    var datatts = data;
    $('#idthongbao').val(datatts.id);
    $('#idloaisua option').each(function(value) {
        if (datatts.loai == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    $('#idsohieusua').val(datatts.sohieu);
    $('#idtieudesua').val(datatts.tieude);
    var ngaytaosua = datatts.ngaytao;
    var formatngaytaosua = moment(ngaytaosua).format('DD/MM/YYYY');
    $('#idngaytaosua').val(formatngaytaosua);
    $('#idnoidungsua').text(datatts.noidung);
    var tenfilesua = datatts.file;
      var divfile = document.getElementById("filedinhkemsua");
      var a = document.createElement('a');
      a.textContent= tenfilesua;
      a.href = "uploads/thongbao/"+tenfilesua+"";
      // a.target = '_blank';
      divfile.appendChild(a);
      var datadv = [];
      var datatruong = datatts.truong;
      for(var i=0;i<datatruong.length;i++){
        datadv.push(datatruong[i][0].matruong);
      }
    $('#iddonvisua').select2({ width: '100%'}).val(datadv).trigger("change"); 

}


window.onload = function() {
    loaddanhsachthongbao();
    $('#idngaytao').datepicker({
        autoclose: true,
        language: "vi",

    });
    $('#idngaytaosua').datepicker({
        autoclose: true,
        language: "vi",

    });
    axios.get('getdstruong').then(function(response) {
        var data = response.data;
        var selectmultiple = document.getElementById("iddonvi");
        var selectmultiplesua = document.getElementById("iddonvisua");
        for (var i = 0; i < data.length; i++) {
            var option = document.createElement("option");
            option.value = data[i].matruong;
            option.text = data[i].tentruong;
            selectmultiple.appendChild(option);
            
        }

        for (var j = 0; j < data.length; j++) {
            var option = document.createElement("option");
            option.value = data[j].matruong;
            option.text = data[j].tentruong;
            selectmultiplesua.appendChild(option);
            
        }
    });
    $('#iddonvi').select2({
        width: '100%'
    });

    // $('#iddonvisua').select2({
    //     width: '100%'
    // });
}

jQuery(document).ready(function () {
    jQuery('#modalthongtinchung').on('hidden.bs.modal', function (e) {
      $('#tabletruong>tbody').empty();
      $('#filedinhkem a').empty();
    });
});

jQuery(document).ready(function () {
    jQuery('#modalsuathongbao').on('hidden.bs.modal', function (e) {
      $('#filedinhkemsua a').empty();
    });
});