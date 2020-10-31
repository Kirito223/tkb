function loaddstruong(){
  axios.get('getdstruong').then(function(response) {
    var data = response.data;
    var selectListTruong = document.getElementById('idselecttruong');
    $('#idselecttruong').append("<option></option>");
    for(var i= 0; i< data.length;i++){
      var option = document.createElement("option");
        option.value = data[i].matruong;
        option.text = data[i].tentruong;
        selectListTruong.appendChild(option);
    }

    $('#idselecttruong').on('change',function(){
      var matruong = $(this).val();
      var tentruong = $(this).find('option:selected').text();
      $('#idtentruong').text(tentruong);
      loaddanhsachbaocao(matruong);
    });

  });
}



function loaddanhsachbaocao(matruong) {
  var matruong = matruong;
  axios.get('getdsbaocaodonvi').then(function(response) {
    var data = response.data;
    for(let i=0;i<data.length;i++){
      if(data[i].matruong == matruong){
        var datadsbc = data[i].danhsachbaocao;
        var datas = datadsbc.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });
      
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
                    caption: "Ngày gửi",
                    dataField: "ngaygui",
                    cellTemplate: function(container, options) {
                      var ngaygui = options.data.ngaygui;
                      var formatngaygui = moment(ngaygui).format('DD/MM/YYYY');
                      $(
                          "<span>"+formatngaygui+"</span>"
                      ).appendTo(container);
                    }
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
                                  if(data.trangthai == 0){
                                    axios.post('updatetrangthaixembaocaodonvi', {
                                        idbaocao: data.id
                                    });
                                  }
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
    }
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
  var ngaygui = datattc.ngaygui;
  var formatngaygui = moment(ngaygui).format('DD/MM/YYYY');
  $('#idloai').val(tenloai);
  $('#idsohieu').val(datattc.sohieu);
  $('#idtieude').val(datattc.tieude);
  $('#idtendonvi').val(datattc.tendonvi);
  $('#idngaygui').val(formatngaygui);
  $('#idnoidung').text(datattc.noidung);
  var tenfile = datattc.file;
  // var url = url('public/uploads/thongbao/'+tenfile);
  var divfile = document.getElementById("filedinhkem");
  var a = document.createElement('a');
  a.textContent= tenfile;
  a.href = "public/uploads/baocao/"+tenfile+"";
  // a.target = '_blank';
  divfile.appendChild(a);
}


window.onload = function() {
  loaddstruong();
  $('#idselecttruong').select2({ width: '50%'});

}

jQuery(document).ready(function () {
    jQuery('#modalthongtinchung').on('hidden.bs.modal', function (e) {
      // $('#tabletruong>tbody').empty();
      $('#filedinhkem a').empty();
    });
});