function reloadrangbuocsotiet5sangtiet1chieu() {
	rangbuocsotiet5sangtiet1chieu();
	var dataGrid = $("#girdrangbuocsotiet5sang").dxDataGrid("instance");
	dataGrid.clearSelection();
	dataGrid.refresh();
	dataGrid.reload();
}

function rangbuocsotiet5sangtiet1chieu() {
    var data = axios.get('getrangbuocsotiet5sangtiet1chieu').then(function(response) {
        var data1 = response.data;
        var datas = data1.map(function(value, label) {
            let data = value;
            // console.log(data);
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });

        $("#girdrangbuocsotiet5sang").dxDataGrid({
            dataSource: datas,
            showBorders: true,
            // remoteOperations: true,
            // scrolling: {
            // 	mode: "virtual",
            // 	rowRenderingMode: "virtual"
            // },
            paging: {
                pageSize: 10
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
                allowedPageSizes: [5, 10, 20],
                showInfo: true
            },
            /* headerFilter: {
					visible: true
				}, */
            editing: {
                mode: "row",
                allowUpdating: true
            },
            /*chon row*/
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
                if (e.dataField == "ten" && e.parentType == "dataRow") {
                    e.editorOptions.readOnly = true;
                }
                if (e.dataField == "bidanh" && e.parentType == "dataRow") {
                    e.editorOptions.readOnly = true;
                }
            },
            onCellPrepared: function(e) {
                if (e.rowType === "data" && e.column.dataField !== "stt" && e.column.dataField !== "ten" && e.column.dataField !== "bidanh") {
                    e.cellElement.css("color", "red");
                }
            },
            columns: [{
                    caption: "STT",
                    dataField: "stt",
                    width: 50
                }, {
                    caption: "Tên",
                    dataField: "hovaten",
                }, {
                    caption: "Bí danh",
                    dataField: "bidanh",
                }, {
                    caption: "Số tiết 5 buổi sáng tối đa",
                    dataField: "sotiet5buoisang",
                    dataType: 'number',
                    calculateCellValue: function(rowData) {
                        var sotiet5buoisang = rowData.rangbuocsotiet5sangtiet1chieu;
                        var lucky = sotiet5buoisang.filter(function(number) {
                            return number.sotiet5buoisang;
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet5buoisang;
                        }
                    },
                }, {
                    caption: "Số tiết 1 buổi chiều tối đa",
                    dataField: "sotiet1buoichieu",
                    dataType: 'number',
                    calculateCellValue: function(rowData) {
                        var sotiet1buoichieu = rowData.rangbuocsotiet5sangtiet1chieu;
                        var lucky = sotiet1buoichieu.filter(function(number) {
                            return number.sotiet1buoichieu;
                        });
                        if (lucky == '') {
                            return null;
                        } else {
                            return lucky[0].sotiet1buoichieu;
                        }
                    },
                }

            ],
            // select data row
            onSelectionChanged: function(data) {
                var data = data.selectedRowsData;
                // updateButton.option("disabled", !data.length);
                // loaditemsotietmoimon(data);

            },
            onRowUpdating: function(e) {
       			var newData = e.newData;
       			var oldData = e.oldData;
       			var oldDatar = e.oldData.rangbuocsotiet5sangtiet1chieu;
       			var newDatalast = {};
       			var keyst5buoisang = "sotiet5buoisang";
       			var keyst1buoichieu = "sotiet1buoichieu";
       			if(newData != ''){
       				if(newData.hasOwnProperty(keyst5buoisang)){
					   	newDatalast[keyst5buoisang] = newData[keyst5buoisang];
					}else{
						newDatalast[keyst5buoisang] = 0;
					}
					if(newData.hasOwnProperty(keyst1buoichieu)){
					   	newDatalast[keyst1buoichieu] = newData[keyst1buoichieu];
					}else{
						newDatalast[keyst1buoichieu] = 0;
					}
       			}
       			var newsotiet5buoisang;
       			var newsotiet1buoichieu;

       			if(oldDatar != ''){
       				for(var i=0;i<oldDatar.length;i++){
	       				if(oldDatar[i].sotiet5buoisang == newDatalast.sotiet5buoisang){
	       					newsotiet5buoisang = oldDatar[i].sotiet5buoisang;
	       				}else if(newDatalast.sotiet5buoisang == 0){
	       					newsotiet5buoisang = oldDatar[i].sotiet5buoisang;
	       				}else if(oldDatar[i].sotiet5buoisang != newDatalast.sotiet5buoisang){
	       					newsotiet5buoisang = newDatalast.sotiet5buoisang;
	       				}
	       				if(oldDatar[i].sotiet1buoichieu == newDatalast.sotiet1buoichieu){
	       					newsotiet1buoichieu = oldDatar[i].sotiet1buoichieu;
	       				}else if(newDatalast.sotiet1buoichieu == 0){
	       					newsotiet1buoichieu = oldDatar[i].sotiet1buoichieu;
	       				}else if(oldDatar[i].sotiet1buoichieu != newDatalast.sotiet1buoichieu){
	       					newsotiet1buoichieu = newDatalast.sotiet1buoichieu;
	       				}

	       			}
       			}else{
       				newsotiet5buoisang = newDatalast.sotiet5buoisang;
       				newsotiet1buoichieu = newDatalast.sotiet1buoichieu;
       			}
       			
       			var id; 
       			if(oldDatar !=''){
       				id = oldDatar[0].id;
       			}else{
       				id = 0;
       			} 			
   				var magiaovien = oldData.id;
                var sotiet5buoisang = newsotiet5buoisang;
                var sotiet1buoichieu = newsotiet1buoichieu;
                axios.post('updatesotiet5sangtiet1chieu', {
                	id: id,
                    magiaovien: magiaovien,
                    sotiet5buoisang: sotiet5buoisang,
                    sotiet1buoichieu: sotiet1buoichieu
                }).then(function(response) {
                    var data = response.data;
                    if(data == 1){
                        Swal.fire({
                        title: 'Lưu',
                            text: 'Đã lưu thành công',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        rangbuocsotiet5sangtiet1chieu();
                    }
                    
                });
                rangbuocsotiet5sangtiet1chieu();

            }
        });

    });
}