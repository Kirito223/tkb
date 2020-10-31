function reload_rangbuoctietcodinh() {
        // dsrangbuoctietcodinh();
        loaddatarangbuoctietcodinh();
        var dataGrid = $("#girdrangbuoctietcodinh").dxDataGrid("instance");
        dataGrid.clearSelection();
        dataGrid.refresh();
        // dataGrid.reload();
    }

function loadselectmonhoc() {
    axios.get('getdanhsachmonhoc').then(function(response) {
        var data = response.data;
        $.each(data, function(key, value) {
            $('#monSelect2')
                .append($("<option></option>")
                    .attr("value", value.id)
                    .text(value.tenmonhoc));
             $('#monSelect2s')
                .append($("<option></option>")
                    .attr("value", value.id)
                    .text(value.tenmonhoc));    
        });
    });
}

function loadselectmucrangbuoc() {
    axios.get('getlistrangbuoc').then(function(response) {
        var data = response.data;
        $.each(data, function(key, value) {
            $('#mucrangbuocSelect2')
                .append($("<option></option>")
                    .attr("value", value.id)
                    .text(value.mucrangbuoc));
             $('#mucrangbuocSelect2s')
                .append($("<option></option>")
                    .attr("value", value.id)
                    .text(value.mucrangbuoc));    
        });
    });
}

function rangbuoctietcodinh() {

    loadselectmonhoc();
    loadselectmucrangbuoc();

    var data = axios.get('getkhoihoc').then(function(response) {
        var data0 = response.data;
        var data1 = [];
        data0.filter(function(items){
            if(items.danhsachlophoc != ''){
                data1.push({ id:items.id,tenkhoi:items.tenkhoi,danhsachlophoc:items.danhsachlophoc});   
            }
        });
        //table khối lớp thêm mới
        let headTable = document.getElementById("headTablerbtcd");
        let bodyTable = document.getElementById("lophocsangrbtcd");
        // Tim khoi lop co nhieu lop nhat
        let max = 0;
        for (const iterator of data1) {
            if (iterator.danhsachlophoc.length > max) {
                max = iterator.danhsachlophoc.length;
            }
        }
        // Render Header truoc
        for (const iterator of data1) {
            var chkbox = document.createElement('input');
            chkbox.setAttribute("type", "checkbox");
            chkbox.setAttribute("value", iterator.id);
            chkbox.setAttribute("data-khoi", iterator.tenkhoi);
            var text = document.createTextNode(' ' + iterator.tenkhoi);
            let th = document.createElement("th");

            chkbox.onclick = function(e) {
                let chkClass = document.querySelectorAll(`.classRoom[data-khoi="${e.target.dataset.khoi}"]`);
                for (const classRoom of chkClass) {
                    classRoom.checked = e.target.checked;
                }
            };

            th.setAttribute("data-khoi", iterator.id);
            th.appendChild(chkbox);
            th.appendChild(text);
            headTable.appendChild(th);
        }
        // Render phan than(tbody)
        let className = [];
        // Lap theo so lop hoc lon nhat
        for (let position = 0; position < max; position++) {
            let tr = document.createElement("tr");
            for (const iterator of data1) {
                let td = document.createElement("td");
                var idlop = iterator.danhsachlophoc[position];
                if (iterator.danhsachlophoc[position] != undefined) {
                    var chkbox = document.createElement('input');
                    chkbox.setAttribute("type", "checkbox");
                    chkbox.setAttribute("class", "classRoom");
                    chkbox.setAttribute("value", idlop.id);
                    chkbox.setAttribute("data-khoi", iterator.danhsachlophoc[position].khoi);
                    var text = document.createTextNode(' ' + iterator.danhsachlophoc[position].tenlop);
                    td.appendChild(chkbox);
                    td.setAttribute("class", "lophoc");
                    td.appendChild(text);
                    tr.appendChild(td);
                } else {
                    tr.appendChild(td);
                }
            }
            bodyTable.appendChild(tr);
        }

        //table khối lớp sửa
        let headTables = document.getElementById("headTablerbtcds");
        let bodyTables = document.getElementById("lophocsangrbtcds");
        // Tim khoi lop co nhieu lop nhat
        let maxs = 0;
        for (const iterator of data1) {
            if (iterator.danhsachlophoc.length > maxs) {
                maxs = iterator.danhsachlophoc.length;
            }
        }
        // Render Header truoc
        for (const iterator of data1) {
            var chkbox = document.createElement('input');
            chkbox.setAttribute("type", "checkbox");
            chkbox.setAttribute("class", "classchas");
            chkbox.setAttribute("value", iterator.id);
            chkbox.setAttribute("data-khois", iterator.tenkhoi);
            var text = document.createTextNode(' ' + iterator.tenkhoi);
            let th = document.createElement("th");

            chkbox.onclick = function(e) {
                let chkClass = document.querySelectorAll(`.classRooms[data-khois="${e.target.dataset.khois}"]`);
                for (const classRooms of chkClass) {
                    classRooms.checked = e.target.checked;
                }
            };

            th.setAttribute("data-khois", iterator.id);
            th.appendChild(chkbox);
            th.appendChild(text);
            headTables.appendChild(th);
        }
        // Render phan than(tbody)
        let classNames = [];
        // Lap theo so lop hoc lon nhat
        for (let position = 0; position < maxs; position++) {
            let tr = document.createElement("tr");
            for (const iterator of data1) {
                let td = document.createElement("td");
                var idlop = iterator.danhsachlophoc[position];
                if (iterator.danhsachlophoc[position] != undefined) {
                    var chkbox = document.createElement('input');
                    chkbox.setAttribute("type", "checkbox");
                    chkbox.setAttribute("class", "classRooms");
                    chkbox.setAttribute("value", idlop.id);
                    chkbox.setAttribute("data-khois", iterator.danhsachlophoc[position].khoi);
                    var text = document.createTextNode(' ' + iterator.danhsachlophoc[position].tenlop);
                    td.appendChild(chkbox);
                    td.setAttribute("class", "lophocs");
                    td.appendChild(text);
                    tr.appendChild(td);
                } else {
                    tr.appendChild(td);
                }
            }
            bodyTables.appendChild(tr);
        }
        //
        //thêm radio áp dụng toàn trường
        $('#apdungtoantruongrbtcd').on('change',function(){
            if ($("#apdungtoantruongrbtcd").prop("checked")) {
                var dataadtt = [];
                data1.filter(function(items){
                    dataadtt.push({
                        id: items.tenkhoi
                    });
                });
                $('#apdungtoantruongid').val(JSON.stringify(dataadtt));
            }
        })
        //sửa radio áp dụng toàn trường
        $('#apdungtoantruongrbtcds').on('change',function(){
            if ($("#apdungtoantruongrbtcds").prop("checked")) {
                var dataadtt = [];
                data1.filter(function(items){
                    dataadtt.push({
                        id: items.tenkhoi
                    });
                });
                $('#apdungtoantruongids').val(JSON.stringify(dataadtt));
            }
        })
    });
}

function loaddatarangbuoctietcodinh() {
    var data = axios.get('getrangbuoctietcodinh').then(function(response) {
        var datas = response.data;
        // var datas = data1.map(function(value, label) {
        //     let data = value;
        //     let stt = label + 1;
        //     var datas = Object.assign(data, {
        //         stt: stt.toString()
        //     });
        //     return datas;
        // });

        dsrangbuoctietcodinh(datas);
    });
}

function dsrangbuoctietcodinh(datas) {
    $('#girdrangbuoctietcodinh').dxDataGrid({
        dataSource: datas,
        keyExpr: "mamonhoc",
        showBorders: true,
        paging: {
            pageSize: 10
        },
        /* xap xep */
        sorting: {
            mode: "multiple"
        },
        searchPanel: {
            visible: true,
            width: 240,
            placeholder: "Tìm kiếm...",
        },
        pager: {
            showPageSizeSelector: true,
            allowedPageSizes: [5, 10, 20],
            showInfo: true
        },
        allowColumnResizing: true,
        columnResizingMode: "widget",
        columns: [ {
            caption: "Môn",
            dataField: "tenmonhoc",
        }, {
            fixed: true,
            fixedPosition: "right",
            caption: "Xóa môn học",
            cellTemplate: function(container, options) {
                container.addClass("center");
                $("<div>")
                    .dxButton({
                        template: function(e) {
                            return $('<i class="fa fa-eraser"></i>');
                        },
                        onClick: function(e) {
                            var idmonhoc = options.data.mamonhoc;
                            Swal.fire({
                                title: 'Xoá?',
                                text: "Bạn có muốn xoá môn "+options.data.tenmonhoc+"",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.value) {
                                    axios.post('delmonhocrangbuoctietcodinh', {
                                        idmonhoc: idmonhoc
                                    }).then(function(response) {
                                        var data = response.data;
                                        if(data == 1){
                                            Swal.fire(
                                                'Xoá!',
                                                'Xoá thành công.',
                                                'success'
                                            )
                                            reload_rangbuoctietcodinh();
                                        }
                                        
                                    });
                                }
                            })
                        },
                    })
                    .css('background-color', '#C71585')
                    .appendTo(container);
            },
            width: 100,
        }
        ],
        masterDetail: {
            enabled: true,
            template: function(container, options) { 
                var tasks = options.data.dsbuoithu;
                $("<div>")
                    .dxDataGrid({
                        columnAutoWidth: true,
                        showBorders: true,
                        columns: [{
                            caption: "Lớp",
                            dataField: 'dsrbtcd',
                            cellTemplate: function(element, info) {
                                var item = info.value;
                                var datakhoi = [];
                                item.filter(function(items) {
                                    var i = datakhoi.findIndex(x => x.khoi == items.khoi);
                                    if (i <= -1) {
                                        datakhoi.push({
                                            khoi: items.khoi
                                        });
                                    }
                                    return null;
                                });
                                var temp = datakhoi.map(function(value) {
                                    return value.khoi;
                                }).join(", ");
                                $("<div>")
                                    .appendTo(element)
                                    .text("Khối: " + temp)
                                    .css("white-space", "normal")
                                    .css("overflow-wrap", 'break-word');
                            }
                        }, {
                            caption: "Thứ",
                            dataField: "tenbuoithu",
                        }, {
                            caption: "Tiết",
                            dataField: "tiet",
                        }, {
                            caption: "Mức ràng buộc",
                            dataField: "tenmucrangbuoc",
                            cellTemplate: function(element, info) {
                                var item = info.value;
                                $("<div>")
                                .appendTo(element)
                                .text("Mức " + item)
                                .css("white-space", "normal")
                                .css("overflow-wrap", 'break-word');
                            }
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
                                            var databuoithu = options.data;
                                            suarangbuoctietcodinh(databuoithu);
                                        },
                                    })
                                    .css('background-color', 'green')
                                    .appendTo(container);
                            },
                            width: 50,
                        }, {
                            fixed: true,
                            fixedPosition: "right",
                            caption: "Xóa",
                            cellTemplate: function(container, options) {
                                container.addClass("center");
                                $("<div>")
                                    .dxButton({
                                        template: function(e) {
                                            return $('<i class="fa fa-trash-o"></i>');
                                        },
                                        onClick: function(e) {
                                            var data = options.data.dsrbtcd;
                                            var idrbtcdloc = [];
                                            data.filter(function(items) {
                                                idrbtcdloc.push({
                                                    idrbtcd: items.marbtcd
                                                });
                                            });
                                            var idrbtcd = JSON.stringify(idrbtcdloc);
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
                                                    axios.post('delrangbuoctietcodinh', {
                                                        idrbtcd: idrbtcd
                                                    }).then(function(response) {
                                                        var data = response.data;
                                                        if(data == 1){
                                                            Swal.fire(
                                                                'Xoá!',
                                                                'Xoá thành công.',
                                                                'success'
                                                            )
                                                            reload_rangbuoctietcodinh();
                                                        }
                                                        
                                                    });
                                                }
                                            })
                                        },
                                    })
                                    .css('background-color', 'red')
                                    .appendTo(container);
                            },
                            width: 50,
                        }
                        ],
                        dataSource: new DevExpress.data.DataSource({
                            store: new DevExpress.data.ArrayStore({
                                key: "mamonhoc",
                                data: tasks
                            }),
                            filter: ["mamonhoc", "=", options.key]
                        })
                    }).appendTo(container);
            }
        }
    });
}

$('#btnthemtiethoc').unbind("click");
$('#btnthemtiethoc').click(function() {
    var idmon = $("#monSelect2").val();
    var idbuoi = $("#buoiSelect2").val();
    var idthu = $("#thuSelect2").val();
    var idtietthu = $("#tietthuSelect2").val();
    var idmucrangbuoc = $("#mucrangbuocSelect2").val();
    var grid = document.getElementById("table");
    var checkBoxes = grid.getElementsByClassName("classRoom");
    var id = [];
    for (var i = 0; i < checkBoxes.length; i++) {
        if (checkBoxes[i].checked) {
            var ids = checkBoxes[i].defaultValue;
            id.push({id: ids});
        }
    }
    var idkhoilopapdung;
    var idapdungtoantruong;
    if ($("#apdungtoantruongrbtcd").prop("checked")) {
        idapdungtoantruong = $('#apdungtoantruongid').val();
        idkhoilopapdung = '';
    }else{
        idapdungtoantruong = '';
        idkhoilopapdung = JSON.stringify(id);
    }
    axios.post('addrangbuoctietcodinhtiethoc', {
        idmon: idmon,
        idbuoi: idbuoi,
        idthu: idthu,
        idtietthu: idtietthu,
        idmucrangbuoc: idmucrangbuoc,
        idkhoilopapdung: idkhoilopapdung,
        idapdungtoantruong: idapdungtoantruong
    }).then(function(response) {
        var data = response.data;
        if(data == 1){
            Swal.fire({
                title: 'Lưu',
                text: 'Đã lưu thành công',
                icon: 'success',
                confirmButtonText: 'OK'
            });         
            $('#modaltiethoc').modal("hide");
            $('#modaltiethoc').on('hidden.bs.modal', function() {
                $(this).find('#formthemmoirangbuoctietcodinhtiethoc')[0].reset();
                // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
            });
            reload_rangbuoctietcodinh(); 
        }       
    });

});

function suarangbuoctietcodinh(databuoithu) {

    var data = databuoithu;
    var datarbtcd = data.dsrbtcd;
    $('#monSelect2s option').each(function(value) {
        var idmhold = data.mamonhoc;
        if (idmhold == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    $('#buoiSelect2s option').each(function(value) {
        var idbuoiold = data.mabuoi;
        if (idbuoiold == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    $('#thuSelect2s option').each(function(value) {
        var idthuold = data.mathu;
        if (idthuold == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    $('#tietthuSelect2s option').each(function(value) {
        var idtietthuold = data.tiet;
        if (idtietthuold == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    $('#mucrangbuocSelect2s option').each(function(value) {
        var idmucrangbuocold = data.mamucrangbuoc;
        if (idmucrangbuocold == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    
    var grid = document.getElementById("tables");
    var checkBoxes = grid.getElementsByClassName("classRooms");
    var checkBoxescha = grid.getElementsByClassName("classchas");

    var lopcheck = [];
    datarbtcd.map(function(items){
        for (var i = 0; i < checkBoxes.length; i++) {
            var id = checkBoxes[i].defaultValue;
            var idk = checkBoxes[i].dataset.khois;
            if (id == items.malop) {               
                checkBoxes[i].checked=true;
                lopcheck.push(idk);           
            }
        }
    });

    lopcheck.sort();

    var current = null;
    var cnt = 0;
    var demlopcheck=[];
    for (var i = 0; i < lopcheck.length; i++) {
        if (lopcheck[i] != current) {
            if (cnt > 0) {
                demlopcheck.push({idkhoi:current,sllopcheck:cnt});
            }
            current = lopcheck[i];
            cnt = 1;
        } else {
            cnt++;
        }
    }
    if (cnt > 0) {
        demlopcheck.push({idkhoi:current,sllopcheck:cnt});
    }
  
    axios.get('getkhoihoc').then(function(response) {
        var demsllopkhoi=[];
        var getdatakhoi = response.data;     
        for(var k=0;k<checkBoxescha.length;k++){
            var datakhoicha = checkBoxescha[k].dataset.khois;
            for(var m=0;m<getdatakhoi.length;m++){
                if(datakhoicha == getdatakhoi[m].tenkhoi){
                    var demlop = getdatakhoi[m].danhsachlophoc.length;
                    demsllopkhoi.push({idkhoi:datakhoicha,sllop:demlop});
                }    
            }
            
        }
        for(var n=0;n<checkBoxescha.length;n++){
            var idkhoicha = checkBoxescha[n].dataset.khois;
            for(x=0;x<demlopcheck.length;x++){
                var idkhoi = demlopcheck[x].idkhoi;
                var sllopcheck= demlopcheck[x].sllopcheck;
                for(y=0;y<demsllopkhoi.length;y++){
                    if(idkhoi == demsllopkhoi[y].idkhoi && sllopcheck == demsllopkhoi[y].sllop && idkhoicha == idkhoi && idkhoicha == demsllopkhoi[y].idkhoi){
                        checkBoxescha[n].checked = true;
                    }
                }
            }
        }

    });

    setTimeout(function() {
        $('#modalsuatiethoc').modal("show");
    }, 1500);
    // $('#modalsuatiethoc').modal("show");
    if($("#chonkhoilopapdungrbtcds").prop( "checked", true)){
        document.getElementById("formchonkhoilopapdungs").style.display = "block";  
    }
    
    $('#btncapnhattiethoc').unbind("click");
    $('#btncapnhattiethoc').click(function() {
        var idmon = $("#monSelect2s").val();
        var idbuoi = $("#buoiSelect2s").val();
        var idthu = $("#thuSelect2s").val();
        var idtietthu = $("#tietthuSelect2s").val();
        var idmucrangbuoc = $("#mucrangbuocSelect2s").val();
        var grid = document.getElementById("tables");
        var checkBoxes = grid.getElementsByClassName("classRooms");
        var id = [];
        for (var i = 0; i < checkBoxes.length; i++) {
            if (checkBoxes[i].checked) {
                var ids = checkBoxes[i].defaultValue;
                id.push({id: ids});
            }
        }
        var idrbtcdlocs = [];
        datarbtcd.filter(function(items) {
            idrbtcdlocs.push({
                idrbtcds: items.marbtcd
            });
        });
        var idrbtcds = JSON.stringify(idrbtcdlocs);
        var idkhoilopapdung;
        var idapdungtoantruong;
        if ($("#apdungtoantruongrbtcds").prop("checked")) {
            idapdungtoantruong = $('#apdungtoantruongids').val();
            idkhoilopapdung = '';
        }else{
            idapdungtoantruong = '';
            idkhoilopapdung = JSON.stringify(id);
        }
        axios.post('updaterangbuoctietcodinhtiethoc', {
            idrbtcds: idrbtcds,
            idmon: idmon,
            idbuoi: idbuoi,
            idthu: idthu,
            idtietthu: idtietthu,
            idmucrangbuoc: idmucrangbuoc,
            idkhoilopapdung: idkhoilopapdung,
            idapdungtoantruong: idapdungtoantruong
        }).then(function(response) {
            var data = response.data;
            if(data == 1){
                Swal.fire({
                    title: 'Cập nhật',
                    text: 'Cập nhật thành công',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                $('#modalsuatiethoc').modal("hide");
                $('#modalsuatiethoc').on('hidden.bs.modal', function() {
                    $(this).find('#formsuarangbuoctietcodinhtiethoc')[0].reset();
                    // $('#tables').empty();
                    // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
                });
                reload_rangbuoctietcodinh();
            }
            
        });
    });

}

$('#btndongsuatiethoc').on('click', function() {
    $('#modalsuatiethoc').on('hidden.bs.modal', function(e) {
        $(this).find('#formsuarangbuoctietcodinhtiethoc')[0].reset();
        $("#apdungtoantruongrbtcds").prop( "checked", false);
        $("#chonkhoilopapdungrbtcds").prop( "checked", false);
        document.getElementById("formchonkhoilopapdungs").style.display = "none";
        // clearitemtiethoc();
    });

});

$('#btndongtiethoc').on('click', function() {
    $('#modaltiethoc').on('hidden.bs.modal', function(e) {
        $(this).find('#formthemmoirangbuoctietcodinhtiethoc')[0].reset();
        document.getElementById("formchonkhoilopapdung").style.display = "none";
        // clearitemtiethoc();
    });

});

$('#btnthemmoitiethoc').on('click',function(){
    // clearitemtiethoc();
    // $('#modaltiethoc').find('#formthemmoirangbuoctietcodinhtiethoc')[0].reset();
    $('#modaltiethoc').modal("show");
    
});

$("#apdungtoantruongrbtcd").change(function () {
    document.getElementById("formchonkhoilopapdung").style.display = "none";
});

$("#apdungtoantruongrbtcds").change(function () {
    document.getElementById("formchonkhoilopapdungs").style.display = "none";
});

$("#chonkhoilopapdungrbtcd").change(function () {
    document.getElementById("formchonkhoilopapdung").style.display = "block";
});

$("#chonkhoilopapdungrbtcds").change(function () {
    document.getElementById("formchonkhoilopapdungs").style.display = "block";
});

jQuery(document).ready(function () {
    jQuery('#modaltiethoc').on('hidden.bs.modal', function (e) {
        $("#apdungtoantruongrbtcd").prop( "checked", false);
        $("#chonkhoilopapdungrbtcd").prop( "checked", false);
        if($("#chonkhoilopapdungrbtcd").prop( "checked", false)){
            document.getElementById("formchonkhoilopapdung").style.display = "none";
        }
        
    });
});


