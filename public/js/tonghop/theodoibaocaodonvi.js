function loaddanhsachbaocao() {

    var datas =[{
      "stt":1,     
      "sohieu": 123,
      "tieude": "báo cáo số liệu",
      "loai": "báo cáo",
      "tendonvi": "trường thcs nhơn bình",
      "file": "file1",
      "ngaygui": "25/09/2020",
      "noidung": "noidung1"
    },{
      "stt":2,     
      "sohieu": 456,
      "tieude": "phân công tkb ký số",
      "loai": "phân công",
      "tendonvi": "trường thpt hùng vương",
      "file": "file2",
      "ngaygui": "14/07/2020",
      "noidung": "noidung2"
    },{
      "stt":3,     
      "sohieu": 789,
      "tieude": "báo cáo tổng kết",
      "loai": "báo cáo",
      "tendonvi": "trường thpt hùng vương",
      "file": "file2",
      "ngaygui": "22/05/2020",
      "noidung": "noidung3"
    },{
      "stt":4,     
      "sohieu": 101112,
      "tieude": "phân công tuần",
      "loai": "phân công",
      "tendonvi": "trường thcs nhơn bình",
      "file": "file2",
      "ngaygui": "06/06/2020",
      "noidung": "noidung4"
    },{
      "stt":5,     
      "sohieu": 101213,
      "tieude": "phân công quý",
      "loai": "phân công",
      "tendonvi": "trường thcs nhơn bình",
      "file": "file2",
      "ngaygui": "26/09/2020",
      "noidung": "noidung5"
    }
    ]

    $("#girddsbaocao").dxDataGrid({
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
                dataField: "loai"
            }, {
                caption: "Tên đơn vị",
                dataField: "tendonvi"
            }, {
                caption: "Ngày gửi",
                dataField: "ngaygui"
            }, {
                fixed: true,
                fixedPosition: "right",
                caption: "Xem",
                cellTemplate: function(container, options) {
                    container.addClass("center");
                    $("<div>")
                        .dxButton({
                            template: function(e) {
                                return $('<i class="fa fa-folder-open"></i>');
                            },
                            onClick: function(e) {
                              var data = options.data;
                              loaddatamodalthongtinchung(data);
                              $('#modalthongtinchung').modal('show');
                              
                            },
                        })
                        .css('background-color', 'info')
                        .appendTo(container);
                },
                width: 50,
            }],
    });
}

function loaddatamodalthongtinchung(data){
  var datattc = data;
  $('#idloai').val(datattc.loai);
  $('#idsohieu').val(datattc.sohieu);
  $('#idtieude').val(datattc.tieude);
  $('#idtendonvi').val(datattc.tendonvi);
  $('#idngaygui').val(datattc.ngaygui);
  $('#idnoidung').text(datattc.noidung);
}


window.onload = function() {
    loaddanhsachbaocao();
}
