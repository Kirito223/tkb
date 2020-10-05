$('#khoitaodulieusotietmoimon').click(function() {
    let loaitruong = $('#loaitruongsotietmoimon').val();
    axios.post('updatesotietmoimon', {
        id: 0,
        mamonhoc: 0,
        malop: loaitruong,
        sotiet: 0
    }).then(function(response) {
        var data = response.data;
		reload_sotiet_moimon();
        if (data == 1) {
            Swal.fire({
                title: 'Lưu',
                text: 'Đã khởi tạo thành công',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }        
    });
});

$('#capnhatsotietmoimon').click(function(){   
 var lop = $('#sotietmoimonlop').val();
 var mon = $('#sotietmoimonmon').val();
 var sotiet = $('#sotietmoimonsotiet').val();
 axios.post('capnhatsotietmoimon', {lop:lop,mon:mon,sotiet:sotiet}).then(function(response) {var data = response.data;reload_sotiet_moimon();});
});




function reload_sotiet_moimon() {
    sotiet_moimon();
    var dataGrid = $("#girddanhsach_sotietmoimon").dxDataGrid("instance");
    dataGrid.refresh();
}

function sotiet_moimon() {
    var data = axios.get('getdanhsachsotietmoimon').then(function(response) {
        var data1 = response.data[0];
        var datalop = response.data[1];
        var datamon = response.data[2];
        var datas = data1.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });

        //chọn lớp
        $("#sotietmoimonlop").select2({closeOnSelect : false,
            placeholder : "Chọn lớp",
            allowHtml: true,
            allowClear: true,
            tags: true,
            width: '100%'});
        let htmllophoc = datalop.map(function(item) {
            return ('<option value="' +item.id +'">' +item.tenlop +"</option>");
        });
        $("#sotietmoimonlop").html('<option value="0">Chọn tất cả</option>' + htmllophoc);


        //chọn môn 
        $("#sotietmoimonmon").select2({
            placeholder : "Chọn môn",
            width: '100%'});
        let htmlmon = datamon.map(function(item) {
            return ('<option value="' +item.id +'">' +item.tenmonhoc +"</option>");
        });
        $("#sotietmoimonmon").html('<option value=""></option>' + htmlmon);
		
		
		
		
		

        $("#girddanhsach_sotietmoimon").dxDataGrid({
           dataSource: datas,
            showBorders: true,
            loadPanel: {
            enabled: true
            },
            height: 800,
            scrolling: {
            mode: "virtual"
            },

            sorting: {
                mode: "multiple"
            },
            filterRow: {
                visible: true,
                applyFilter: "auto"
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Tìm kiếm..."
            },
            editing: {
                mode: "row",
                allowUpdating: true
            },
            selection: {
                // mode: "multiple",
                // recursive: true
            },
            /* co dan cot */
            allowColumnResizing: true,
            columnResizingMode: "widget",
            onEditorPreparing: function(e) {
                if (e.dataField == "stt" && e.parentType == "dataRow") {
                    e.editorOptions.readOnly = true;
                }
                if (e.dataField == "tenlop" && e.parentType == "dataRow") {
                    e.editorOptions.readOnly = true;
                }
            },
            onCellPrepared: function(e) {
                if (e.rowType === "data" && e.column.dataField !== "stt" && e.column.dataField !== "tenlop") {
                    e.cellElement.css("color", "red");
                }
            },
            columns: [{
                     type: "buttons",
                    buttons: ["edit"],
                    fixed: true,
                    fixedPosition: "left"                  
                }, {
                    caption: "STT",
                    dataField: "stt",
                    width: 50,
                    fixed: true,
                }, {
                    caption: "Lớp",
                    dataField: "tenlop",
                    width: 50,
                    fixed: true,
                },

            ],
            // select data row
            onSelectionChanged: function(data) {
                var data = data.selectedRowsData;
            },
            onRowUpdating: function(e) {
                axios.get('getdanhsachmonhoc').then(function(response) {
                    var data1 = response.data;
                    var datamh = [];
                    data1.filter(function(items) {
                        datamh.push({
                            id: items.id,
                            tenmonhoc: items.tenmonhoc
                        });
                    });

                    var newData = e.newData;
                    var oldData = e.oldData.monhoc;
                    var idlop = e.oldData.id;
                    var datakey = {};
                    var newDatakey = {};
                    var datakey1 = {};
                    for (var i = 0; i < oldData.length; i++) {
                        Object.keys(newData).forEach(function(key) {
                            if (oldData[i].tenmonhoc == key) {
                                datakey[key] = oldData[i];
                                newDatakey[key] = newData[key];
                            }
                        });
                    }

                    Object.keys(datakey).forEach(function(key) {
                        Object.keys(newData).forEach(function(key1) {
                            if (!datakey.hasOwnProperty(key1)) {
                                datakey1[key1] = newData[key1];
                            }
                        });
                    });
                    //th1: edit value old
                    if (Object.keys(datakey).length != 0) {
                        Object.keys(datakey).forEach(function(key) {
                            Object.keys(newDatakey).forEach(function(key1) {
                                if (key == key1) {
                                    var sotiet = newDatakey[key1];
                                    var data = datakey[key];
                                    var id = data.id;
                                    var mamonhoc = data.mamonhoc;
                                    var malop = data.malop;
                                    if (data != "undefined") {
                                        axios.post('updatesotietmoimon', {
                                            id: id,
                                            mamonhoc: mamonhoc,
                                            malop: malop,
                                            sotiet: sotiet
                                        }).then(function(response) {
                                            var data = response.data;
                                            if (data == 1) {
                                                Swal.fire({
                                                    title: 'Lưu',
                                                    text: 'Đã lưu thành công',
                                                    icon: 'success',
                                                    confirmButtonText: 'OK'
                                                });

                                            }

                                        });
                                    }
                                }


                            });
                        });
                    }
                    //th2: vừa eidt value old, vừa thêm mới
                    if (Object.keys(datakey1).length != 0) {
                        Object.keys(datakey1).forEach(function(key) {
                            for (var i = 0; i < datamh.length; i++) {
                                if (datamh[i].tenmonhoc == key) {
                                    var sotiet = datakey1[key];
                                    var mamonhoc = datamh[i].id;
                                    var malop = idlop;
                                    axios.post('updatesotietmoimon', {
                                        id: 0,
                                        mamonhoc: mamonhoc,
                                        malop: malop,
                                        sotiet: sotiet
                                    }).then(function(response) {
                                        var data = response.data;
                                        if (data == 1) {
                                            Swal.fire({
                                                title: 'Lưu',
                                                text: 'Đã lưu thành công',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            });

                                        }

                                    });
                                }
                            }
                        });
                    }

                    //th3: thêm mới value
                    if (Object.keys(datakey).length == 0 && Object.keys(datakey1).length == 0) {
                        Object.keys(newData).forEach(function(key) {
                            for (var i = 0; i < datamh.length; i++) {
                                if (datamh[i].tenmonhoc == key) {
                                    var sotiet = newData[key];
                                    var mamonhoc = datamh[i].id;
                                    var malop = idlop;
                                    axios.post('updatesotietmoimon', {
                                        id: 0,
                                        mamonhoc: mamonhoc,
                                        malop: malop,
                                        sotiet: sotiet
                                    }).then(function(response) {
                                        var data = response.data;
                                        if (data == 1) {
                                            Swal.fire({
                                                title: 'Lưu',
                                                text: 'Đã lưu thành công',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            });

                                        }

                                    });
                                }
                            }
                        });
                    }
                    reload_sotiet_moimon();
                });

            }
        });

        axios.get('getdanhsachmonhoc').then(function(response) {

            var data = response.data;
            var datamh = [];
            data.filter(function(items) {
                datamh.push({
                    id: items.id,
                    tenmonhoc: items.tenmonhoc
                });
            });

            var dataGrid = $("#girddanhsach_sotietmoimon").dxDataGrid("instance");
            var state = dataGrid.state();
            var columns = dataGrid.option("columns");

            for (var i = 0; i < datamh.length; i++) {
                // console.log(data1);
                let datamonhoc = datamh[i];
                var tenmonhoc = datamh[i].tenmonhoc;
                // var tenmonhoc = $("<div>").html("");
                var state = dataGrid.state();
                var columns = dataGrid.option("columns");
                columns.push({
                    calculateCellValue: function(rowData) {
                        var datamonhocloc = datamonhoc;
                        var monhoc = rowData.monhoc;
                        var lucky = monhoc.filter(function(number) {
                            if (datamonhocloc.id == number.mamonhoc) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }

                    },
                    dataField: tenmonhoc,
                    caption: tenmonhoc,
                    // headerCellTemplate: $("<label><input type='checkbox' > "+ tenmonhoc +"</label>"),
                    dataType: "number",
                    width: 70,
                });

                dataGrid.option("columns", columns);
                dataGrid.state(state);
            }
        });


    });
}