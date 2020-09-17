function reload_tiethopcuato() {
    tiethopcuato();
    var dataGrid = $("#girdtiethopcuato").dxDataGrid("instance");
    // dataGrid.clearSelection();
    dataGrid.refresh();
    dataGrid.reload();
}

function tiethopcuato() {
	axios.get('gettiethopcuato').then(function(response) {
		var data1 = response.data;
		axios.get('getdanhsachtochuyenmon').then(function(response){
			var data2 = response.data;

		var data3 = [{
		    "id": 0,
		    "tenbuoi": "Sáng"
		}, {
		    "id": 1,
		    "tenbuoi": "Chiều"
		}]

		var data4 = [{
		    "id": 2,
		    "tenthu": "Thứ 2"
		}, {
		    "id": 3,
		    "tenthu": "Thứ 3"
		},{
		    "id": 4,
		    "tenthu": "Thứ 4"
		},{
		    "id": 5,
		    "tenthu": "Thứ 5"
		},{
		    "id": 6,
		    "tenthu": "Thứ 6"
		},{
		    "id": 7,
		    "tenthu": "Thứ 7"
		}]

		var data5 = [{
		    "id": 0,
		    "tentiet": "Cả buổi"
		}, {
		    "id": 1,
		    "tentiet": "Tiết 1"
		},{
		    "id": 2,
		    "tentiet": "Tiết 2"
		},{
		    "id": 3,
		    "tentiet": "Tiết 3"
		},{
		    "id": 4,
		    "tentiet": "Tiết 4"
		},{
		    "id": 5,
		    "tentiet": "Tiết 5"
		}]

		$("#girdtiethopcuato").dxDataGrid({
			dataSource: data1,
			showBorders: true,
			paging: {
				enabled: false
			},
			editing: {
				mode: "row",
				allowUpdating: true,
				allowDeleting: true,
				allowAdding: true
			}, 
			columns: [
			{
				caption: "Tên tổ chuyên môn",				
				dataField: "matochuyenmon",
				lookup: {
                    dataSource: data2,
                    displayExpr: "tentocm",
                    valueExpr: "id"
                }
			},
			{
				caption: "Buổi",				
				dataField: "buoi",
				lookup: {
                    dataSource: data3,
                    displayExpr: "tenbuoi",
                    valueExpr: "id"
                }
			},
			{
				caption: "Thứ",				
				dataField: "thu",
				lookup: {
                    dataSource: data4,
                    displayExpr: "tenthu",
                    valueExpr: "id"
                }
			},
			{
				caption: "Tiết",				
				dataField: "tiet",
				lookup: {
                    dataSource: data5,
                    displayExpr: "tentiet",
                    valueExpr: "id"
                }
			}
			],
			//thêm
            onRowInserting: function(e) {
            	var newData = e.data;
            	var idtcm = newData.matochuyenmon;
            	var buoi = newData.buoi;
            	var thu = newData.thu;
            	var tiet = newData.tiet;
            	if(newData != "undefined"){
            		axios.post('addtiethopcuato', {
                        idtcm: idtcm,
                        buoi: buoi,
                        thu: thu,
                        tiet: tiet,
                    }).then(function(response) {
                        var data = response.data;
                        if(data == 1){
                            Swal.fire({
                            title: 'Lưu',
                                text: 'Đã lưu thành công',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            reload_tiethopcuato();
                        }
                        
                    });                 
            	}
        	},
        	//sửa
        	onRowUpdating: function(e) {
            	var oldData = e.oldData;
            	var newData = e.newData;
            	var mtccm = "matochuyenmon";
            	var mbuoi = "buoi";
            	var mthu = "thu";
            	var mtiet = "tiet";
            	var id = oldData.id;
            	var idtcm;
            	var buoi;
            	var thu;
            	var tiet;

        		if (mtccm in newData) {
        			idtcm = newData.matochuyenmon;
        		}else{
        			idtcm = oldData.matochuyenmon;
        		}

        		if (mbuoi in newData) {
        			buoi = newData.buoi;
        		}else{
        			buoi = oldData.buoi;
        		}

        		if (mthu in newData) {
        			thu = newData.thu;
        		}else{
        			thu = oldData.thu;
        		}

        		if (mtiet in newData) {
        			tiet = newData.tiet;
        		}else{
        			tiet = oldData.tiet;
        		}
        		
            	axios.post('updatetiethopcuato', {
            		id: id,
            		idtcm: idtcm,
                    buoi: buoi,
                    thu: thu,
                   	tiet: tiet,
            	}).then(function(response) {
            		var data = response.data;
            		if(data == 1){
                        Swal.fire({
                        title: 'Cập nhật',
                            text: 'Cập nhật thành công',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        reload_tiethopcuato();
                    }
            	});
            },
        	//xoá
        	onRowRemoving: function(e) {
            	var data = e.data;
            	var id = data.id;
            	if(data != "undefined"){
            		axios.post('deltiethopcuato', {
                        id: id,
                    }).then(function(response) {
                        var data = response.data;
                        if(data == 1){
                            Swal.fire({
                            title: 'Xoá',
                                text: 'Xoá thành công',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            reload_tiethopcuato();
                        }
                        
                    });                 
            	}
        	},
        });
        });
		//
	});
}