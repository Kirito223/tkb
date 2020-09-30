$('#capnhatsotietbuoi').click(function(){   
 var buoi= $('#chonbuoisotietbuoi').val();
 var malop=$('#lopsotietbuoi').val();
 var sotiet=$('#sotietsttrongbuoi').val();
 axios.post('updatesotiettrongbuoi', {
    id: 0,
    malop: malop,
    buoi: buoi,
    thu: 0,
    sotiet: sotiet
}).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
});


function reload_sotiet_trongbuoi() {
    sotiet_trongbuoi();
    var dataGrid = $("#girddanhsach_sotiettrongbuoi").dxDataGrid("instance");
    dataGrid.clearSelection();
    dataGrid.refresh();
}

function addsotiet() {
    var data0 = axios.get('addsotiettrongbuoi').then(function(response) {
        var data01 = response.data;
    });
}

function sotiet_trongbuoi() {
    var data22 = axios.get('getdssotiettrongbuoi').then(function(response) {
        var data02 = response.data;
        if(data02 == ""){
            addsotiet();
            reload_sotiet_trongbuoi();
        }
    });


    var data = axios.get('getdanhsachsotiettrongbuoi').then(function(response) {
        var data1 = response.data[0];
        var datalop = response.data[1];
               $("#lopsotietbuoi").select2({closeOnSelect : false,
            placeholder : "Chọn lớp",
            allowHtml: true,
            allowClear: true,
            tags: true,
            width: '100%'});
        let htmllophoc = datalop.map(function(item) {
            return ('<option value="' +item.id +'">' +item.tenlop +"</option>");
        });
        $("#lopsotietbuoi").html('<option value="0">Chọn tất cả</option>' + htmllophoc);


        var datas = data1.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });
        $("#girddanhsach_sotiettrongbuoi").dxDataGrid({
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
            filterRow: {
                visible: true,
                applyFilter: "auto"
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Tìm kiếm..."
            },
            pager: {
                showPageSizeSelector: true,
                allowedPageSizes: [10,30,50],
                showInfo: true
            },
            editing: {
                mode: "row",
                allowUpdating: true,
            },
            /* co dan cot */
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [
            {
                type: "buttons",
                buttons: ["edit"]
            },{
                caption: "STT",
                dataField: "stt",
                width: 50,
                allowEditing: false,
            }, {
                caption: "Lớp",
                dataField: "tenlop",
                width: 50,
                allowEditing: false,
            }, {
                caption: "Số tiết mỗi buổi học các của lớp",
                columns: [{
                    caption: "sáng T2",
                    dataField: "tietsangt2",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.sang;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 2) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },
                }, {
                    caption: "chiều T2",
                    dataField: "tietchieut2",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.chieu;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 2) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },

                }, {
                    caption: "sáng T3",
                    dataField: "tietsangt3",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.sang;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 3) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },

                }, {
                    caption: "chiều T3",
                    dataField: "tietchieut3",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.chieu;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 3) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },

                }, {
                    caption: "sáng T4",
                    dataField: "tietsangt4",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.sang;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 4) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },

                }, {
                    caption: "chiều T4",
                    dataField: "tietchieut4",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.chieu;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 4) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },

                }, {
                    caption: "sáng T5",
                    dataField: "tietsangt5",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.sang;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 5) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },

                }, {
                    caption: "chiều T5",
                    dataField: "tietchieut5",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.chieu;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 5) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },

                }, {
                    caption: "sáng T6",
                    dataField: "tietsangt6",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.sang;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 6) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },	

                }, {
                    caption: "chiều T6",
                    dataField: "tietchieut6",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.chieu;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 6) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },

                }, {
                    caption: "sáng T7",
                    dataField: "tietsangt7",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.sang;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 7) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },

                }, {
                    caption: "chiều T7",
                    dataField: "tietchieut7",
                    // width: 70,
                    calculateCellValue: function(rowData) {
                        var buoi = rowData.buoi.chieu;
                        var lucky = buoi.filter(function(number) {
                            if (number.thu == 7) {
                                return number.sotiet;
                            }
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet;
                        }
                    },

                }],
            }],
                // select data row
                onSelectionChanged: function(data) {
                    var data = data.selectedRowsData;
                },
                onRowUpdating: function(e) {
                    var newData = e.newData;
                    var oldDatas = e.oldData.buoi.sang;
                    var oldDatac = e.oldData.buoi.chieu;
                    var lop = e.key.tenlop;

                    var luckyt2s = oldDatas.filter(function(number) {
                        if(number.buoi == 'sang' && number.thu == 2){
                            return number;
                        }
                    });
                    var luckyt2c = oldDatac.filter(function(number) {
                        if(number.buoi == 'chieu' && number.thu == 2){
                            return number;
                        }
                    });

                    var luckyt3s = oldDatas.filter(function(number) {
                        if(number.buoi == 'sang' && number.thu == 3){
                            return number;
                        }
                    });
                    var luckyt3c = oldDatac.filter(function(number) {
                        if(number.buoi == 'chieu' && number.thu == 3){
                            return number;
                        }
                    });

                    var luckyt4s = oldDatas.filter(function(number) {
                        if(number.buoi == 'sang' && number.thu == 4){
                            return number;
                        }
                    });
                    var luckyt4c = oldDatac.filter(function(number) {
                        if(number.buoi == 'chieu' && number.thu == 4){
                            return number;
                        }
                    });


                    var luckyt5s = oldDatas.filter(function(number) {
                        if(number.buoi == 'sang' && number.thu == 5){
                            return number;
                        }
                    });
                    var luckyt5c = oldDatac.filter(function(number) {
                        if(number.buoi == 'chieu' && number.thu == 5){
                            return number;
                        }
                    });

                    var luckyt6s = oldDatas.filter(function(number) {
                        if(number.buoi == 'sang' && number.thu == 6){
                            return number;
                        }
                    });
                    var luckyt6c = oldDatac.filter(function(number) {
                        if(number.buoi == 'chieu' && number.thu == 6){
                            return number;
                        }
                    });


                    var luckyt7s = oldDatas.filter(function(number) {
                        if(number.buoi == 'sang' && number.thu == 7){
                            return number;
                        }
                    });
                    var luckyt7c = oldDatac.filter(function(number) {
                        if(number.buoi == 'chieu' && number.thu == 7){
                            return number;
                        }
                    });


                    if(typeof newData.tietsangt2 != "undefined"){                        
                        var id = luckyt2s[0].id;
                        var malop = luckyt2s[0].malop;
                        var buoi = 0;
                        var thu = luckyt2s[0].thu;
                        var sotiet = newData.tietsangt2;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }
                    if(typeof newData.tietchieut2 != "undefined"){
                        var id = luckyt2c[0].id;
                        var malop = luckyt2c[0].malop;
                        var buoi = 1;
                        var thu = luckyt2c[0].thu;
                        var sotiet = newData.tietchieut2;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }

                    if(typeof newData.tietsangt3 != "undefined"){      
                        var id = luckyt3s[0].id;
                        var malop = luckyt3s[0].malop;
                        var buoi = 0;
                        var thu = luckyt3s[0].thu;
                        var sotiet = newData.tietsangt3;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});             
                    }
                    if(typeof newData.tietchieut3 != "undefined"){
                        var id = luckyt3c[0].id;
                        var malop = luckyt3c[0].malop;
                        var buoi = 1;
                        var thu = luckyt3c[0].thu;
                        var sotiet = newData.tietchieut3;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }

                    if(typeof newData.tietsangt4 != "undefined"){                        
                        var id = luckyt4s[0].id;
                        var malop = luckyt4s[0].malop;
                        var buoi = 0;
                        var thu = luckyt4s[0].thu;
                        var sotiet = newData.tietsangt4;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }
                    if(typeof newData.tietchieut4 != "undefined"){
                        var id = luckyt4c[0].id;
                        var malop = luckyt4c[0].malop;
                        var buoi = 1;
                        var thu = luckyt4c[0].thu;
                        var sotiet = newData.tietchieut4;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }

                    if(typeof newData.tietsangt5 != "undefined"){                        
                        var id = luckyt5s[0].id;
                        var malop = luckyt5s[0].malop;
                        var buoi = 0;
                        var thu = luckyt5s[0].thu;
                        var sotiet = newData.tietsangt5;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }
                    if(typeof newData.tietchieut5 != "undefined"){
                        var id = luckyt5c[0].id;
                        var malop = luckyt5c[0].malop;
                        var buoi = 1;
                        var thu = luckyt5c[0].thu;
                        var sotiet = newData.tietchieut5;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }

                    if(typeof newData.tietsangt6 != "undefined"){                        
                        var id = luckyt6s[0].id;
                        var malop = luckyt6s[0].malop;
                        var buoi = 0;
                        var thu = luckyt6s[0].thu;
                        var sotiet = newData.tietsangt6;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }
                    if(typeof newData.tietchieut6 != "undefined"){
                        var id = luckyt6c[0].id;
                        var malop = luckyt6c[0].malop;
                        var buoi = 1;
                        var thu = luckyt6c[0].thu;
                        var sotiet = newData.tietchieut6;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }

                    if(typeof newData.tietsangt7 != "undefined"){                        
                        var id = luckyt7s[0].id;
                        var malop = luckyt7s[0].malop;
                        var buoi = 0;
                        var thu = luckyt7s[0].thu;
                        var sotiet = newData.tietsangt7;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }
                    if(typeof newData.tietchieut7 != "undefined"){
                        var id = luckyt7c[0].id;
                        var malop = luckyt7c[0].malop;
                        var buoi = 1;
                        var thu = luckyt7c[0].thu;
                        var sotiet = newData.tietchieut7;
                        axios.post('updatesotiettrongbuoi', {
                            id: id,
                            malop: malop,
                            buoi: buoi,
                            thu: thu,
                            sotiet: sotiet
                        }).then(function(response) {var data = response.data;reload_sotiet_trongbuoi();});
                    }                    


                    Swal.fire({
                        title: 'Lưu',
                        text: 'Đã lưu thành công',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                },
            });
});
}
