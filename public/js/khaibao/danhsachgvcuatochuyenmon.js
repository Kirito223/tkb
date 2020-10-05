function reloaddsgvtocm() {
	danhsachgvcuatochuyenmon();
	var dataGrid = $("#girdnhapdanhsachdanhsachgvtochuyenmon").dxDataGrid("instance");
	dataGrid.refresh();
}


function locgvcuamatochuyenmon(){
	var data11 = axios.get('getdanhsachtochuyenmon').then(function(response) {
		var datatochuyen = response.data;
		$("#dsgvcuatochuyemon").dxSelectBox({
			dataSource: datatochuyen,
			displayExpr: "tentocm",
			valueExpr: "id",
			onValueChanged: function(data) {
				var idtocm = data.value;
				danhsachgvcuatochuyenmon(idtocm);
			}
		});
		danhsachgvcuatochuyenmon();
	});
}


function danhsachgvcuatochuyenmon(idtocm) {
	var a = idtocm;
	var data = axios.get('getdanhsachgvcuatochuyenmon').then(function(response) {
		var datagv = response.data.gv;
		if(a == undefined){
            if(datagv != ""){
                var datagvtocm = response.data.gvtocm;
            }else{
                var datagvtocm = [];
            }
			
		}else{
			var dgvtocm = response.data.gvtocm;
			var datagvtocm = dgvtocm.filter(function(number) {
				if(number.matochuyenmon == a){
					return number;
				}
			});
		}
		
		var datamonhoc = response.data.monhoc;
		var datatocm = response.data.tocm
		var datass = [];
		datagvtocm.filter(function(items) {
			var i = datass.findIndex(x => x.magiaovien == items.magiaovien);
			if (i <= -1) {
				datass.push({
					magiaovien: items.magiaovien,
					mucrangbuoc: items.mucrangbuoc
				});
			}
			return null;
		});
		var datasss = [];
		datass.filter(function(itemss) {
			var idgv = itemss.magiaovien;
			var mrb = itemss.mucrangbuoc;
			object = {
				mucrangbuoc: mrb,
				magiaovien: idgv,
				monhoc: datagvtocm
				.filter(({
					magiaovien
				}) => magiaovien === idgv)
				.map(function(value, label) {
					return value.mamonhoc;
				})
			};
			datasss.push(object);
		});
		var datassss = [];
		datasss.filter(function(itemss) {
			var idgv = itemss.magiaovien;
			var idmh = itemss.monhoc;
			var mrb = itemss.mucrangbuoc;
			object = {
				mucrangbuoc: mrb,
				monhoc: idmh,
				magiaovien: idgv,
				tocm: datagvtocm.filter(({
					magiaovien
				}) => magiaovien === idgv)
				.map(function(value, label) {
					return value.matochuyenmon;
				})
			};
			datassss.push(object);
		});
		var datass1 = [];
		datassss.filter(function(itemss) {
			var idgv = itemss.magiaovien;
			var idmh = itemss.monhoc;
			var idtocm = itemss.tocm;
			var mrb = itemss.mucrangbuoc;
			object = {
				mucrangbuoc: mrb,
				monhoc: idmh,
				magiaovien: idgv,
				tocm: idtocm.filter((item, index) => idtocm.indexOf(item) === index)
				.map(function(value, label) {
					return value;
				})
			};
			datass1.push(object);
		});
		var datas = datass1.map(function(value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {
				stt: stt.toString()
			});
			return datas;
		});

		var dataGrid = $("#girdnhapdanhsachdanhsachgvtochuyenmon").dxDataGrid({
			dataSource: datas,
			showBorders: true,
            scrolling: {
                mode: 'infinite'
            },
            height:800,
            // paging: {
            //     pageSize: 10
            // },
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
            // pager: {
            //     showPageSizeSelector: true,
            //     allowedPageSizes: [5, 10, 20],
            //     showInfo: true
            // },
            /*chon row*/
            // selection: {
            //     mode: "single"
            // },
            editing: {
                mode: "batch",
                allowUpdating: true,
                selectTextOnEditStart: true,
                startEditAction: "click",
                // allowDeleting: true,
                allowAdding: true,
            },
            /* co dan cot */
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [{
            	caption: "STT",
            	dataField: "stt",
            	width: 50,
            	allowEditing: false,
            }, {
            	caption: "Họ và tên",
            	dataField: "magiaovien",
            	lookup: {
            		dataSource: datagv,
            		valueExpr: "id",
            		displayExpr: "hovaten"
            	},
            	width: 100,
            }, {
            	caption: "Bí danh",
            	dataField: "magiaovien",
            	allowEditing: false,
            	allowSorting: false,
            	lookup: {
            		dataSource: datagv,
            		valueExpr: "id",
            		displayExpr: "bidanh"
            	},
            	width: 100,
            }, {
            	caption: "Tổ chuyên môn",
            	width: 180,
            	dataField: 'tocm',
            	lookup: {
            		dataSource: datatocm,
            		valueExpr: "id",
            		displayExpr: "tentocm"
            	},
            	editCellTemplate: tagBoxEditorTemplate2,
            	validationRules: [{
            		type: "required",
            		message: 'Bạn cần chọn tổ chuyên môn'
            	}],
            	cellTemplate: function(container, options) {
            		matocm = options.value;
            		var noBreakSpace = "\u00A0",
            		text = (options.value || []).map(function(element) {
            			return options.column.lookup.calculateCellValue(element);
            		}).join(", ");
            		container.text(text || noBreakSpace).attr("title", text);
            	},
            	calculateFilterExpression: function(filterValue, selectedFilterOperation, target) {
            		if (target === "search" && typeof(filterValue) === "string") {
            			return [this.dataField, "contains", filterValue]
            		}
            		return function(data) {
            			return (data.AssignedEmployee || []).indexOf(filterValue) !== -1
            		}
            	}
            }, {
            	caption: "Môn học",
            	dataField: "monhoc",
            	lookup: {
            		dataSource: datamonhoc,
            		valueExpr: "id",
            		displayExpr: "tenmonhoc"
            	},
                    // width: 200,
                    editCellTemplate: tagBoxEditorTemplate,
                    validationRules: [{
                    	type: "required",
                    	message: 'Bạn cần chọn môn học'
                    }],
                    cellTemplate: function(container, options) {
                    	var noBreakSpace = "\u00A0",
                    	text = (options.value || []).map(function(element) {
                    		return options.column.lookup.calculateCellValue(element);
                    	}).join(", ");
                    	container.text(text || noBreakSpace).attr("title", text);
                    },
                    calculateFilterExpression: function(filterValue, selectedFilterOperation, target) {
                    	if (target === "search" && typeof(filterValue) === "string") {
                    		return [this.dataField, "contains", filterValue]
                    	}
                    	return function(data) {
                    		return (data.AssignedEmployee || []).indexOf(filterValue) !== -1
                    	}
                    }
                },
                {
                	caption: "Mức ràng buộc",
                	dataField: 'mucrangbuoc',
                	lookup: {
                		dataSource: [{
                			id: 1,
                			muc: "0"
                		}, {
                			id: 2,
                			muc: "1"
                		}, {
                			id: 3,
                			muc: "2"
                		}, {
                			id: 4,
                			muc: "3"
                		}, ],
                		valueExpr: "id",
                		displayExpr: "muc"
                	},
                	width: 80,
                },
                // {
                // 	caption: "Hiển thị phân công chuyên môn",
                // 	dataField: 'mucrangbuoc',
                // 	allowEditing: false,	
                // },
                ],
			
					
					                onContextMenuPreparing: function(data) {
                    if (data.target == "content") {
                        if (!data.items) data.items = [];
                        data.items.push({
                            template: function() {
                                return $("<i class='fa fa-remove'>").text(" Xóa");
                            },
                            onItemClick: function() {
                                var dataxoa = data.row.data.magiaovien;
                                xoadsgvphancong(dataxoa);
                            }
                        });
                        data.items.push({
                            template: function() {
                                return $("<i class='fa fa-remove'>").text(" Xóa toàn bộ");
                            },
                            onItemClick: function() {
                                var dataxoahet = datas;
                                xoadsgvphancongall(dataxoahet);
                            }
                        });
                    }
                },
			
					
			
					
            // select data row
            onSelectionChanged: function(selectedItems) {},
            onRowUpdating: function(e) {
            	var dsgvchongiaovienold = e.oldData.magiaovien;
            	var dsgvchongiaoviennew = e.newData.magiaovien;
            	if (e.newData.tocm === undefined) {
            		var dsgvchontochuyemon = e.oldData.tocm[0];
            	} else {
            		var dsgvchontochuyemon = e.newData.tocm[0];
            	}
            	if (e.newData.monhoc === undefined) {
            		var dsgvchonmonhoc = e.oldData.monhoc;
            	} else {
            		var dsgvchonmonhoc = e.newData.monhoc;
            	}
            	if (e.newData.mucrangbuoc === undefined) {
            		var dsgvmucrangbuoc = e.oldData.mucrangbuoc;
            	} else {
            		var dsgvmucrangbuoc = e.newData.mucrangbuoc;
            	}
            	axios.post('updatedanhsachgvcuatochuyenmonloc', {
            		matochuyenmon: dsgvchontochuyemon,
            		magiaoviennew: dsgvchongiaoviennew,
            		magiaovienold: dsgvchongiaovienold,
            		mamonhoc: dsgvchonmonhoc,
            		mucrangbuoc: dsgvmucrangbuoc
            	}).then(function(response) {
            		var data = response.data;
            		Swal.fire({
            			title: 'Lưu',
            			text: 'Đã lưu thành công',
            			icon: 'success',
            			confirmButtonText: 'OK'
            		});
            		reloaddsgvtocm();
            	});
            },
            onRowInserting: function(e) {
            	if (e.data.magiaovien === undefined) {
            		var dsgvchongiaovien = "";
            	} else {
            		var dsgvchongiaovien = e.data.magiaovien;
            	}

            	if (e.data.tocm === undefined) {
            		var dsgvchontochuyemon = "";
            	} else {
            		var dsgvchontochuyemon = e.data.tocm[0];
            	}

            	if (e.data.monhoc === undefined) {
            		var dsgvchonmonhoc = "";
            	} else {
            		var dsgvchonmonhoc = e.data.monhoc;
            	}


            	if (e.data.mucrangbuoc === undefined) {
            		var dsgvmucrangbuoc = "";
            	} else {
            		var dsgvmucrangbuoc = e.data.mucrangbuoc;
            	}
            	axios.post('adddanhsachgvcuatochuyenmonloc', {
            		matochuyenmon: dsgvchontochuyemon,
            		magiaovien: dsgvchongiaovien,
            		mamonhoc: dsgvchonmonhoc,
            		mucrangbuoc: dsgvmucrangbuoc
            	}).then(function(response) {
            		var data = response.data;
            		Swal.fire({
            			title: 'Lưu',
            			text: 'Đã thêm mới thành công',
            			icon: 'success',
            			confirmButtonText: 'OK'
            		});
            		reloaddsgvtocm();
            	});
            },
        }).dxDataGrid("instance");

function tagBoxEditorTemplate(cellElement, cellInfo) {
	return $("<div>").dxTagBox({
		dataSource: datamonhoc,
		value: cellInfo.value,
		valueExpr: "id",
		displayExpr: "tenmonhoc",
		showSelectionControls: true,
		maxDisplayedTags: 1,
		showMultiTagOnly: false,
		applyValueMode: "useButtons",
		searchEnabled: true,
		onValueChanged: function(e) {
			cellInfo.setValue(e.value);
		},
		onSelectionChanged: function(e) {
			cellInfo.component.updateDimensions();
		}
	});
}

function tagBoxEditorTemplate2(cellElement, cellInfo) {
	return $("<div>").dxTagBox({
		dataSource: datatocm,
		value: cellInfo.value,
		valueExpr: "id",
		displayExpr: "tentocm",
		showSelectionControls: true,
		maxDisplayedTags: 1,
		applyValueMode: "useButtons",
		searchEnabled: true,
		onValueChanged: function(e) {
			cellInfo.setValue(e.value);
		},
		onSelectionChanged: function(e) {
			cellInfo.component.updateDimensions();
		}
	});
}
});
}




function xoadsgvphancong(dataxoa) {
  Swal.fire({
    title: 'Lưu',
    text: "Bạn có muốn xóa phân công giáo viên này không",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.value) {
      axios.post('deldanhsachgvphancong',{id:dataxoa}).then(function (response) {
        var data = response.data;
        Swal.fire({
          position: 'center',
          icon: 'success',
          text: 'Đã xóa thành công',
          showConfirmButton: false,
          timer: 1000
        });   
        reloaddsgvtocm();
      });
    }           
  })
}




function xoadsgvphancongall(dataxoahet) {
  Swal.fire({
    title: 'Lưu',
    text: "Bạn có muốn xóa phân công giáo viên này không",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.value) {
      axios.post('deldanhsachgvphancongall',{id:dataxoahet}).then(function (response) {
        var data = response.data;
        Swal.fire({
          position: 'center',
          icon: 'success',
          text: 'Đã xóa thành công',
          showConfirmButton: false,
          timer: 1000
        });   
        reloaddsgvtocm();
      });
    }           
  })
}