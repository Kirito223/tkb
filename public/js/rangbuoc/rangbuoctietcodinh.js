function reload_rangbuoctietcodinh() {
        // dsrangbuoctietcodinh();
        loaddatarangbuoctietcodinh();
        var dataGrid = $("#girdrangbuoctietcodinh").dxDataGrid("instance");
        dataGrid.clearSelection();
        // dataGrid.refresh();
        dataGrid.reload();
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
            chkbox.setAttribute("data-khoi", iterator.id);
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
            chkbox.setAttribute("value", iterator.id);
            chkbox.setAttribute("data-khois", iterator.id);
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
                        id: items.id
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
                        id: items.id
                    });
                });
                $('#apdungtoantruongids').val(JSON.stringify(dataadtt));
            }
        })
    });
}

function loaddatarangbuoctietcodinh() {
    var data = axios.get('getrangbuoctietcodinh').then(function(response) {
        var data1 = response.data;
        // console.log(data1);          
        var data2 = [];
        var lucky1 = data1.filter(function(items) {
            if (items.danhsachlophocrb != '') {
                data2.push({
                    id: items.id,
                    tenmonhoc: items.tenmonhoc,
                    danhsachlophocrb: items.danhsachlophocrb
                });
            }
        });
        var data3 = [];
        var lucky2 = data2.filter(function(items1) {
            var mamonhoc = items1.id;
            var data4 = [];
            data3.push({
                id: items1.id,
                tenmonhoc: items1.tenmonhoc,
                danhsachlophocrb: data4
            });
            var datadslhrb = items1.danhsachlophocrb;
            var lucky3 = datadslhrb.filter(function(items2) {
                if (mamonhoc == items2.mamonhoc) {
                    var mamucrangbuoc = items2.mamucrangbuoc;
                    var datamrb = items2.mucrangbuoc;
                    var lucky4 = datamrb.filter(function(items3) {
                        if (mamucrangbuoc == items3.id) {
                            data4.push({
                                id: items2.id,
                                tenlop: items2.tenlop,
                                khoi: items2.khoi,
                                idrbtcd: items2.idrbtcd,
                                mamonhoc: items2.mamonhoc,
                                mamucrangbuoc: items2.mamucrangbuoc,
                                buoi: items2.buoi,
                                thu: items2.thu,
                                tiet: items2.tiet,
                                mucrangbuoc: items3.mucrangbuoc
                            });
                        }
                    });
                }
            });
        });
        // console.log(data3);
        var datas = data3.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });
        dsrangbuoctietcodinh(datas);
    });
}

function dsrangbuoctietcodinh(datas) {
    $('#girdrangbuoctietcodinh').dxDataGrid({
        dataSource: datas,
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

        /*chon row*/
        selection: {
            mode: "single"
        },
        /* co dan cot */
        allowColumnResizing: true,
        columnResizingMode: "widget",
        columns: [{
            caption: "STT",
            dataField: "stt",
            width: 50
        }, {
            caption: "Môn",
            dataField: "tenmonhoc",
        }, {
            caption: "Lớp",
            dataField: 'danhsachlophocrb',
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
            dataField: 'danhsachlophocrb',
            cellTemplate: function(element, info) {
                var item = info.value;
                var databuoithu = [];
                item.filter(function(items) {
                    var i = databuoithu.findIndex(x => x.buoi == items.buoi);
                    if (i <= -1) {
                        databuoithu.push({
                            buoi: items.buoi,
                            thu: items.thu
                        });
                    }
                    return null;
                });
                var temp = databuoithu.map(function(value) {
                    var buoi;
                    if (value.buoi == 0) {
                        buoi = "sáng";
                    } else {
                        buoi = "chiều";
                    }
                    return "Thứ " + value.thu + " - " + buoi;
                }).join(", ");
                $("<div>")
                    .appendTo(element)
                    .text(temp)
                    .css("white-space", "normal")
                    .css("overflow-wrap", 'break-word');
            }
        }, {
            caption: "Tiết",
            dataField: 'danhsachlophocrb',
            cellTemplate: function(element, info) {
                var item = info.value;
                var datatiet = [];
                item.filter(function(items) {
                    var i = datatiet.findIndex(x => x.tiet == items.tiet);
                    if (i <= -1) {
                        datatiet.push({
                            tiet: items.tiet
                        });
                    }
                    return null;
                });
                var temp = datatiet.map(function(value) {
                    return value.tiet;
                }).join(", ");
                $("<div>")
                    .appendTo(element)
                    .text(temp)
                    .css("white-space", "normal")
                    .css("overflow-wrap", 'break-word');
            }
        }, {
            caption: "Mức ràng buộc",
            dataField: 'danhsachlophocrb',
            cellTemplate: function(element, info) {
                var item = info.value;
                var datamrb = [];
                item.filter(function(items) {
                    var i = datamrb.findIndex(x => x.mucrangbuoc == items.mucrangbuoc);
                    if (i <= -1) {
                        datamrb.push({
                            mucrangbuoc: items.mucrangbuoc
                        });
                    }
                    return null;
                });
                var temp = datamrb.map(function(value) {
                    return "Mức " + value.mucrangbuoc;
                }).join(", ");
                $("<div>")
                    .appendTo(element)
                    .text(temp)
                    .css("white-space", "normal")
                    .css("overflow-wrap", 'break-word');
            }
        }, {
            caption: "KT trùng tiết CĐ",
            // dataField: 'danhsachlophocrb',
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
                            var data1 = options.data.danhsachlophocrb;
                            var idrbtcdloc1 = [];
                            data1.filter(function(items) {
                                var i = idrbtcdloc1.findIndex(x => x.idrbtcd == items.idrbtcd);
                                if (i <= -1) {
                                    idrbtcdloc1.push(items);
                                }
                                return null;
                            });
                            suarangbuoctietcodinh(idrbtcdloc1);
                        },
                    })
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
                            var data = options.data.danhsachlophocrb;
                            var idrbtcdloc = [];
                            data.filter(function(items) {
                                var i = idrbtcdloc.findIndex(x => x.idrbtcd == items.idrbtcd);
                                if (i <= -1) {
                                    idrbtcdloc.push({
                                        idrbtcd: items.idrbtcd
                                            // tenlop: items.tenlop
                                    });
                                }
                                return null;
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
                                        Swal.fire(
                                            'Xoá!',
                                            'Xoá thành công.',
                                            'success'
                                        )
                                        reload_rangbuoctietcodinh();
                                    });
                                }
                            })
                        },
                    })
                    .appendTo(container);
            },
            width: 50,
        }],
        // select data row
        onSelectionChanged: function(data) {
            // var data = data.selectedRowsData;
            // updateButton.option("disabled", !data.length);
            // // console.log(data);
            // loaditemgvthamgiagiangday(data);
        },
    });
}

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
    var idkhoilopapdung = JSON.stringify(id);
    var idapdungtoantruong = $('#apdungtoantruongid').val();
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
        Swal.fire({
            title: 'Lưu',
            text: 'Đã lưu thành công',
            icon: 'success',
            confirmButtonText: 'OK'
        })
        $('#modaltiethoc').modal("hide");
        $('#modaltiethoc').on('hidden.bs.modal', function() {
            $(this).find('#formthemmoirangbuoctietcodinhtiethoc')[0].reset();
            // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
        })
        reload_rangbuoctietcodinh();
    });
    // reload_rangbuoctietcodinh();

});


function suarangbuoctietcodinh(idrbtcdloc1) {

    var datarblh = idrbtcdloc1;
    $('#monSelect2s option').each(function(value) {
        var idmhold = datarblh[0].mamonhoc;
        if (idmhold == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    $('#buoiSelect2s option').each(function(value) {
        var idbuoiold = datarblh[0].buoi;
        if (idbuoiold == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    $('#thuSelect2s option').each(function(value) {
        var idthuold = datarblh[0].thu;
        if (idthuold == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    $('#tietthuSelect2s option').each(function(value) {
        var idtietthuold = datarblh[0].tiet;
        if (idtietthuold == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    $('#mucrangbuocSelect2s option').each(function(value) {
        var idmucrangbuocold = datarblh[0].mamucrangbuoc;
        if (idmucrangbuocold == $(this).val()) {
            $(this).attr('selected', 'selected');
        }else{
            $(this).removeAttr('selected','selected');
        }
    });
    $('#modalsuatiethoc').modal("show");
    if($("#chonkhoilopapdungrbtcds").prop( "checked", true)){
        document.getElementById("formchonkhoilopapdungs").style.display = "block";  
    }
    var grid = document.getElementById("tables");
    var checkBoxes = grid.getElementsByClassName("classRooms");
    datarblh.map(function(items){
        for (var i = 0; i < checkBoxes.length; i++) {
            var id = checkBoxes[i].defaultValue;
            if (id == items.id) {
                checkBoxes[i].checked=true;
            }
        }
    });

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
        var idkhoilopapdung = JSON.stringify(id);
        var idrbtcdlocs = [];
        datarblh.filter(function(items) {
            idrbtcdlocs.push({
                idrbtcds: items.idrbtcd
            });
        });
        var idrbtcds = JSON.stringify(idrbtcdlocs);
        var idapdungtoantruong = $('#apdungtoantruongids').val();
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
            Swal.fire({
                title: 'Cập nhật',
                text: 'Cập nhật thành công',
                icon: 'success',
                confirmButtonText: 'OK'
            })
            var success = 1;
            $('#modalsuatiethoc').modal("hide");
            $('#modalsuatiethoc').on('hidden.bs.modal', function() {
                $(this).find('#formsuarangbuoctietcodinhtiethoc')[0].reset();
                // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
            })
            reload_rangbuoctietcodinh();
        });
        // reload_rangbuoctietcodinh();

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
