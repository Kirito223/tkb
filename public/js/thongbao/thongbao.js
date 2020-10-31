function reloadthongbao() {
    loaddanhsachthongbao();
    var dataGrid = $("#girddsthongbao").dxDataGrid("instance");
    dataGrid.clearSelection();
    dataGrid.refresh();
    // dataGrid.reload();
}

function loaddanhsachthongbao() {
    axios.get('getdsthongbaotruong').then(function(response) {
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
                caption: "Người gửi",
                dataField: "tentaikhoan"
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
                                if(data.trangthai == 0){
                                    axios.post('updatetrangthaixemthongbaotruong', {
                                        idthongbao: data.id
                                    });
                                }
                                loaddatamodalthongtinchung(data);
                                $('#modalthongtinchung').modal('show');

                            },
                        })
                        .css('background-color', '#008CBA')
                        .appendTo(container);
                },
                width: 50,
            }],
        });
    });

}

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
  $('#idngayguixem').val(formatngaygui);
  $('#idnoidungxem').text(datattc.noidung);
    var tenfile = datattc.file;
      // var url = url('public/uploads/thongbao/'+tenfile);
      var divfile = document.getElementById("filedinhkem");
      var a = document.createElement('a');
      a.textContent= tenfile;
      a.href = "public/uploads/thongbao/"+tenfile+"";
      // a.target = '_blank';
      divfile.appendChild(a);
}

window.onload = function() {
    loaddanhsachthongbao();

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


